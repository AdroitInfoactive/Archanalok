@extends('frontend.layouts.master')
@section('content')
<section class="page_banner" style="background-image: url(assets/images/banner.jpg);">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="pb_title">Order Successfull</h3>
                <div class="page_crumb">
                    <a href="{{ route('home') }}">Home</a> | <span>Orders</span>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="order-detail-section cart-section">
    <div class="container">
        <!-- <h2 class="section-title mt-2">Order Placed Successfully!</h2> -->

        <!-- Order Summary Box -->
        <div class="row justify-content-center">
            <div class="col-12 mb-4">
                <div class="order-detail-box text-center">
                    <h4>Order Status</h4>
                    <!-- Green Tick and "Order Successful" Message -->
                    <div class="mb-3">
                        <span class="badge badge-success"
                            style="font-size: 40px; padding: 10px; border-radius: 50%;">✔</span>
                    </div>
                    <p><strong>Order Successful</strong></p>
                </div>
            </div>
        </div>

        @php
        $invoiceNo = 'ATC/' . $order->financial_year . '/' . str_pad($order->id, 3, '0', STR_PAD_LEFT);
        $formattedDate = $order->created_at->format('d-m-Y H:i:s');
        @endphp

        <!-- Order Information -->
        <div class="row justify-content-center">
            <div class="col-12 mb-4 text-center">
                <p><strong>Order No:</strong> {{ $invoiceNo }}</p>
                <p><strong>Order Amount:</strong> {{ $order->grand_total }}</p>
                <p><strong>Order Date:</strong> {{ $formattedDate }}</p>
            </div>
        </div>

        <!-- Thank You Section -->
        <div class="row justify-content-center">
            <div class="col-12 mb-4 text-center">
                <p>Thank you very much for shopping with us. Please note the details for your reference.</p>
                <p><a href="{{ route('home') }}"
                        target="_blank" class="btn btn-primary">Go to Homepage</a></p>
            </div>
        </div>

    </div>
</section>
@endsection
