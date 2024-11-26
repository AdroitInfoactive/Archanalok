@extends('admin.layouts.master')

@section('content')
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
                    <div class="card-header">Product Details</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" id="title" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control summernote"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="media">Media</label>
                            <div id="media-uploader" class="dropzone">
                                <div class="dz-message">Drag & drop files here or click to upload</div>
                            </div>
                        </div>
                        
                        <!-- Hidden file input for selecting multiple images -->
                        <input type="file" id="file-input" name="media[]" accept="image/*" style="display: none;" multiple>
                        
                        
                        <div class="form-group">
                            <label for="is_variant">Product Has Variant</label>
                            <div class="form-check">
                                <input type="checkbox" name="is_variant" id="is_variant" class="form-check-input">
                                <label for="is_variant" class="form-check-label">Yes</label>
                            </div>
                        </div>

                        <!-- Price Section -->
                        <div id="price_section" class="d-none">
                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="number" name="price" id="price" class="form-control">
                            </div>
                        </div>

                        <!-- Variant Selection -->
                        <div id="variants_section" class="d-none">
                            <div class="form-group">
                                <label for="variant_masters">Select Variant Masters</label>
                                <select name="variant_masters[]" id="variant_masters" class="form-control select2" multiple>
                                    @foreach ($variantMasters as $variantMaster)
                                        <option value="{{ $variantMaster->id }}">{{ $variantMaster->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <button type="button" id="generate_variants" class="btn btn-primary btn-sm">Generate Variants</button>
                            </div>

                            <div class="form-group">
                                <label>Generated Variants</label>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Variant</th>
                                            <th>Price</th>
                                            <th>Stock</th>
                                        </tr>
                                    </thead>
                                    <tbody id="variant_list">
                                        <!-- Generated rows will appear here -->
                                    </tbody>
                                </table>
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const isVariantCheckbox = document.getElementById('is_variant');
        const priceSection = document.getElementById('price_section');
        const variantsSection = document.getElementById('variants_section');
        const generateVariantsBtn = document.getElementById('generate_variants');
        const variantList = document.getElementById('variant_list');
        const variantMasters = document.getElementById('variant_masters');

        // Toggle sections based on checkbox
        isVariantCheckbox.addEventListener('change', function() {
            if (this.checked) {
                priceSection.classList.add('d-none');
                variantsSection.classList.remove('d-none');
            } else {
                priceSection.classList.remove('d-none');
                variantsSection.classList.add('d-none');
            }
        });

        // Generate variant combinations
        generateVariantsBtn.addEventListener('click', function() {
            const selectedOptions = Array.from(variantMasters.selectedOptions).map(option => option.text);
            
            if (selectedOptions.length === 0) {
                alert('Please select at least one variant master.');
                return;
            }

            variantList.innerHTML = ''; // Clear previous variants

            // Generate combinations (example: Color-Size)
            const combinations = getCombinations(selectedOptions);

            combinations.forEach(combination => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${combination}</td>
                    <td><input type="number" name="variant_prices[]" class="form-control" placeholder="Price"></td>
                    <td><input type="number" name="variant_stocks[]" class="form-control" placeholder="Stock"></td>
                `;
                variantList.appendChild(row);
            });
        });

        // Helper function to generate combinations
        function getCombinations(array) {
            const result = [];
            const helper = (prefix, index) => {
                for (let i = index; i < array.length; i++) {
                    const current = prefix ? `${prefix}-${array[i]}` : array[i];
                    result.push(current);
                    helper(current, i + 1);
                }
            };
            helper('', 0);
            return result;
        }
    });
    Dropzone.options.mediaUploader = {
        url: '/your-upload-url', // Set your upload URL here
        maxFilesize: 2, // Maximum file size in MB
        acceptedFiles: "image/*", // Only image files allowed
        autoProcessQueue: false, // Disable automatic file processing on drop
        addRemoveLinks: true, // Optionally show remove links
        init: function() {
            var dz = this;

            // Handle when files are added to Dropzone
            this.on("addedfile", function(file) {
                // If using the hidden file input, trigger it
                document.getElementById('file-input').click();
            });

            // Optionally handle success and error cases
            this.on("success", function(file, response) {
                // Handle success response, if needed
            });
        }
    };

    // Trigger file input click on dropzone click
    document.getElementById('media-uploader').addEventListener('click', function () {
        document.getElementById('file-input').click();
    });

    // When a file is selected via file input, add it to Dropzone
    document.getElementById('file-input').addEventListener('change', function (e) {
        var files = e.target.files;
        for (var i = 0; i < files.length; i++) {
            // Manually add the selected files to Dropzone
            Dropzone.forElement("#media-uploader").addFile(files[i]);
        }
    });

</script>
@endpush

