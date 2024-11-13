@extends('admin.layouts.master')
@section('content')
<section class="section">
    <div class="section-header">
        <span onclick="goBack()" style="cursor: pointer; font-size: 1.5em;">
            <i class="fas fa-arrow-left"></i>
        </span>&nbsp;
        <h1>Add Product Category</h1>
    </div>
</section>

<form action="{{ route('admin.category.store') }}" method="post" enctype="multipart/form-data"
    class="form">
    @csrf
    <div class="row">
        <div class="col-md-4">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Category Details</h4>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label>Main Category</label>
                            <select name="main_category_id" id="mainCategorySelect" class="form-control select2">
                                <option value="">Select</option>
                                @foreach($maincategories as $maincat)
                                    <option value="{{ $maincat->id }}" data-slug="{{ $maincat->slug }}">{{ $maincat->name }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="main-categoty-slug" id="main-category-slug" value="">
                        </div>
                        <div class="col-md-6">
                            <label>Name *</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}"
                                class="form-control">
                            <input type="hidden" name="slug" id="slug" value="{{ old('slug') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" id="description"
                            class="form-control">{{ old('description') }}</textarea>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label>Priority</label>
                            <input type="text" name="position" value="{{ old('position') }}"
                                class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
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
                        <i class="fas fa-pencil-alt"></i> <!-- Pencil icon -->
                    </button>
                </div>
                <div class="card-body">
                    <div id="seo-fields" style="display: none;">
                        <div class="form-group">
                            <label>SEO Title</label>
                            <input type="text" name="seo_title" id="seo_title"
                                value="{{ old('seo_title') }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>SEO Description</label>
                            <textarea name="seo_description" id="seo_description"
                                class="form-control">{{ old('seo_description') }}</textarea>
                        </div>
                    </div>
                    <div class="seo-preview">
                        <div class="preview-container">
                            <p class="preview-url" id="preview-url">
                                {{ $actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://".$_SERVER['HTTP_HOST']."/" }}<span id="generated-main-category-url">{{ old('slug', 'example-main-category') }}</span>/<span id="generated-url-preview">{{ old('slug', 'example-category') }}</span>
                            </p>
                            <p class="preview-title" id="preview-title">
                                {{ old('seo_title', 'Sample SEO Title') }}
                            </p>
                            <p class="preview-description" id="preview-description">
                                {{ old('seo_description', 'This is a sample description that appears in search results.') }}
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
                        <label>Image *</label>
                        <div id="image-preview" class="image-preview">
                            <label for="image-upload" id="image-label">Choose Image</label>
                            <input type="file" name="image" id="image-upload" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="text-center mt-3">
        <button class="btn btn-primary btn-lg" type="submit">Create</button>
        <button class="btn btn-danger btn-lg" type="button" onclick="goBack()">Go Back</button>
    </div>
</form>
@endsection

@push('scripts')
    <script>
        const isEditPage = false;
        const level = 1;
    </script>
    <script src="{{ asset('admin/assets/js/form-script.js') }}"></script>
    <script src="{{ asset('admin/assets/js/seo-handler-create.js') }}"></script>
    <script>
        $.uploadPreview({
            input_field: "#image-upload", // Default: .image-upload
            preview_box: "#image-preview", // Default: .image-preview
            label_field: "#image-label", // Default: .image-label
            label_default: "Choose File", // Default: Choose File
            label_selected: "Change File", // Default: Change File
            no_label: false, // Default: false
            success_callback: null // Default: null
        });

    </script>
@endpush
