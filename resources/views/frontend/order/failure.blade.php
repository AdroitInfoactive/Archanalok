@extends('frontend.layouts.master')
@section('content')
<section class="page_banner" style="background-image: url(assets/images/banner.jpg);">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="pb_title">Order Failed</h3>
                <div class="page_crumb">
                    <a href="{{ route('home') }}">Home</a> | <span>Orders</span>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="order-detail-section cart-section">
    <div class="container">
        <!-- <h2 class="sec tion-title mt-2">Order Details</h2> -->
        <!-- Order Failure Box -->
        <div class="row justify-content-center">
            <div class="col-12 mb-4">
                <div class="order-detail-box text-center">
                    <h4>Order Status</h4>
                    <!-- Red Cross and "Order Failed" Message -->
                    <div class="mb-3">
                        <span class="badge badge-danger"
                            style="font-size: 40px; padding: 10px; border-radius: 50%;">✖</span>
                    </div>
                    <p><strong>Order Failed</strong></p>
                </div>
            </div>
        </div>
        <!-- Order Information -->
        <div class="row justify-content-center">
            <div class="col-12 mb-4 text-center">
                <p><strong>Order No:</strong> {{ $order->temp_invoice_id }}</p>
            </div>
        </div>
        <!-- Thank You Section (or Retry option) -->
        <div class="row justify-content-center">
            <div class="col-12 mb-4 text-center">
                <p>We're sorry, but your order could not be processed.<br> Please review your order details or try again
                    later.</p>
                <p><a href="{{ route('home') }}"
                        target="_blank" class="btn btn-primary">Go to Homepage</a></p>
            </div>
        </div>
    </div>
</section>
@endsection
