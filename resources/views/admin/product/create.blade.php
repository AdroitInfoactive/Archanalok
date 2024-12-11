@extends('admin.layouts.master')

@section('content')
<link rel="stylesheet" href="{{ asset('admin/assets/css/product-page.css') }}">
<section class="section">
    <div class="section-header">
        <span onclick="goBack()" style="cursor: pointer; font-size: 1.5em;">
            <i class="fas fa-arrow-left"></i></span>&nbsp;
        <h1>Create Product</h1>
    </div>
</section>

<div class="container container-custom">
    <form action="{{ route('admin.products.store') }}" id="product-form" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Product Details</h4>
                    </div>
                    <div class="card-body">
                        <!-- Category Dropdown -->
                        <div class="form-group">
                            <label for="category">Category *</label>
                            <select id="category" name="category" class="form-control select2">
                                <option value="">Select Category</option>
                                @foreach($mainCategories as $mainCategory)
                                    <optgroup label="{{ $mainCategory->name }}">
                                        @foreach($mainCategory->categories as $category)
                                            <option value="{{ $mainCategory->id }}-{{ $category->id }}-0"
                                                {{ $category->subcategories->isNotEmpty() ? 'disabled' : '' }}>
                                                -- {{ $category->name }}
                                            </option>
                                            @foreach($category->subcategories as $subcategory)
                                                <option
                                                    value="{{ $mainCategory->id }}-{{ $category->id }}-{{ $subcategory->id }}"
                                                    {{ old('category') == "$mainCategory->id-$category->id-$subcategory->id" ? 'selected' : '' }}>
                                                    ---- {{ $subcategory->name }}
                                                </option>
                                            @endforeach
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">Title *</label>
                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ old('name') }}">
                            <input type="hidden" name="slug" id="slug" value="{{ old('slug') }}">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description"
                                class="form-control summernote">{{ old('description') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="specification">Specification / Additional Information</label>
                            <textarea name="specification" id="specification"
                                class="form-control summernote">{{ old('specification') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="brand">Brand</label>
                            <select name="brand" id="brand" class="form-control select2">
                                <option value="">Select a brand</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}"
                                        {{ old('brand') == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label for="material">Material *</label>
                                <select name="material" id="material" class="form-control select2" required>
                                    <option value="">Select Material</option>
                                    @foreach($materials as $material)
                                        <option value="{{ $material->id }}"
                                            {{ old('material') == $material->id ? 'selected' : '' }}>
                                            {{ $material->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="units">Units *</label>
                                <select name="units" id="units" class="form-control select2" required>
                                    <option value="">Select Units</option>
                                    @foreach($units as $unit)
                                        <option value="{{ $unit->id }}"
                                            {{ old('units') == $unit->id ? 'selected' : '' }}>
                                            {{ $unit->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="weight_type">Weight Type *</label>
                                <select name="weight_type" id="weight_type" class="form-control select2" required>
                                    <option value="">Select Weight Type</option>
                                    @foreach($weightTypes as $weightType)
                                        <option value="{{ $weightType->id }}"
                                            {{ old('weight_type') == $weightType->id ? 'selected' : '' }}>
                                            {{ $weightType->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5>Images</h5>
                            <button type="button" id="delete-selected" class="btn btn-danger d-none">Delete
                                Selected</button>
                        </div>
                        <div id="media-container" class="media-container d-flex flex-wrap gap-3 dropzone">
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
                            <div class="media-item add-image-placeholder" id="add-image-placeholder">
                                <label for="file-input">
                                    <div class="add-image-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="svg-icon">
                                            <line x1="12" y1="5" x2="12" y2="19"></line>
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                        </svg> or <br> Drag & Drop to Upload Files
                                    </div>
                                </label>
                                <input type="file" id="file-input" name="media[]" class="d-none" accept="image/*"
                                    multiple>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <label for="file">Brochure File (If any)</label>
                            <input type="file" name="file" id="file" class="form-control" accept="application/pdf">
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="sku">SKU *</label>
                                <input type="text" name="sku" id="sku" class="form-control"
                                    value="{{ old('sku') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="other_code">Any Other Code (separated with comma)</label>
                                <input type="text" name="other_code" id="other_code" class="form-control"
                                    value="{{ old('other_code') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label for="gst">GST %</label>
                                <input type="text" name="gst" id="gst" class="form-control"
                                    value="{{ old('gst') }}">
                            </div>
                            <div class="col-md-4">
                                <label for="priority">Priority *</label>
                                <input type="text" name="priority" id="priority" class="form-control"
                                    value="{{ old('priority') }}">
                            </div>
                            <div class="col-md-4">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="1"
                                        {{ old('status') == '1' ? 'selected' : '' }}>
                                        Active
                                    </option>
                                    <option value="0"
                                        {{ old('status') == '0' ? 'selected' : '' }}>
                                        Inactive
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Product Has Variants</label>
                            <div class="form-check form-check-inline">
                                <input type="radio" name="has_variants" id="variants_yes" value="1"
                                    class="form-check-input"
                                    {{ old('has_variants') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="variants_yes">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" name="has_variants" id="variants_no" value="0"
                                    class="form-check-input"
                                    {{ old('has_variants') == '0' ? 'checked' : '' }}>
                                <label class="form-check-label" for="variants_no">No</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-4 variation-no d-none">
                    <div class="card-header">
                        <h4>Pricing Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="sale_price">Sale Price</label>
                                <input type="number" name="sale_price" id="sale_price" class="form-control no-arrows"
                                    step="0.01" placeholder="0 or 0.00"
                                    value="{{ old('sale_price') }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="offer_price">Offer Price</label>
                                <input type="number" name="offer_price" id="offer_price" class="form-control no-arrows"
                                    step="0.01" placeholder="0 or 0.00"
                                    value="{{ old('offer_price') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="distributor_price">Distributor Price</label>
                                <input type="number" name="distributor_price" id="distributor_price"
                                    class="form-control no-arrows" step="0.01" placeholder="0 or 0.00"
                                    value="{{ old('distributor_price') }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="wholesale_price">Wholesale Price</label>
                                <input type="number" name="wholesale_price" id="wholesale_price"
                                    class="form-control no-arrows" step="0.01" placeholder="0 or 0.00"
                                    value="{{ old('wholesale_price') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="min_order_qty">Minimum Order Quantity</label>
                                <input type="number" name="min_order_qty" id="min_order_qty"
                                    class="form-control no-arrows" min="1" placeholder="0"
                                    value="{{ old('min_order_qty') }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="weight">Weight</label>
                                <input type="number" name="weight" id="weight" class="form-control no-arrows" min="1"
                                    placeholder="0 or 0.00" value="{{ old('weight') }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="qty">Available Quantity</label>
                                <input type="number" name="qty" id="qty" class="form-control no-arrows" min="1"
                                    placeholder="0" value="{{ old('qty') }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-4 variation-yes d-none">
                    <div class="card-header">
                        <h4>Variation Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Select Applicable Variations</label>
                            <div id="variant-options" class="row">
                                @foreach($variantMasters as $variantMaster)
                                    <div class="col-md-2 mb-3">
                                        <div class="card p-2" style="height: 250px; overflow-y: auto;">
                                            <strong>{{ $variantMaster->name }}</strong>
                                            <hr>
                                            @foreach($variantMaster->details as $detail)
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="checkbox" class="form-check-input variant-checkbox"
                                                            data-master="{{ $variantMaster->name }}"
                                                            data-detail="{{ $detail->name }}"
                                                            value="{{ $detail->id }}">
                                                        {{ $detail->name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <input type="hidden" id="variant-master-detail" name="variant_master_detail">
                        <button type="button" id="generate-variations" class="btn btn-primary">Generate
                            Variations</button>
                        <!-- Generated Variations Table -->
                        <div class="table-responsive d-none" id="variations-table">
                            <table class="table table-bordered table-striped custom-table">
                                <thead class="table-header">
                                    <tr>
                                        <th><input type="checkbox" id="select-all" title="Select All"></th>
                                        <th>Image</th>
                                        <th>Variation</th>
                                        <th>SKU</th>
                                        <th>Sale Price</th>
                                        <th>Offer Price</th>
                                        <th>Distributor Price</th>
                                        <th>Min Order Qty</th>
                                        <th>Wholesale Price</th>
                                        <th>Weight</th>
                                        <th>Available Quantity</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody id="variations-body">
                                    <!-- Dynamically generated rows will appear here -->
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            <button type="button" id="delete-selected-variations" class="btn btn-danger d-none">Delete
                                Selected</button>
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
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
                                        {{ $actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://".$_SERVER['HTTP_HOST']."/product/" }}<span
                                            id="generated-url-preview">{{ old('slug', 'example-product') }}</span>
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
            </div>
        </div>
        <hr>

        <div class="text-center mt-3">
            <button type="submit" class="btn btn-success">Save Product</button>
            <button class="btn btn-danger go-back" type="button" onclick="goBack()">Go Back</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
    <script>
        const isEditPage = false;
        const level = 0;

    </script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script src="{{ asset('admin/assets/js/product-page.js') }}"></script>
    <script src="{{ asset('admin/assets/js/form-script.js') }}"></script>
    <script src="{{ asset('admin/assets/js/seo-handler-create.js') }}"></script>
@endpush
