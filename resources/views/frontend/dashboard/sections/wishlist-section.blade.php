@extends('frontend.layouts.master')
@section('content')
    <!-- Hero Banner Start -->
    <section class="page_banner" style="background-image: url(assets/images/banner.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="pb_title">Wishlist</h3>
                    <div class="page_crumb">
                        <a href="{{ route('home') }}">Home</a> | <span>Wishlist</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner End -->

    <!-- Cart Section Start -->
    <section class="cart-section">
        <div class="container">
            <div class="row">
                <div class="col-xl-10 offset-xl-1 col-md-12">
                    <form class="woocommerce-cart-form" action="#">
                        <table class="cart-table wishlist-table">
                            <thead>
                                <tr>
                                    <th class="product-remove">Sno</th>
                                    <th class="product-name-thumbnail">Product</th>
                                    <th class="product-price">Unit Price</th>
                                    <th class="stock-status">Stock Status</th>
                                    <th class="wishlist-cart">Shopping Cart</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($wishlist as $item)
                                    @php
                                        // dd($item->product);
                                    @endphp
                                    <tr class="cart-item">
                                        <td class="product-remove">
                                            <a href="javascript:void(0)">{{ ++$loop->index }}</a>
                                        </td>
                                        <td class="product-thumbnail-title">

                                            <a class="product-name" href="#"> {{ $item->product->name }}</a>
                                        </td>
                                        <td class="product-unit-price">
                                            <div class="product_price clearfix">
                                                <span class="price">
                                                    @if ($item->product->has_variants == 0)
                                                        @php
                                                            $price = match (auth()->user()->role) {
                                                                'user' => $item->product->sale_price,
                                                                'ws' => $item->product->wholesale_price,
                                                                'dr' => $item->product->distributor_price,
                                                                default => $item->product->sale_price,
                                                            };
                                                        @endphp
                                                        <!-- Display sale price -->
                                                        <span>₹{{ number_format($price, 2) }}</span>
                                                    @else
                                                        <!-- Fetch price from product_variants table -->

                                                        @php
                                                            $variant = $item->product->variants->first();
                                                            $price = match (auth()->user()->role) {
                                                                'user' => $variant?->sale_price ??
                                                                    $item->product
                                                                        ->sale_price, // Fallback to product sale price if no variant exists
                                                                'ws' => $variant?->wholesale_price ??
                                                                    $item->product
                                                                        ->wholesale_price, // Fallback to product wholesale price
                                                                'dr' => $variant?->distributor_price ??
                                                                    $item->product
                                                                        ->distributor_price, // Fallback to product distributor price
                                                                default => $variant?->sale_price ??
                                                                    $item->product
                                                                        ->sale_price, // Default to sale price
                                                            };
                                                        @endphp
                                                        <span>₹{{ number_format($price, 2) }}</span>
                                                    @endif
                                                </span>
                                            </div>
                                        </td>
                                        @if ($item->product->has_variants == 0)
                                        <!-- Product without variants -->
                                        @if ($item->product->qty > 0)
                                            <td class="stock-status clearfix">In Stock</td>
                                        @else
                                            <td class="stock-status clearfix">Stock Out</td>
                                        @endif
                                    @else
                                        <!-- Product with variants -->
                                        @php
                                            $variantInStock = $item->product->variants->where('qty', '>', 0)->count() > 0;
                                        @endphp
                                        @if ($variantInStock)
                                            <td class="stock-status clearfix">In Stock</td>
                                        @else
                                            <td class="stock-status clearfix">Stock Out</td>
                                        @endif
                                    @endif
                                    
                                        <td class="wishlist-cart">
                                            <a class="add-to-cart" href="cart.html"><i class="nss-shopping-cart1"></i>Add To
                                                Cart</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </form>
                </div>

            </div>

            <!-- Centered Home Button -->
            <div class="text-center mt-4">
                <a href="{{ route('dashboard') }}" class="btn btn-primary">Go to My Account</a>
            </div>
        </div>
    </section>
    <!-- Cart Section End -->
@endsection
@push('styles')
    <style>
        .btn-primary {
            background-color: #f36e2d !important;
            border: none;
            color: white;
            padding: 10px 15px;
            transition: background-color 0.3s ease;
            /* Smooth transition */
        }

        .btn-secondary {
            background-color: #f36e2d !important;
            border: none;
            color: white;
            padding: 10px 15px;
            transition: background-color 0.3s ease;
            /* Smooth transition */
        }

        .btn-primary:hover,
        .btn-secondary:hover {
            background-color: #E2EEFF !important;
            /* Change to blue on hover */
            color: #222F5A;
            /* Keep text color white */
            font-weight: bold;
        }
    </style>
@endpush
