@extends('frontend.layouts.master')
@section('content')
<section class="page_banner" style="background-image: url(assets/images/banner.jpg);">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="pb_title">Checkout</h3>
                <div class="page_crumb">
                    <a href="{{ route('home') }}">Home</a> | <span>Checkout</span>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="cart-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                @php
                    $cartContent = Cart::content();
                @endphp
                @if($cartContent->isNotEmpty())
                    <form class="woocommerce-cart-form" action="#">
                        <table class="cart-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th class="text-left">Product</th>
                                    <th class="product-price">Price <span
                                            style="font-size: 0.8em; display: block; font-weight: normal;color:
                                            #666;">(Inclusive of
                                            taxes.)</span></th>
                                    <th class="product-quantity">Quantity</th>
                                    <th class="product-total">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cartContent as $item)
                                    <tr class="cart-item" data-row-id="{{ $item->rowId }}"
                                        data-product-id="{{ $item->id }}"
                                        data-variant-id="{{ $item->options->variant_id ?? null }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="text-center" style="width: 100px; height: 100px;">
                                            <img src="{{ asset($item->options->image) }}" alt="product"
                                                class="img-fluid" style="max-height: 100%; object-fit: contain;">
                                        </td>
                                        <td class="text-left">
                                            <a href="#">{{ $item->name }}</a>
                                            <br>
                                            @if($item->options->variant_code)
                                                <span
                                                    class="variant_code">({{ $item->options->variant_code }})</span>
                                            @endif
                                        </td>
                                        <td class="product-unit-price">
                                            <div class="product_price clearfix">
                                                <span class="price">₹<span
                                                        class="unit-price">{{ number_format($item->price, 2) }}</span></span>
                                                @if($item->options->sale_price)
                                                    <span class="sale-price"
                                                        style="text-decoration: line-through; font-size: 0.8em; color: gray; margin-left: 5px;">
                                                        ₹{{ number_format($item->options->sale_price, 2) }}
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="product-quantity clearfix">{{ $item->qty }}</td>
                                        <td class="product-total">
                                            <div class="product_price clearfix">
                                                <span class="price">₹<span
                                                        class="total-price">{{ number_format($item->price * $item->qty, 2) }}</span></span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="4" class="text-right"><strong>Total:</strong></td>
                                    <td><strong>{{ Cart::count() }}</strong></td>
                                    <td><strong>{{ Cart::subtotal() }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                @else
                    <div class="empty-cart text-center">
                        <h5>No products in the cart</h5>
                        <p>Your cart is currently empty. Start shopping now!</p>
                        <a href="{{ route('home') }}" class="btn btn-primary">Explore Products</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
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

        .trash-icon {
            color: red;
            /* Sets the color to red */
            text-align: center;
            /* Ensures alignment in case of block elements */
            display: inline-block;
            /* Aligns the icon properly */
        }

        .product-remove {
            text-align: center;
            /* Center-aligns the cell content */
        }
    </style>
@endpush
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            
        });
    </script>
@endpush