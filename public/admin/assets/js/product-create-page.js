document.addEventListener('DOMContentLoaded', () => {
    const mediaContainer = document.getElementById('media-container');
    const fileInput = document.getElementById('file-input');
    const deleteButton = document.getElementById('delete-selected');
    const uploadedFiles = []; // Array to store uploaded files

    // Initialize Sortable.js
    new Sortable(mediaContainer, {
        animation: 150,
        handle: '.media-item',
        draggable: '.media-item',
        onEnd: updateImageOrder,
    });

    // File Input Change Event Handler
    fileInput.addEventListener('change', (event) => {
        const files = Array.from(event.target.files);
        files.forEach((file) => {
            // Assign a unique tempId to each file
            const tempId = `file-${uploadedFiles.length + 1}`;
            file.tempId = tempId;

            // Add file to uploadedFiles array
            uploadedFiles.push({
                file,
                tempId,
                order: uploadedFiles.length
            });

            // Add media item preview to the DOM
            addMediaItem(file, tempId);
        });

        fileInput.value = ''; // Reset input to allow re-uploading the same file
    });

    // Function to Add Media Item Preview
    function addMediaItem(file, tempId) {
        const reader = new FileReader();
        reader.onload = (e) => {
            const div = document.createElement('div');
            div.classList.add('media-item', 'media-item-small');
            div.setAttribute('data-temp-id', tempId); // Set tempId on the DOM element

            div.innerHTML = `
            <input type="checkbox" class="image-checkbox">
            <img src="${e.target.result}" alt="Uploaded Image">
        `;
            mediaContainer.insertBefore(div, document.getElementById('add-image-placeholder'));
        };
        reader.readAsDataURL(file);
    }

    // Handle Drag-and-Drop File Upload
    mediaContainer.addEventListener('dragover', (event) => {
        event.preventDefault();
        mediaContainer.classList.add('dragover');
    });

    mediaContainer.addEventListener('dragleave', () => {
        mediaContainer.classList.remove('dragover');
    });

    mediaContainer.addEventListener('drop', (event) => {
        event.preventDefault();
        mediaContainer.classList.remove('dragover');

        const files = Array.from(event.dataTransfer.files);
        files.forEach((file) => {
            uploadedFiles.push(file);
            addMediaItem(file);
        });
    });

    // Delete Selected Images
    deleteButton.addEventListener('click', () => {
        const selected = Array.from(document.querySelectorAll('.image-checkbox:checked')).map((cb) =>
            cb.closest('.media-item')
        );

        if (selected.length === 0) {
            alert('No images selected!');
            return;
        }

        selected.forEach((item) => {
            const tempId = item.dataset.tempId;
            if (tempId) {
                const fileIndex = parseInt(tempId.split('-')[1], 10);
                uploadedFiles.splice(fileIndex, 1); // Remove file from array
            }
            item.remove(); // Remove from DOM
        });

        updateImageOrder(); // Ensure order is updated
        deleteButton.classList.add('d-none');
    });

    // Handle Checkbox Selection
    mediaContainer.addEventListener('change', () => {
        const selectedCheckboxes = document.querySelectorAll('.image-checkbox:checked');
        deleteButton.classList.toggle('d-none', selectedCheckboxes.length === 0);
    });

    // Update Image Order Function
    function updateImageOrder() {
        const reorderedFiles = [];

        // Map current DOM order to the uploadedFiles array
        Array.from(mediaContainer.children)
            .filter((item) => !item.classList.contains('add-image-placeholder'))
            .forEach((item, index) => {
                const tempId = item.dataset.tempId;
                const fileObject = uploadedFiles.find((fileObj) => fileObj.tempId === tempId);
                if (fileObject) {
                    fileObject.order = index; // Update order
                    reorderedFiles.push(fileObject); // Add fileObject in the new order
                }
            });

        // Replace the uploadedFiles array with the reordered array
        uploadedFiles.length = 0; // Clear the array
        reorderedFiles.forEach((file) => uploadedFiles.push(file)); // Update with new order

        console.log('Updated uploadedFiles:', uploadedFiles);
    }


    // Handle Form Submission
    const form = document.querySelector('#product-form');
    if (!form) {
        console.error('Form not found in DOM');
        return;
    }

    // Add event listener to the form
    form.addEventListener('submit', (event) => {
        event.preventDefault(); // Prevent default form submission

        const formData = new FormData(form);

        uploadedFiles.forEach((file) => {
            formData.append('media[]', file.file); // Append file
            formData.append('media_order[]', file.order); // Append order
        });

        // console.log([...formData.entries()]); // Debugging output

        // Submit via AJAX
        fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value, // Laravel CSRF Token
                },
            })
            .then(response => {
                    if (!response.ok) {
                        return response.json(); // Parse error response
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.status === 'error') {
                        if (data.errors) {
                            // Loop through validation errors and display them
                            Object.values(data.errors).forEach(errorMessages => {
                                errorMessages.forEach(message => {
                                    toastr.error(message);
                                });
                            });
                        } else {
                            toastr.error(data.message || 'An error occurred.');
                        }
                    } else {
                        toastr.success(data.message || 'Product created successfully!');
                        // redirect after success
                        setTimeout(() => {
                            window.location.href = '/admin/products';
                        }, 2000);
                    }
                })
                .catch(error => {
                    toastr.error('An unexpected error occurred.');
                    console.error(error);
                });
    });

});

document.addEventListener('DOMContentLoaded', function () {
    const variantsYes = document.getElementById('variants_yes');
    const variantsNo = document.getElementById('variants_no');
    const variationYesDiv = document.querySelector('.variation-yes');
    const variationNoDiv = document.querySelector('.variation-no');

    // Function to toggle visibility based on the selected option
    function toggleVariationDivs() {
        if (variantsYes.checked) {
            variationYesDiv.classList.remove('d-none');
            variationNoDiv.classList.add('d-none');
        } else if (variantsNo.checked) {
            variationNoDiv.classList.remove('d-none');
            variationYesDiv.classList.add('d-none');
        }
    }

    // Attach change event listeners to the radio buttons
    variantsYes.addEventListener('change', toggleVariationDivs);
    variantsNo.addEventListener('change', toggleVariationDivs);

    // Call the function on page load to handle pre-selected values
    toggleVariationDivs();
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
            debugger;
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
