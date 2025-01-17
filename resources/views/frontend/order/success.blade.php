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
<section class="cart-section">
    <div class="container">
      <h2>Order Placed Successfully!</h2>
      <p>Order ID: {{ $order->id }}</p>
      <p>Thank you for your order. We will process it soon.</p>
      <a href="{{ route('home') }}" class="btn btn-primary">Go to Homepage</a>
    </div>
</section>
@endsection
