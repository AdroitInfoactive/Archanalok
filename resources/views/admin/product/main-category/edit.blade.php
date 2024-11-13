@extends('admin.layouts.master')
@section('content')
<section class="section">
    <div class="section-header">
        <span onclick="goBack()" style="cursor: pointer; font-size: 1.5em;">
            <i class="fas fa-arrow-left"></i></span>&nbsp;
        <h1>Edit Product Main Category</h1>
    </div>
</section>

<form action="{{ route('admin.main-category.update', $maincategory->id) }}" method="post"
    enctype="multipart/form-data" class="form">
    @csrf
    @method('PUT')
    <div class="row">
        <!-- Main Category Details -->
        <div class="col-md-4">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Main Category Details</h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Name *</label>
                        <input type="text" name="name" id="name"
                            value="{{ old('name', $maincategory->name) }}"
                            class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" id="description"
                            class="form-control">{{ old('description', $maincategory->description) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Priority</label>
                        <input type="text" name="position"
                            value="{{ old('position', $maincategory->position) }}"
                            class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="1" @selected(old('status', $maincategory->status) === 1)>Active</option>
                            <option value="0" @selected(old('status', $maincategory->status) === 0)>Inactive</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <!-- SEO Listing -->
        <div class="col-md-3">
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
                                value="{{ old('seo_title', $maincategory->seo_title) }}"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <label>SEO Description</label>
                            <textarea name="seo_description" id="seo_description"
                                class="form-control">{{ old('seo_description', $maincategory->seo_description) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>URL Handle</label>
                            <input type="text" name="slug" id="slug"
                                value="{{ old('slug', $maincategory->slug) }}"
                                class="form-control" />
                            <input type="hidden" name="old_slug" id="old-slug" value="{{ $maincategory->slug }}">
                            <input type="hidden" name="new_slug" id="new-slug" value="{{ $maincategory->slug }}">
                            <input type="hidden" name="full_old_slug" id="full-old-slug"
                                value="{{ $maincategory->slug }}">
                            <input type="hidden" name="full_new_slug" id="full-new-slug"
                                value="{{ $maincategory->slug }}">
                            <div style="display: flex; align-items: center;">
                                <input type="checkbox" id="create-url-redirect" name="create_url_redirect" value="1"
                                    style="display: none; margin-right: 5px;">
                                <label for="create-url-redirect" id="redirect-label" style="display: none;">
                                    Create a URL redirect for<br>
                                    <strong>{{ old('slug', $maincategory->slug) }} → <span
                                            id="generated-url"></span></strong>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="seo-preview">
                        <div class="preview-container">
                            <p class="preview-url" id="preview-url">
                                {{ $actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://".$_SERVER['HTTP_HOST']."/" }}<span
                                    id="generated-url-preview">{{ old('slug', $maincategory->slug) }}</span>
                            </p>
                            <p class="preview-title" id="preview-title">
                                {{ old('seo_title', $maincategory->seo_title) }}</p>
                            <p class="preview-description" id="preview-description">
                                {{ old('seo_description', $maincategory->seo_description) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Images Section -->
        <div class="col-md-5">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Images</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Logo *</label>
                                <div id="image-preview" class="image-preview logo">
                                    <label for="image-upload" id="image-label">Choose logo</label>
                                    <input type="file" name="logo" id="image-upload" />
                                    <input type="hidden" name="old_logo" value="{{ @$maincategory->logo }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Image</label>
                                <div id="image-preview-2" class="image-preview img">
                                    <label for="image-upload-2" id="image-label-2">Choose Image</label>
                                    <input type="file" name="image" id="image-upload-2" />
                                    <input type="hidden" name="old_image" value="{{ @$maincategory->image }}">
                                </div>
                            </div>
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
        const originalName = "{{ $maincategory->name }}";
        const originalDescription = "{{ $maincategory->description }}";
        const originalSeoTitle = "{{ $maincategory->seo_title }}";
        const originalSeoDescription = "{{ $maincategory->seo_description }}";
        const originalSlug = "{{ $maincategory->slug }}";
        const isEditPage = true;
        const level = 0;

    </script>
    <script src="{{ asset('admin/assets/js/form-script.js') }}"></script>
    <script src="{{ asset('admin/assets/js/seo-handler-edit.js') }}"></script>
    <script>
        // Preview upload images
        $.uploadPreview({
            input_field: "#image-upload",
            preview_box: "#image-preview",
            label_field: "#image-label",
            label_default: "Choose File",
            label_selected: "Change File",
            no_label: false,
            success_callback: null
        });
        $.uploadPreview({
            input_field: "#image-upload-2",
            preview_box: "#image-preview-2",
            label_field: "#image-label-2",
            label_default: "Choose File",
            label_selected: "Change File",
            no_label: false,
            success_callback: null
        });

        $(document).ready(function () {
            $('.logo').css({
                'background-image': 'url({{ asset($maincategory->logo) }})',
                'background-size': 'cover',
                'background-position': 'center center',
            })
            $('.img').css({
                'background-image': 'url({{ asset($maincategory->image) }})',
                'background-size': 'cover',
                'background-position': 'center center',
            })
        })

        $.uploadPreview({
            input_field: "#image-upload", // Default: .image-upload
            preview_box: "#image-preview", // Default: .image-preview
            label_field: "#image-label", // Default: .image-label
            label_default: "Choose File", // Default: Choose File
            label_selected: "Change File", // Default: Change File
            no_label: false, // Default: false
            success_callback: null // Default: null
        });
        $.uploadPreview({
            input_field: "#image-upload-2", // Default: .image-upload
            preview_box: "#image-preview-2", // Default: .image-preview
            label_field: "#image-label-2", // Default: .image-label
            label_default: "Choose File", // Default: Choose File
            label_selected: "Change File", // Default: Change File
            no_label: false, // Default: false
            success_callback: null // Default: null
        });

    </script>
@endpush
