@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <span onclick="goBack()" style="cursor: pointer; font-size: 1.5em;">
            <i class="fas fa-arrow-left"></i>
        </span>&nbsp;
        <h1>View Product</h1>
    </div>
</section>

<div class="row">
    <!-- Product Details -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Product Details</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <p><strong>Name:</strong> {{ $product->name }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>SKU:</strong> {{ $product->sku }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Any Other Codes:</strong> {{ $product->other_code }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Main Category:</strong>
                            {{ $product->mainCategory->name ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Category:</strong>
                            {{ $product->category->name ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Sub Category:</strong>
                            {{ $product->subCategory->name ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Brand:</strong> {{ $product->brandName->name }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Material:</strong> {{ $product->materialDetail->name }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Units:</strong> {{ $product->unitDetail->name }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Weight Type:</strong> {{ $product->weightTypeDetail->name }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>GST:</strong> {{ $product->gst }}%</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Status:</strong>
                            {{ $product->status ? 'Active' : 'Inactive' }}
                        </p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Priority:</strong> {{ $product->priority }}</p>
                    </div>
                    <div class="col-md-12">
                        <p><strong>Description:</strong> {!! $product->description !!}</p>
                    </div>
                    <div class="col-md-12">
                        <p><strong>Specification:</strong> {!! $product->specification !!}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>SEO Title:</strong> {{ $product->seo_title }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>SEO Description:</strong> {!! $product->seo_description !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Product Images -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Product Images</h4>
            </div>
            <div class="card-body">
                @php
                    // Filter images where variant_id is null
                    $productImages = $product->images->whereNull('variant_id');
                @endphp
                @if($productImages->isNotEmpty())
                    <div class="d-flex flex-wrap justify-content-start align-items-center">
                        @foreach($productImages as $image)
                            <img src="{{ asset($image->image_path) }}" alt="Product Image" class="img-thumbnail m-1"
                                style="width: 200px; height: 200px; object-fit: cover;">
                            <!-- Fixed square dimensions -->
                        @endforeach
                    </div>
                @else
                    <p>No images available</p>
                @endif
            </div>
        </div>
    </div>
</div>
<hr>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>{{ $product->has_variants ? 'Product Variations' : 'Product Pricing Details' }}
                </h4>
            </div>
            <div class="card-body">
                @if($product->has_variants)
                    <!-- Display Variants -->
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Variation Code</th>
                                <th>SKU</th>
                                <th>Sale Price</th>
                                <th>Offer Price</th>
                                <th>Distributor Price</th>
                                <th>Min Order Qty</th>
                                <th>Wholesale Price</th>
                                <th>Weight</th>
                                <th>Qty</th>
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
                @else
                    <!-- Display Single Product Pricing Details -->
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Sale Price:</strong> {{ number_format($product->sale_price, 2) }}</p>
                            <p><strong>Offer Price:</strong> {{ number_format($product->offer_price, 2) }}</p>
                            <p><strong>Distributor Price:</strong>
                                {{ number_format($product->distributor_price, 2) }}</p>
                            <p><strong>Min Order Qty:</strong> {{ $product->min_order_qty }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Wholesale Price:</strong> {{ number_format($product->wholesale_price, 2) }}
                            </p>
                            <p><strong>Weight:</strong> {{ $product->weight }}</p>
                            <p><strong>Quantity Available:</strong> {{ $product->qty }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-header">
                <h4>Search Engine Listing</h4>
            </div>
            <div class="card-body">
                <div class="seo-preview">
                    <div class="preview-container">
                        <p class="preview-url" id="product-preview-url">
                            {{ $actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://".$_SERVER['HTTP_HOST']."/" }}product/{{ $product->slug }}
                        </p>
                        <p class="preview-title" id="product-preview-title">
                            {{ old('seo_title', $product->seo_title) }}
                        </p>
                        <p class="preview-description" id="product-preview-description">
                            {{ old('seo_description', $product->seo_description) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>

<div class="text-center mt-3">
    <button class="btn btn-primary" type="button"
        onclick="window.location='{{ route('admin.products.edit', $product->id) }}'">Edit</button>
    <button class="btn btn-danger go-back" type="button" onclick="goBack()">Go Back</button>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('admin/assets/js/form-script.js') }}"></script>
@endpush
