@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <span onclick="goBack()" style="cursor: pointer; font-size: 1.5em;">
            <i class="fas fa-arrow-left"></i></span>&nbsp;
        <h1>View Product Main Category</h1>
    </div>
</section>

<div class="row">
    <div class="col-md-4">
        <div class="card card-primary">
            <div class="card-header">
                <h4>Main Category Details</h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Name *</label>
                    <input type="text" name="name" value="{{ $maincategory->name }}"
                        class="form-control read-only-field">
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description"
                        class="form-control read-only-field">{!! $maincategory->description !!}</textarea>
                </div>
                <div class="form-group">
                    <label>Priority</label>
                    <input type="text" name="position" value="{{ $maincategory->position }}"
                        class="form-control read-only-field">
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control read-only-field">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-primary">
            <div class="card-header">
                <h4>Search Engine Listing</h4>
            </div>
            <div class="card-body">
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
    <div class="col-md-5">
        <div class="card card-primary">
            <div class="card-header">
                <h4>Images</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Logo Upload -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Logo:</label>
                            <div>
                                <img src="{{ asset(@$maincategory->logo) }}" alt="" width="250px" height="100px">
                            </div>
                        </div>
                    </div>
                    <!-- Image Upload -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Image:</label>
                            <div>
                                <img src="{{ asset(@$maincategory->image) }}" alt="" width="250px" height="100px">
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
    <button class="btn btn-primary" type="button"
        onclick="window.location='{{ route('admin.main-category.edit', $maincategory->id) }}'">Edit</button>
    <button class="btn btn-danger go-back" type="button" onclick="goBack()">Go Back</button>
</div>
@endsection
@push('scripts')
    <script src="{{ asset('admin/assets/js/form-script.js') }}"></script>
@endpush
