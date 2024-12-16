@extends('admin.layouts.master')

@section('content')
<link rel="stylesheet" href="{{ asset('admin/assets/css/product-page.css') }}">
<section class="section">
    <div class="section-header">
        <span onclick="goBack()" style="cursor: pointer; font-size: 1.5em;">
            <i class="fas fa-arrow-left"></i></span>&nbsp;
        <h1>Edit Product</h1>
    </div>
</section>

<div class="container container-custom">
    <form action="{{ route('admin.products.update', $product->id) }}" id="product-form"
        method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
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
                                                {{ $category->subcategories->isNotEmpty() ? 'disabled' : '' }}
                                                {{ $product->main_category_id == $mainCategory->id && $product->category_id == $category->id ? 'selected' : '' }}>
                                                -- {{ $category->name }}
                                            </option>
                                            @foreach($category->subcategories as $subcategory)
                                                <option
                                                    value="{{ $mainCategory->id }}-{{ $category->id }}-{{ $subcategory->id }}"
                                                    {{ $product->main_category_id == $mainCategory->id && $product->category_id == $category->id && $product->sub_category_id == $subcategory->id ? 'selected' : '' }}>
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
                                value="{{ old('name', $product->name) }}">
                            <input type="hidden" name="slug" id="slug"
                                value="{{ old('slug', $product->slug) }}">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description"
                                class="form-control summernote">{{ old('description', $product->description) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="specification">Specification / Additional Information</label>
                            <textarea name="specification" id="specification"
                                class="form-control summernote">{{ old('specification', $product->specification) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="brand">Brand</label>
                            <select name="brand" id="brand" class="form-control select2">
                                <option value="">Select a brand</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}"
                                        {{ old('brand', $product->brand) == $brand->id ? 'selected' : '' }}>
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
                                            {{ old('material', $product->material) == $material->id ? 'selected' : '' }}>
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
                                            {{ old('units', $product->units) == $unit->id ? 'selected' : '' }}>
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
                                            {{ old('weight_type', $product->weight_type) == $weightType->id ? 'selected' : '' }}>
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
                            @if(isset($product) && $product->images->isNotEmpty())
                                @foreach($product->images as $image)
                                    <div class="media-item media-item-small" data-id="{{ $image->id }}">
                                        <input type="checkbox" class="image-checkbox" data-id="{{ $image->id }}">
                                        <img src="{{ asset($image->image_path) }}" alt="Product Image"
                                            class="img-thumbnail"
                                            style="width: 150px; height: 150px; object-fit: cover;">
                                    </div>
                                @endforeach
                            @else
                                <p>No images available. You can upload new images below.</p>
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
                            @if($product->file)
                                <p class="mt-2">Current File:
                                    <a href="{{ asset($product->file) }}"
                                        target="_blank">{{ basename($product->file) }}</a>
                                </p>
                            @endif
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="sku">SKU *</label>
                                <input type="text" name="sku" id="sku" class="form-control"
                                    value="{{ old('sku', $product->sku) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="other_code">Any Other Code (separated with comma)</label>
                                <input type="text" name="other_code" id="other_code" class="form-control"
                                    value="{{ old('other_code', $product->other_code) }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-4">
                                <label for="gst">GST %</label>
                                <input type="text" name="gst" id="gst" class="form-control"
                                    value="{{ old('gst', $product->gst) }}">
                            </div>
                            <div class="col-md-4">
                                <label for="priority">Priority *</label>
                                <input type="text" name="priority" id="priority" class="form-control"
                                    value="{{ old('priority', $product->priority) }}">
                            </div>
                            <div class="col-md-4">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="1"
                                        {{ old('status', $product->status) == '1' ? 'selected' : '' }}>
                                        Active
                                    </option>
                                    <option value="0"
                                        {{ old('status', $product->status) == '0' ? 'selected' : '' }}>
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
                                    {{ old('has_variants', $product->has_variants) == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="variants_yes">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" name="has_variants" id="variants_no" value="0"
                                    class="form-check-input"
                                    {{ old('has_variants', $product->has_variants) == '0' ? 'checked' : '' }}>
                                <label class="form-check-label" for="variants_no">No</label>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Variations -->
                @if($product->has_variants)
                    <div class="card mb-4">
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
                                                            <input type="checkbox"
                                                                class="form-check-input variant-checkbox"
                                                                data-master="{{ $variantMaster->name }}"
                                                                data-detail="{{ $detail->name }}"
                                                                value="{{ $detail->id }}"
                                                                {{ in_array($detail->id, $product->variants->pluck('variation_code')->toArray()) ? 'checked' : '' }}>
                                                            {{ $detail->name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Existing Variations Table -->
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped custom-table">
                                    <thead class="table-header">
                                        <tr>
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
                                    <tbody>
                                        @foreach($product->variants as $variant)
                                            <tr>
                                                <td>
                                                    @if($variant->images->isNotEmpty())
                                                        <img src="{{ asset($variant->images->first()->image_path) }}"
                                                            alt="Variant Image"
                                                            style="width: 50px; height: 50px; object-fit: cover;"
                                                            class="img-thumbnail">
                                                    @else
                                                        <span>No Image</span>
                                                    @endif
                                                </td>
                                                <td>{{ $variant->variation_code }}</td>
                                                <td>{{ $variant->sku }}</td>
                                                <td>{{ number_format($variant->sale_price, 2) }}</td>
                                                <td>{{ number_format($variant->offer_price, 2) }}</td>
                                                <td>{{ number_format($variant->distributor_price, 2) }}</td>
                                                <td>{{ $variant->min_order_qty }}</td>
                                                <td>{{ number_format($variant->wholesale_price, 2) }}</td>
                                                <td>{{ $variant->weight }}</td>
                                                <td>{{ $variant->qty }}</td>
                                                <td>{{ $variant->status ? 'Active' : 'Inactive' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Pricing Details if no variants -->
                @if(!$product->has_variants)
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4>Pricing Details</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="sale_price">Sale Price</label>
                                    <input type="number" name="sale_price" id="sale_price" class="form-control"
                                        value="{{ $product->sale_price }}" step="0.01">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="offer_price">Offer Price</label>
                                    <input type="number" name="offer_price" id="offer_price" class="form-control"
                                        value="{{ $product->offer_price }}" step="0.01">
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <hr>
        <div class="text-center mt-3">
            <button type="submit" class="btn btn-success">Update Product</button>
            <button class="btn btn-danger go-back" type="button" onclick="goBack()">Go Back</button>
        </div>
    </form>
</div>
@endsection
@push('scripts')
    <script>
        const isEditPage = true;
        const level = 0;
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script src="{{ asset('admin/assets/js/product-edit-page.js') }}"></script>
    <script src="{{ asset('admin/assets/js/form-script.js') }}"></script>
@endpush