@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <span onclick="goBack()" style="cursor: pointer; font-size: 1.5em;">
            <i class="fas fa-arrow-left"></i>
        </span>&nbsp;
        <h1>View Product Sub Category</h1>
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
                        <input type="text" name="main_category" value="{{ @$subcategory->maincategory->name }}"
                            class="form-control read-only-field">
                    </div>
                    <div class="col-md-6">
                        <label>Category *</label>
                        <input type="text" name="category" value="{{ @$subcategory->category->name }}"
                            class="form-control read-only-field">
                    </div>
                </div>
                <div class="form-group">
                    <label>Name *</label>
                    <input type="text" name="name" value="{{ @$subcategory->name }}"
                        class="form-control read-only-field">
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description"
                        class="form-control read-only-field">{!! @$subcategory->description !!}</textarea>
                </div>
                <div class="form-group row">
                    <div class="col-md-6">
                        <label>Position</label>
                        <input type="text" name="position" value="{{ @$subcategory->position }}"
                            class="form-control read-only-field">
                    </div>
                    <div class="col-md-6">
                        <label>Status</label>
                        <select name="status" class="form-control read-only-field" disabled>
                            <option value="1"
                                {{ @$subcategory->status == 1 ? 'selected' : '' }}>
                                Active</option>
                            <option value="0"
                                {{ @$subcategory->status == 0 ? 'selected' : '' }}>
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
                <h4>SEO Details</h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>SEO Title</label>
                    <input type="text" name="seo_title" value="{{ @$subcategory->seo_title }}"
                        class="form-control read-only-field">
                </div>
                <div class="form-group">
                    <label>SEO Description</label>
                    <textarea name="seo_description"
                        class="form-control read-only-field">{{ @$subcategory->seo_description }}</textarea>
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
                        <img src="{{ asset(@$subcategory->image) }}" alt="Subcategory Image" width="250px"
                            height="100px">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<hr>

<div class="text-center mt-3">
    <button class="btn btn-primary" type="button"
        onclick="window.location='{{ route('admin.sub-category.edit', @$subcategory->id) }}'">Edit</button>
    <button class="btn btn-danger go-back" type="button" onclick="goBack()">Go Back</button>
</div>
@endsection
@push('scripts')
    <script src="{{ asset('admin/assets/js/form-script.js') }}"></script>
@endpush