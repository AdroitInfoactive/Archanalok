@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <span onclick="goBack()" style="cursor: pointer; font-size: 1.5em;">
            <i class="fas fa-arrow-left"></i>
        </span>&nbsp;
        <h1>Edit Product Sub Category</h1>
    </div>
</section>

<form action="{{ route('admin.sub-category.update', $subcategory->id) }}" method="post"
    enctype="multipart/form-data" class="form">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-4">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Sub Category Details</h4>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label>Main Category *</label>
                            <select name="main_category_id" class="form-control select2" id="mainCategorySelect">
                                <option value="">Select</option>
                                @foreach($maincategories as $maincat)
                                    <option value="{{ $maincat->id }}" @selected($subcategory->main_category_id ==
                                        $maincat->id) data-slug="{{ $maincat->slug }}">{{ $maincat->name }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="main-categoty-slug" id="main-category-slug"
                                value="{{ $subcategory->mainCategory->slug }}">
                        </div>
                        <div class="col-md-6">
                            <label>Category *</label>
                            <select name="category_id" class="form-control select2" id="categorySelect">
                                <option value="">Select</option>
                                <!-- Options will be populated by JavaScript -->
                            </select>
                            <input type="hidden" name="categoty-slug" id="category-slug"
                                value="{{ $subcategory->category->slug }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Name *</label>
                        <input type="text" name="name" id="name"
                            value="{{ old('name', $subcategory->name) }}"
                            class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" id="description"
                            class="form-control">{{ old('description', $subcategory->description) }}</textarea>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label>Priority *</label>
                            <input type="text" name="position"
                                value="{{ old('position', $subcategory->position) }}"
                                class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="1" @selected($subcategory->status === 1)>Active</option>
                                <option value="0" @selected($subcategory->status === 0)>Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Search Engine Listing</h4>
                    <button type="button" id="edit-seo-btn" class="btn btn-sm float-right">
                        <i class="fas fa-pencil-alt"></i>
                    </button>
                </div>
                <div class="card-body">
                    <div id="seo-fields" style="display: none;">
                        <div class="form-group">
                            <label>SEO Title</label>
                            <input type="text" name="seo_title" id="seo_title"
                                value="{{ old('seo_title', $subcategory->seo_title) }}"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <label>SEO Description</label>
                            <textarea name="seo_description" id="seo_description"
                                class="form-control">{{ old('seo_description', $subcategory->seo_description) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>URL Handle</label>
                            <input type="text" name="slug" id="slug"
                                value="{{ old('slug', $subcategory->slug) }}"
                                class="form-control" />
                            <input type="hidden" name="old_slug" id="old-slug" value="{{ $subcategory->slug }}">
                            <input type="hidden" name="new_slug" id="new-slug" value="{{ $subcategory->slug }}">
                            <input type="hidden" name="full_old_slug" id="full-old-slug"
                                value="{{ $subcategory->slug }}">
                            <input type="hidden" name="full_new_slug" id="full-new-slug"
                                value="{{ $subcategory->slug }}">
                            <div style="display: flex; align-items: center;">
                                <input type="checkbox" id="create-url-redirect" name="create_url_redirect" value="1"
                                    style="display: none; margin-right: 5px;">
                                <label for="create-url-redirect" id="redirect-label" style="display: none;">
                                    Create a URL redirect for<br>
                                    <strong>{{ old('slug', $subcategory->slug) }} → <span
                                            id="generated-url"></span></strong>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="seo-preview">
                        <div class="preview-container">
                            <p class="preview-url" id="preview-url">
                                {{ $actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://".$_SERVER['HTTP_HOST']."/" }}<span
                                    id="generated-main-category-url">{{ old('slug', $subcategory->mainCategory->slug) }}</span>/<span
                                        id="generated-category-url">{{ old('slug', $subcategory->category->slug) }}</span>/<span
                                    id="generated-url-preview">{{ old('slug', $subcategory->slug) }}</span>
                            </p>
                            <p class="preview-title" id="preview-title">
                                {{ old('seo_title', $subcategory->seo_title) }}</p>
                            <p class="preview-description" id="preview-description">
                                {{ old('seo_description', $subcategory->seo_description) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Images</h4>
                </div>
                <div class="card-body">
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
        </div>
    </div>
    <hr>
    <div class="text-center mt-3">
        <button class="btn btn-primary" type="submit">Update</button>
        <button class="btn btn-danger go-back" type="button" onclick="goBack()">Go Back</button>
    </div>
</form>

@endsection

@push('scripts')
    <script>
        const originalName = "{{ $subcategory->name }}";
        const originalDescription = "{{ $subcategory->description }}";
        const originalSeoTitle = "{{ $subcategory->seo_title }}";
        const originalSeoDescription = "{{ $subcategory->seo_description }}";
        const originalSlug = "{{ $subcategory->slug }}";
        const isEditPage = true;
        const level = 2;

    </script>
    <script src="{{ asset('admin/assets/js/form-script.js') }}"></script>
    <script src="{{ asset('admin/assets/js/seo-handler-edit.js') }}"></script>
    <script>
        $(document).ready(function () {
            var selectedCategoryId = "{{ $subcategory->category_id }}";
            // Populate categories based on the selected main category
            $('#mainCategorySelect').on('change', function () {
                var mainCategoryId = this.value;
                if (mainCategoryId) {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('admin.get-category.getCategoriesByMainCategory', '') }}/" +
                            mainCategoryId,
                        success: function (data) {
                            $('#categorySelect').empty().append(
                                '<option value="">Select</option>');
                            $.each(data, function (key, value) {
                                var isSelected = selectedCategoryId == value.id ?
                                    ' selected' :
                                    '';
                                $('#categorySelect').append('<option value="' +
                                    value.id + '"' +
                                    isSelected + ' data-slug="'+value.slug+'">' + value.name + '</option>');
                            });
                        },
                        error: function (xhr, status, error) {
                            console.error("Error fetching categories:", error);
                        }
                    });
                } else {
                    $('#categorySelect').empty().append('<option value="">Select</option>');
                }
            });
            // Initialize category dropdown on page load
            $('#mainCategorySelect').trigger('change');

            $('.image-preview').css({
                'background-image': 'url({{ asset($subcategory->image) }})',
                'background-size': 'cover',
                'background-position': 'center center',
            })
        });

    </script>
@endpush
