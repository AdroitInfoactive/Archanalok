@extends('admin.layouts.master')


@section('content')
<style>
    /* Media Container */
    .media-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 15px;
    }

    /* Media Item */
    .media-item {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #f9f9f9;
        overflow: hidden;
    }

    /* Larger First Image */
    .media-item-large {
        width: 200px;
        height: 200px;
    }

    /* Smaller Images */
    .media-item-small,
    .add-image-placeholder {
        width: 120px;
        height: 120px;
    }

    /* Image Styling */
    .media-item img {
        width: 100%;
        /* Fit inside container */
        height: 100%;
        /* Fit inside container */
        object-fit: cover;
    }

    /* Checkbox Styling */
    .image-checkbox {
        position: absolute;
        top: 5px;
        left: 5px;
        z-index: 10;
    }

    /* Add Image Placeholder */
    .add-image-placeholder {
        border: 2px dashed #ccc;
        cursor: pointer;
        background-color: #f9f9f9;
    }

    /* Delete Button */
    #delete-selected {
        position: relative;
        z-index: 5;
    }

    /* Media Container */
    .media-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 15px;
    }

    /* Media Item */
    .media-item {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #f9f9f9;
        overflow: hidden;
    }

    /* Larger First Image */
    .media-item-large {
        width: 200px;
        height: 200px;
    }

    /* Smaller Images */
    .media-item-small,
    .add-image-placeholder {
        width: 200px;
        height: 200px;
    }

    /* Image Styling */
    .media-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Checkbox Styling */
    .image-checkbox {
        position: absolute;
        top: 5px;
        left: 5px;
        z-index: 10;
    }

    /* Add Image Placeholder */
    .add-image-placeholder {
        border: 2px dashed #ccc;
        cursor: pointer;
        background-color: #f9f9f9;
    }

    .add-image-placeholder:hover {
        background-color: #eaeaea;
    }

    .add-image-icon {
        width: 100px;
        /* Fixed size for SVG icon container */
        height: 40px;
    }

    .add-image-icon svg {
        width: 100%;
        height: 100%;
    }

    /* Drag-and-Drop Styling */
    .dropzone {
        position: relative;
        min-height: 200px;
        border: 2px dashed #ccc;
        border-radius: 10px;
        padding: 10px;
        transition: background-color 0.3s ease;
    }

    .dropzone.dragover {
        background-color: #f1f8ff;
        border-color: #007bff;
    }

</style>
<section class="section">
    <div class="section-header">
        <h1>Create Product</h1>
    </div>
</section>

<div class="container">
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Product Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" id="title" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control summernote"></textarea>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5>Images</h5>
                            <button type="button" id="delete-selected" class="btn btn-danger d-none">Delete
                                Selected</button>
                        </div>

                        <!-- Media Container -->
                        <div id="media-container" class="media-container d-flex flex-wrap gap-3 dropzone">
                            <!-- Existing images will appear here -->
                            @if(isset($product) && $product->images)
                                @foreach($product->images as $image)
                                    <div class="media-item {{ $loop->first ? 'media-item-large' : 'media-item-small' }}"
                                        data-id="{{ $image->id }}">
                                        <input type="checkbox" class="image-checkbox" data-id="{{ $image->id }}">
                                        <img src="{{ asset('storage/' . $image->path) }}"
                                            alt="Product Image" class="img-thumbnail">
                                    </div>
                                @endforeach
                            @endif

                            <!-- Add Image Placeholder -->
                            <div class="media-item add-image-placeholder" id="add-image-placeholder">
                                <label for="file-input">
                                    <div class="add-image-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="svg-icon">
                                            <line x1="12" y1="5" x2="12" y2="19"></line>
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                        </svg> or <br> Drap & Drop to Upload Files
                                    </div>
                                </label>
                                <input type="file" id="file-input" name="media[]" class="d-none" accept="image/*"
                                    multiple>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-success">Save Product</button>
    </form>
</div>
@endsection

@push('scripts')

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        const mediaContainer = document.getElementById('media-container');
        const deleteButton = document.getElementById('delete-selected');

        // Initialize Sortable
        new Sortable(mediaContainer, {
            animation: 150,
            handle: '.media-item',
            draggable: '.media-item',
            onEnd: () => {
                updateImageOrder();
            }
        });

        // File Input Change Handler
        document.getElementById('file-input').addEventListener('change', (event) => {
            const files = Array.from(event.target.files);

            files.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const div = document.createElement('div');
                    div.classList.add('media-item', 'media-item-small');
                    div.innerHTML = `
                        <input type="checkbox" class="image-checkbox">
                        <img src="${e.target.result}" alt="Uploaded Image">
                    `;
                    mediaContainer.insertBefore(div, document.getElementById(
                        'add-image-placeholder'));
                };
                reader.readAsDataURL(file);
            });

            // Clear input to allow same file uploads
            event.target.value = '';
        });

        // Handle Checkbox Selection
        mediaContainer.addEventListener('change', () => {
            const selectedCheckboxes = document.querySelectorAll('.image-checkbox:checked');
            deleteButton.classList.toggle('d-none', selectedCheckboxes.length === 0);
        });

        // Delete Selected Images
        deleteButton.addEventListener('click', () => {
            const selected = Array.from(document.querySelectorAll('.image-checkbox:checked')).map(cb => cb
                .closest('.media-item'));

            if (selected.length === 0) {
                alert('No images selected!');
                return;
            }

            selected.forEach(item => item.remove());
            deleteButton.classList.add('d-none');
        });

        // Update Image Order (AJAX request placeholder)
        function updateImageOrder() {
            const order = Array.from(mediaContainer.children)
                .filter((item) => !item.classList.contains('add-image-placeholder'))
                .map((item, index) => ({
                    id: item.dataset.id,
                    order: index
                }));

            console.log('Updated order:', order);
            // Perform AJAX request if necessary
        }

        document.addEventListener('DOMContentLoaded', () => {
            const mediaContainer = document.getElementById('media-container');
            const fileInput = document.getElementById('file-input');

            // Add event listeners for drag-and-drop
            mediaContainer.addEventListener('dragover', (event) => {
                event.preventDefault();
                mediaContainer.classList.add('dragover');
            });

            mediaContainer.addEventListener('dragleave', (event) => {
                event.preventDefault();
                mediaContainer.classList.remove('dragover');
            });

            mediaContainer.addEventListener('drop', (event) => {
                event.preventDefault();
                mediaContainer.classList.remove('dragover');

                const files = Array.from(event.dataTransfer.files);
                handleFiles(files);
            });

            // File Input Change Event
            fileInput.addEventListener('change', (event) => {
                const files = Array.from(event.target.files);
                handleFiles(files);
            });

            // Function to handle dropped or selected files
            function handleFiles(files) {
                files.forEach((file) => {
                    if (!file.type.startsWith('image/')) {
                        alert('Only image files are allowed.');
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const div = document.createElement('div');
                        div.classList.add('media-item', 'media-item-small');
                        div.innerHTML = `
        <input type="checkbox" class="image-checkbox">
        <img src="${e.target.result}" alt="Uploaded Image">
        `;
                        mediaContainer.insertBefore(div, document.getElementById(
                            'add-image-placeholder'));
                    };
                    reader.readAsDataURL(file);
                });

                // Reset the file input to allow re-uploading the same file
                fileInput.value = '';
            }
        });

    </script>
@endpush
