@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <span onclick="goBack()" style="cursor: pointer; font-size: 1.5em;">
            <i class="fas fa-arrow-left"></i>
        </span>&nbsp;
        <h1>View Product Category</h1>
    </div>
</section>

<div class="row">
    <div class="col-md-4">
        <div class="card card-primary">
            <div class="card-header">
                <h4>Main Category Details</h4>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-6">
                        <label>Main Category *</label>
                        <input type="text" name="name" value="{{ $category->mainCategory->name }}"
                            class="form-control read-only-field">
                    </div>
                    <div class="col-md-6">
                        <label>Name *</label>
                        <input type="text" name="name" value="{{ $category->name }}"
                            class="form-control read-only-field">
                    </div>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description"
                        class="form-control read-only-field">{!! $category->description !!}</textarea>
                </div>
                <div class="form-group row">
                    <div class="col-md-6">
                        <label>Priority</label>
                        <input type="text" name="position" value="{{ $category->position }}"
                            class="form-control read-only-field">
                    </div>
                    <div class="col-md-6">
                        <label>Status</label>
                        <select name="status" class="form-control read-only-field" disabled>
                            <option value="1"
                                {{ $category->status == 1 ? 'selected' : '' }}>
                                Active</option>
                            <option value="0"
                                {{ $category->status == 0 ? 'selected' : '' }}>
                                Inactive</option>
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
            </div>
            <div class="card-body">
                <div class="seo-preview">
                    <div class="preview-container">
                        <p class="preview-url" id="preview-url">
                            {{ $actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://".$_SERVER['HTTP_HOST']."/" }}<span
                                id="generated-main-category-url">{{ old('slug', $category->mainCategory->slug) }}</span>/<span
                                id="generated-url-preview">{{ old('slug', $category->slug) }}</span>
                        </p>
                        <p class="preview-title" id="preview-title">
                            {{ old('seo_title', $category->seo_title) }}</p>
                        <p class="preview-description" id="preview-description">
                            {{ old('seo_description', $category->seo_description) }}
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
                    <label>Image:</label>
                    <div>
                        <img src="{{ asset($category->image) }}" alt="" width="250px" height="100px">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<hr>

<div class="text-center mt-3">
    <button class="btn btn-primary" type="button"
        onclick="window.location='{{ route('admin.category.edit', $category->id) }}'">Edit</button>
    <button class="btn btn-danger go-back" type="button" onclick="goBack()">Go Back</button>
</div>
@endsection
@push('scripts')
    <script src="{{ asset('admin/assets/js/form-script.js') }}"></script>
@endpush
