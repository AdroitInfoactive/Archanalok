document.addEventListener('DOMContentLoaded', () => {
    const mediaContainer = document.getElementById('media-container');
    const fileInput = document.getElementById('file-input');
    const deleteButton = document.getElementById('delete-selected');
    const uploadedFiles = [];
    const deletedImageIds = [];

    new Sortable(mediaContainer, {
        animation: 150,
        handle: '.media-item',
        draggable: '.media-item',
        onEnd: updateImageOrder
    });

    fileInput.addEventListener('change', (event) => {
        const files = Array.from(event.target.files);
        files.forEach((file) => {
            const tempId = `file-${uploadedFiles.length + 1}`;
            file.tempId = tempId;
            uploadedFiles.push({ file, tempId, order: uploadedFiles.length });
            addMediaItem(file, tempId);
        });
        fileInput.value = '';
    });

    function addMediaItem(file, tempId) {
        const reader = new FileReader();
        reader.onload = (e) => {
            const div = document.createElement('div');
            div.classList.add('media-item', 'media-item-small');
            div.setAttribute('data-temp-id', tempId);
            div.innerHTML = `
                <input type="checkbox" class="image-checkbox">
                <img src="${e.target.result}" alt="Uploaded Image">
            `;
            mediaContainer.insertBefore(div, document.getElementById('add-image-placeholder'));
        };
        reader.readAsDataURL(file);
    }

    mediaContainer.addEventListener('dragover', (e) => e.preventDefault());
    mediaContainer.addEventListener('drop', (event) => {
        event.preventDefault();
        const files = Array.from(event.dataTransfer.files);
        files.forEach((file) => {
            const tempId = `file-${uploadedFiles.length + 1}`;
            file.tempId = tempId;
            uploadedFiles.push({ file, tempId, order: uploadedFiles.length });
            addMediaItem(file, tempId);
        });
    });

    deleteButton.addEventListener('click', () => {
        const selected = Array.from(document.querySelectorAll('.image-checkbox:checked')).map(cb => cb.closest('.media-item'));
        if (!selected.length) return alert('No images selected!');

        selected.forEach((item) => {
            const imageId = item.dataset.id;
            if (imageId) deletedImageIds.push(imageId);
            item.remove();
        });

        updateImageOrder();
        deleteButton.classList.add('d-none');
    });

    mediaContainer.addEventListener('change', () => {
        const selectedCheckboxes = document.querySelectorAll('.image-checkbox:checked');
        deleteButton.classList.toggle('d-none', selectedCheckboxes.length === 0);
    });

    function updateImageOrder() {
        const reorderedFiles = [];

        Array.from(mediaContainer.children)
            .filter((item) => !item.classList.contains('add-image-placeholder'))
            .forEach((item, index) => {
                const tempId = item.dataset.tempId;
                const fileObject = uploadedFiles.find((fileObj) => fileObj.tempId === tempId);
                if (fileObject) {
                    fileObject.order = index;
                    reorderedFiles.push(fileObject);
                }
            });

        uploadedFiles.length = 0;
        reorderedFiles.forEach((file) => uploadedFiles.push(file));
    }

    const form = document.querySelector('#product-form');
    form.addEventListener('submit', (event) => {
        event.preventDefault();
        const formData = new FormData(form);

        const orderedItems = Array.from(mediaContainer.children)
            .filter(item => !item.classList.contains('add-image-placeholder'));

        orderedItems.forEach((item, index) => {
            const tempId = item.dataset.tempId;
            const imageId = item.dataset.id;
            if (tempId) {
                const fileObject = uploadedFiles.find(f => f.tempId === tempId);
                if (fileObject) {
                    formData.append('media[]', fileObject.file);
                    formData.append('media_order[]', index);
                }
            } else if (imageId) {
                formData.append(`existing_media_order[${imageId}]`, index);
            }
        });

        // ✅ FIXED: This must be INSIDE form submit
        deletedImageIds.forEach(id => {
            formData.append('deleted_media[]', id);
        });

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'error') {
                Object.values(data.errors || {}).flat().forEach(msg => toastr.error(msg));
            } else {
                toastr.success(data.message || 'Product updated successfully!');
                setTimeout(() => window.location.href = data.path, 2000);
            }
        })
        .catch(err => {
            toastr.error('Unexpected error');
            console.error(err);
        });
    });
    
});

function previewImage(event, variationCode) {
    const file = event.target.files[0];
    const preview = document.getElementById(`preview-${variationCode}`);
    const reader = new FileReader();

    if (file) {
        reader.onload = () => {
            preview.src = reader.result; // Set the image source
            preview.classList.remove('d-none'); // Make the image visible
        };
        reader.readAsDataURL(file); // Read the file to get the data URL
    }
}

// PHP data → JS

document.addEventListener('DOMContentLoaded', () => {
  const yes    = document.getElementById('variants_yes');
  const no     = document.getElementById('variants_no');
  const varDiv = document.querySelector('.variation-yes');
  const prDiv  = document.querySelector('.variation-no');
  const genBtn = document.getElementById('generate-variations');
  const body   = document.getElementById('variations-body');
  const tbl    = document.getElementById('variations-table');

  // show/hide sections
  function toggleSections() {
    if (yes.checked) {
      varDiv.classList.remove('d-none');
      prDiv .classList.add   ('d-none');
    } else {
      varDiv.classList.add   ('d-none');
      prDiv .classList.remove('d-none');
    }
  }
  yes.addEventListener('change', toggleSections);
  no .addEventListener('change', toggleSections);
  toggleSections();

  // build one <tr>
  function buildRow(code,data) {
  //  console.log(data);
    const skuVal = data.sku ? data.sku : (baseSku ? baseSku + '-' + code : '');
    const status = (data.status === 0 ? 0 : 1);
     // decide whether there's already an image
  const hasImg = !!data.image_path;              // your key may be `image_path`, `image`, etc.
  const imgSrc = hasImg ? data.image_path : '';  // URL on your existingVariants map
    return `
      <tr data-code="${code}">
     <td> <div class="image-upload-box">
        <label for="image-upload-${code}" class="image-label">
          <img  id="preview-${code}" src="${imgSrc}"  class="uploaded-image ${hasImg ? '' : 'd-none'}" alt="Variation ${code}" >
          <svg  xmlns="http://www.w3.org/2000/svg" 
            viewBox="0 0 24 24"  fill="none"   stroke="currentColor"  stroke-width="2" stroke-linecap="round"   stroke-linejoin="round"  class="icon ${hasImg ? 'd-none' : ''}"  >
            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
            <line x1="12" y1="8" x2="12" y2="16"></line>
            <line x1="8" y1="12" x2="16" y2="12"></line>
          </svg>
        </label>
        <input   type="file"   id="image-upload-${code}"  name="variation_images[]"   class="d-none"  accept="image/*"   onchange="previewImage(event, '${code}')" >
      </div>
    </td>
        <td>${code}<input type="hidden" name="variation_codes[]" value="${code}"></td>
        <td><input name="skus[]" class="form-control" value="${skuVal}"></td>
        <td><input name="sale_prices[]" type="number" step="0.01" placeholder="0 or 0.00" class="form-control" value="${data.sale_price||''}"></td>
        <td><input name="offer_prices[]" type="number" step="0.01" placeholder="0 or 0.00" class="form-control" value="${data.offer_price||''}"></td>
        <td><input name="distributor_prices[]" type="number" step="0.01" placeholder="0 or 0.00" class="form-control" value="${data.distributor_price||''}"></td>
        <td><input name="min_order_qtys[]" type="number" class="form-control" placeholder="0 or 0.00" value="${data.min_order_qty||''}"></td>
        <td><input name="wholesale_prices[]" type="number" step="0.01" class="form-control" placeholder="0 or 0.00" value="${data.wholesale_price||''}"></td>
        <td><input name="weights[]" type="number" step="0.01" class="form-control" placeholder="0 or 0.00" value="${data.weight||''}"></td>
        <td><input name="qtys[]" type="number" class="form-control" placeholder="0 or 0.00" value="${data.qty||''}"></td>
        <td>
          <select name="statuses[]" class="form-control">
          <option value="1"${status===1?' selected':''}>Active</option>
          <option value="0"${status===0?' selected':''}>Inactive</option>
          </select>
        </td>
      </tr>`;
  }

 

  // generate/re‑generate all
  genBtn.addEventListener('click', () => {
    body.innerHTML = '';
    // collect selected master/details
    const variants = {};
    document.querySelectorAll('.variant-checkbox:checked').forEach(cb => {
      const m     = cb.dataset.masterid;
      const d     = cb.dataset.detail;
      const dId   = cb.dataset.detailid;
      variants[m] = variants[m]||[];
      variants[m].push({id:dId,name:d});
    });
    document.getElementById('variant-master-detail').value = JSON.stringify(variants);

    // cartesian product
    const lists = Object.values(variants).map(a=>a.map(x=>x.name));
    const combine = (arr,prefix=[]) =>
      !arr.length ? [prefix] : arr[0].flatMap(v=>combine(arr.slice(1),prefix.concat(v)));
    combine(lists).forEach(codeArr=>{
      const code = codeArr.join('/');
      const data = existingVariants[code]||{};
      body.insertAdjacentHTML('beforeend', buildRow(code,data));
    });
    tbl.classList.toggle('d-none', !body.children.length);
  });

  // on load, auto‑generate if variants = Yes
  if (yes.checked) genBtn.click();
});


document.addEventListener('DOMContentLoaded', () => {
    const generateButton = document.getElementById('generate-variations');
    const variationsTable = document.getElementById('variations-table');
    const variationsBody = document.getElementById('variations-body');
    const deleteSelectedButton = document.getElementById('delete-selected-variations');
    const selectAllCheckbox = document.getElementById('select-all');
    const baseSkuField = document.getElementById('sku')
    const masterDetailField = document.getElementById('variant-master-detail');

    // Generate variations on button click
    generateButton.addEventListener('click', () => {
        const checkboxes = document.querySelectorAll('.variant-checkbox:checked');
        const variants = {};

        // Group selected details by their master
        checkboxes.forEach(checkbox => {
            const masterId = checkbox.dataset.masterid; // Master ID
            const masterName = checkbox.dataset.master; // Master Name
            const detailId = checkbox.dataset.detailid; // Detail ID
            const detailName = checkbox.dataset.detail; // Detail Name

            if (!variants[masterId]) {
                variants[masterId] = {
                    name: masterName,
                    details: []
                };
            }
            variants[masterId].details.push({
                id: detailId,
                name: detailName
            });
        });

        masterDetailField.value = JSON.stringify(variants);

        // Generate all combinations
        const combinations = generateCombinations(
            Object.values(variants).map(variant => variant.details.map(detail => detail.name))
        );

        // Clear and display the table
        variationsBody.innerHTML = '';
        combinations.forEach((combination, index) => {
            const variationCode = combination.join('/'); // Generate variation code with /

            // Get the base SKU value
            const baseSku = baseSkuField ? baseSkuField.value.trim() : '';

            const row = document.createElement('tr');
            row.innerHTML = `
            <td>
                <input type="checkbox" class="delete-checkbox"> <!-- Checkbox for row selection -->
            </td>
            <td>
                <div class="image-upload-box">
                    <label for="image-upload-${variationCode}" class="image-label">
                        <img src="" alt="Preview" class="uploaded-image d-none" id="preview-${variationCode}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="12" y1="8" x2="12" y2="16"></line>
                            <line x1="8" y1="12" x2="16" y2="12"></line>
                        </svg>
                    </label>
                    <input type="file" id="image-upload-${variationCode}" name="variation_images[]" class="d-none"
                        accept="image/*" onchange="previewImage(event, '${variationCode}')">
                </div>
            </td>
            <td>
                ${variationCode}
            </td>
            <td>
                <input type="text" name="skus[]" class="form-control" value="${baseSku}-${variationCode}" placeholder="SKU" >
                <input type="hidden" name="variation_codes[]" value="${variationCode}">
            </td>
            <td><input type="number" name="sale_prices[]" class="form-control sale-price" step="0.01" placeholder="0 or 0.00" ></td>
            <td><input type="number" name="offer_prices[]" class="form-control offer-price" step="0.01" placeholder="0 or 0.00"></td>
            <td><input type="number" name="distributor_prices[]" class="form-control distributor-price" step="0.01" placeholder="0 or 0.00" ></td>
            <td><input type="number" name="min_order_qtys[]" class="form-control min-order-qty" min="1" placeholder="0" ></td>
            <td><input type="number" name="wholesale_prices[]" class="form-control wholesale-price" step="0.01" placeholder="0 or 0.00" ></td>
            <td><input type="number" name="weights[]" class="form-control weight" step="0.01" placeholder="0 or 0.00" ></td>
            <td><input type="number" name="qtys[]" class="form-control available-quantity" step="0.01" placeholder="0" ></td>
            <td>
                <select name="statuses[]" class="form-control">
                    <option value="1" selected>Active</option>
                    <option value="0">Inactive</option>
                </select>
            </td>
        `;
            variationsBody.appendChild(row);
        });

        // Attach event listeners to the first row fields
        attachSyncListeners();
        toggleDeleteButtonVisibility();
        variationsTable.classList.remove('d-none');
    });

    // Function to generate all combinations of selected variants
    function generateCombinations(arrays, prefix = []) {
        if (arrays.length === 0) return [prefix];
        const result = [];
        const firstArray = arrays[0];
        const restArrays = arrays.slice(1);
        firstArray.forEach(value => {
            result.push(...generateCombinations(restArrays, [...prefix, value]));
        });
        return result;
    }

    // Function to attach event listeners to the first row
    function attachSyncListeners() {
        const firstRow = variationsBody.querySelector('tr:first-child');

        // Fields to sync
        const salePriceField = firstRow.querySelector('.sale-price');
        const offerPriceField = firstRow.querySelector('.offer-price');
        const distributorPriceField = firstRow.querySelector('.distributor-price');
        const minOrderQtyField = firstRow.querySelector('.min-order-qty');
        const wholesalePriceField = firstRow.querySelector('.wholesale-price');
        const weightField = firstRow.querySelector('.weight');
        const quantityField = firstRow.querySelector('.available-quantity');

        // Sync changes to all rows
        salePriceField.addEventListener('input', () => syncFieldToAll('.sale-price', salePriceField.value));
        offerPriceField.addEventListener('input', () => syncFieldToAll('.offer-price', offerPriceField.value));
        distributorPriceField.addEventListener('input', () => syncFieldToAll('.distributor-price', distributorPriceField.value));
        minOrderQtyField.addEventListener('input', () => syncFieldToAll('.min-order-qty', minOrderQtyField.value));
        wholesalePriceField.addEventListener('input', () => syncFieldToAll('.wholesale-price', wholesalePriceField.value));
        weightField.addEventListener('input', () => syncFieldToAll('.weight', weightField.value));
        quantityField.addEventListener('input', () => syncFieldToAll('.available-quantity', quantityField.value));
    }

    // Function to sync a field's value to all rows without locking individual editing
    function syncFieldToAll(selector, value) {
        const fields = variationsBody.querySelectorAll(selector);
        fields.forEach((field, index) => {
            if (index > 0 && !field.classList.contains('user-edited')) { // Skip first row and user-edited rows
                field.value = value;
            }
        });
    }

    // Function to mark a field as user-edited
    variationsBody.addEventListener('input', (event) => {
        if (event.target.tagName === 'INPUT' || event.target.tagName === 'SELECT') {
            event.target.classList.add('user-edited');
        }
    });

    // Show or hide delete button based on selected rows
    function toggleDeleteButtonVisibility() {
        const hasSelected = variationsBody.querySelectorAll('.delete-checkbox:checked').length > 0;
        deleteSelectedButton.classList.toggle('d-none', !hasSelected);
    }

    // Delete selected rows
    deleteSelectedButton.addEventListener('click', () => {
        const selectedRows = variationsBody.querySelectorAll('.delete-checkbox:checked');
        selectedRows.forEach(row => row.closest('tr').remove());
        toggleDeleteButtonVisibility();
    });

    // Select or deselect all rows
    selectAllCheckbox.addEventListener('change', () => {
        const allCheckboxes = variationsBody.querySelectorAll('.delete-checkbox');
        allCheckboxes.forEach(checkbox => {
            checkbox.checked = selectAllCheckbox.checked;
        });
        toggleDeleteButtonVisibility();
    });

    // Handle individual checkbox changes
    variationsBody.addEventListener('change', (event) => {
        if (event.target.classList.contains('delete-checkbox')) {
            toggleDeleteButtonVisibility();
        }
    });

    // Function to preview the uploaded image
});