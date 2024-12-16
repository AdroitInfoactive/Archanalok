document.addEventListener('DOMContentLoaded', () => {
    const mediaContainer = document.getElementById('media-container');
    const fileInput = document.getElementById('file-input');
    const deleteButton = document.getElementById('delete-selected');
    const uploadedFiles = []; // Array to store newly uploaded files
    const existingFiles = []; // Array to store existing files

    // Initialize Sortable.js
    new Sortable(mediaContainer, {
        animation: 150,
        handle: '.media-item',
        draggable: '.media-item',
        onEnd: updateImageOrder,
    });

    // Prepopulate existing files into the array
    document.querySelectorAll('.media-item').forEach((item, index) => {
        const imageId = item.dataset.id;
        existingFiles.push({
            id: imageId,
            order: index,
        });
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
                order: uploadedFiles.length,
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
            const fileId = item.dataset.id;

            // Remove from uploadedFiles or existingFiles
            if (tempId) {
                const fileIndex = uploadedFiles.findIndex((fileObj) => fileObj.tempId === tempId);
                uploadedFiles.splice(fileIndex, 1);
            } else if (fileId) {
                const fileIndex = existingFiles.findIndex((fileObj) => fileObj.id === fileId);
                existingFiles.splice(fileIndex, 1);
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

        // Map current DOM order to the uploadedFiles and existingFiles arrays
        Array.from(mediaContainer.children)
            .filter((item) => !item.classList.contains('add-image-placeholder'))
            .forEach((item, index) => {
                const tempId = item.dataset.tempId;
                const fileId = item.dataset.id;

                if (tempId) {
                    const fileObject = uploadedFiles.find((fileObj) => fileObj.tempId === tempId);
                    if (fileObject) {
                        fileObject.order = index; // Update order
                        reorderedFiles.push(fileObject); // Add fileObject in the new order
                    }
                } else if (fileId) {
                    const fileObject = existingFiles.find((fileObj) => fileObj.id === fileId);
                    if (fileObject) {
                        fileObject.order = index; // Update order
                        reorderedFiles.push(fileObject); // Add fileObject in the new order
                    }
                }
            });

        // Update arrays with new order
        uploadedFiles.length = 0; // Clear the array
        existingFiles.length = 0;
        reorderedFiles.forEach((file) => {
            if (file.tempId) uploadedFiles.push(file);
            else existingFiles.push(file);
        });

        console.log('Updated uploadedFiles:', uploadedFiles);
        console.log('Updated existingFiles:', existingFiles);
    }

    // Handle Form Submission
    const form = document.querySelector('#product-form');
    if (!form) {
        console.error('Form not found in DOM');
        return;
    }

    form.addEventListener('submit', (event) => {
        event.preventDefault(); // Prevent default form submission

        const formData = new FormData(form);

        // Append new files and their order
        uploadedFiles.forEach((file) => {
            formData.append('media[]', file.file);
            formData.append('media_order[]', file.order);
        });

        // Append existing file IDs and their order
        existingFiles.forEach((file) => {
            formData.append('existing_media_ids[]', file.id);
            formData.append('existing_media_order[]', file.order);
        });

        // Submit via AJAX
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value, // Laravel CSRF Token
            },
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.status === 'error') {
                    if (data.errors) {
                        Object.values(data.errors).forEach((errorMessages) => {
                            errorMessages.forEach((message) => {
                                toastr.error(message);
                            });
                        });
                    } else {
                        toastr.error(data.message || 'An error occurred.');
                    }
                } else {
                    toastr.success(data.message || 'Product updated successfully!');
                    setTimeout(() => {
                        window.location.href = '/admin/products';
                    }, 2000);
                }
            })
            .catch((error) => {
                toastr.error('An unexpected error occurred.');
                console.error(error);
            });
    });
});
