@extends('admin.layouts.master')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Edit Product Category</h1>
        </div>
    </section>
    <div class="card card-primary">
        <div class="card-header">
            <h4>Edit Product Category</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.sub-category.update', $subcategory->id) }}" method="post"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Main Category</label>
                    <select name="main_category_id" class="form-control select2" id="mainCategorySelect">
                        <option value="">Select</option>
                        @foreach ($maincategories as $maincat)
                            <option value="{{ $maincat->id }}" @selected($subcategory->main_category_id == $maincat->id)>{{ $maincat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Category</label>
                    <select name="category_id" class="form-control select2" id="categorySelect">
                        <option value="">Select</option>
                        <!-- Options will be populated by JavaScript -->
                    </select>
                </div>

                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" value="{{ $subcategory->name }}" class="form-control">
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control summernote">{!! $subcategory->description !!}</textarea>
                </div>

                <div class="form-group">
                    <label>SEO Title</label>
                    <input type="text" name="seo_title" value="{!! $subcategory->seo_title !!}" class="form-control">
                </div>

                <div class="form-group">
                    <label>SEO Description</label>
                    <textarea name="seo_description" class="form-control">{!! $subcategory->seo_description !!}</textarea>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option @selected($subcategory->status === 1) value="1">Active</option>
                        <option @selected($subcategory->status === 0) value="0">Inactive</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Priority</label>
                    <input type="text" name="position" value="{!! $subcategory->position !!}" class="form-control">
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Logo *</label>
                            <div id="image-preview" class="image-preview logo">
                                <label for="image-upload" id="image-label">Choose logo</label>
                                <input type="file" name="logo" id="image-upload" />
                                <input type="hidden" name="old_logo" value="{{ @$subcategory->logo }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Image</label>
                            <div id="image-preview-2" class="image-preview img">
                                <label for="image-upload-2" id="image-label-2">Choose Image</label>
                                <input type="file" name="image" id="image-upload-2" />
                                <input type="hidden" name="old_image" value="{{ @$subcategory->image }}">
                            </div>
                        </div>
                    </div>
                </div>

                <button class="btn btn-primary btn-lg" type="submit">Update</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
                    // Populate categories based on selected main category
                    <
                    script >
                        $(document).ready(function() {
                            var selectedCategoryId =
                            "{{ $subcategory->category_id }}"; // Get the selected category ID from the PHP variable

                            // Populate categories based on selected main category
                            $('#mainCategorySelect').on('change', function() {
                                var mainCategoryId = this.value;
                                if (mainCategoryId) {
                                    $.ajax({
                                        type: "GET",
                                        url: "{{ route('admin.get-category.getCategoriesByMainCategory', '') }}/" +
                                            mainCategoryId,
                                        success: function(data) {
                                            $('#categorySelect').empty().append(
                                                '<option value="">Select</option>');
                                            $.each(data, function(key, value) {
                                                // Check if this category ID is the selected one
                                                var isSelected = selectedCategoryId == value
                                                    .id ? ' selected' : '';
                                                $('#categorySelect').append(
                                                    '<option value="' + value.id + '"' +
                                                    isSelected + '>' + value.name +
                                                    '</option>');
                                            });
                                        },
                                        error: function(data) {
                                            console.error("Error fetching categories:", data);
                                        }
                                    });
                                } else {
                                    $('#categorySelect').empty().append('<option value="">Select</option>');
                                }
                            });

                            // Initialize category dropdown on page load
                            $('#mainCategorySelect').trigger('change');
                        });
    </script>


    // Initialize category dropdown on page load
    $('#mainCategorySelect').trigger('change');
    });

    $('.image-preview').css({
    'background-image': 'url({{ asset($subcategory->image) }})',
    'background-size': 'cover',
    'background-position': 'center center',
    })
    </script>
@endpush
