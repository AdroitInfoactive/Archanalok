@extends('frontend.layouts.master')
@section('content')
<section class="page_banner" style="background-image: url(assets/images/banner.jpg);">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="pb_title">Orders</h3>
                <div class="page_crumb">
                    <a href="{{ route('home') }}">Home</a> | <span>Order Details</span>
                </div>
            </div>
        </div>
    </div>
</section>
@php
    $invoiceNo = ($order->payment_status == 1)
    ? 'ATC/' . $order->financial_year . '/' . str_pad($order->id, 3, '0', STR_PAD_LEFT)
    : $order->temp_invoice_id;

    $formattedDate = $order->created_at->format('d-m-Y H:i:s');
    // Define order status labels with Bootstrap badge colors
    $statusLabels = [
    'Pending' => ['label' => 'Pending', 'color' => 'warning'], // Yellow
    'Placed' => ['label' => 'Placed', 'color' => 'info'], // Blue
    'Payment Received' => ['label' => 'Payment Received', 'color' => 'primary'], // Dark Blue
    'Shipped' => ['label' => 'Shipped', 'color' => 'secondary'], // Gray
    'Delivered' => ['label' => 'Delivered', 'color' => 'success'], // Green
    'Cancelled' => ['label' => 'Cancelled', 'color' => 'danger'], // Red
    'Returned' => ['label' => 'Returned', 'color' => 'dark'], // Black
    ];

    // Get the order status label and badge color
    $orderStatus = $statusLabels[$order->order_status] ?? ['label' => 'Unknown', 'color'
    =>
    'dark'];
    $note = $order->note ?? "NA";
    $paymentType = $order->payment_type ?? "NA";
    $billingDetails = json_decode($order->billing_address, true);
    $shippingDetails = json_decode($order->shipping_address, true);
@endphp
<section class="order-detail-section">
    <div class="container">
        <h2 class="section-title mt-2"> </h2>

        <!-- Order Summary Box -->
        <div class="row justify-content-center">
            <div class="col-12 mb-4">
                <div class="order-detail-box">
                    <h4>Order Summary</h4>
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-6">
                            <p><strong>Invoice No:</strong> {{ $invoiceNo }}</p>
                            <p><strong>Order Status:</strong> <span
                                    class="badge
                                    badge-{{ $orderStatus['color'] }}">{{ $orderStatus['label'] }}</span>
                            </p>
                            <p><strong>Note:</strong> {{ $note }}</p>

                        </div>

                        <!-- Right Column -->
                        <div class="col-md-6">
                            <p><strong>Order Date:</strong> {{ $formattedDate }}</p>
                            <p><strong>Payment Method:</strong> {{ $order->payment_method }}</p>
                            <p><strong>Payment Mode:</strong> {{ $paymentType }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12 mb-4">
                <div class="order-detail-box">
                    <div class="row">
                        <!-- Left Column - Billing Details -->
                        <div class="col-md-6">
                            <h5>Billing Details</h5>
                            <div class="card p-3 border rounded">
                                <p><strong>Name:</strong>
                                    {{ $billingDetails['name'] ?? 'N/A' }}
                                </p>
                                <p><strong>Email:</strong>
                                    {{ $billingDetails['email'] ?? 'N/A' }}
                                </p>
                                <p><strong>Phone:</strong>
                                    {{ $billingDetails['phone'] ?? 'N/A' }}
                                </p>
                                <p><strong>Address:</strong>
                                    {{ $billingDetails['address'] ?? 'N/A' }}
                                </p>
                                <p><strong>City:</strong>
                                    {{ $billingDetails['city'] ?? 'N/A' }}
                                </p>
                                <p><strong>State:</strong>
                                    {{ $billingDetails['state'] ?? 'N/A' }}
                                </p>
                                <p><strong>Country:</strong>
                                    {{ $billingDetails['country'] ?? 'N/A' }}
                                </p>
                                <p><strong>ZIP Code:</strong>
                                    {{ $billingDetails['zip'] ?? 'N/A' }}
                                </p>
                                <p><strong>Company:</strong>
                                    {{ $billingDetails['company'] ?? 'N/A' }}
                                </p>
                                <p><strong>GST:</strong>
                                    {{ $billingDetails['gst'] ?? 'N/A' }}
                                </p>
                            </div>
                        </div>

                        <!-- Right Column - Shipping Details -->
                        <div class="col-md-6">
                            <h5>Shipping Details</h5>
                            <div class="card p-3 border rounded">
                                <p><strong>Name:</strong>
                                    {{ $shippingDetails['name'] ?? 'N/A' }}
                                </p>
                                <p><strong>Email:</strong>
                                    {{ $shippingDetails['email'] ?? 'N/A' }}
                                </p>
                                <p><strong>Phone:</strong>
                                    {{ $shippingDetails['phone'] ?? 'N/A' }}
                                </p>
                                <p><strong>Address:</strong>
                                    {{ $shippingDetails['address'] ?? 'N/A' }}
                                </p>
                                <p><strong>City:</strong>
                                    {{ $shippingDetails['city'] ?? 'N/A' }}
                                </p>
                                <p><strong>State:</strong>
                                    {{ $shippingDetails['state'] ?? 'N/A' }}
                                </p>
                                <p><strong>Country:</strong>
                                    {{ $shippingDetails['country'] ?? 'N/A' }}
                                </p>
                                <p><strong>ZIP Code:</strong>
                                    {{ $shippingDetails['zip'] ?? 'N/A' }}
                                </p>
                                <p><strong>Company:</strong>
                                    {{ $shippingDetails['company'] ?? 'N/A' }}
                                </p>
                                <p><strong>GST:</strong>
                                    {{ $shippingDetails['gst'] ?? 'N/A' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 mb-4">
                <h4>Product Details</h4>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Image</th>
                                <th class="text-left">Product Name</th>
                                <th>Price</th>
                                <th class="text-right">Quantity</th>
                                <th class="text-right">Total Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $orderItem)
                                @php
                                    $productId = $orderItem->product_id;
                                    $variantId = $orderItem->variant_id;
                                    $image = null;
                                    if ($variantId) {
                                    $image = App\Models\ProductImage::where('variant_id',
                                    $variantId)->value('image_path');
                                    }
                                    if (!$image) {
                                    $image = App\Models\ProductImage::where('product_id', $productId)
                                    ->orderBy('product_id', 'asc')
                                    ->value('image_path');
                                    }
                                    // get sale price if offer price is not available
                                    $price = $orderItem->offer_price ?? $orderItem->sale_price;
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><img src="{{ asset($image) }}" alt="product" class="product-image"
                                            style="width: 50px; height: 50px;"></td>
                                    <td class="text-left"><strong>{{ $orderItem->product_name }}</strong><br>
                                        @if($orderItem->variant_id)
                                            ({{ $orderItem->variant_name }})
                                        @endif
                                    </td>
                                    <td>{{ currencyPosition($price) }}
                                        @if($orderItem->sale_price)
                                            <span class="sale-price"
                                                style="text-decoration: line-through; font-size: 0.8em; color: gray; margin-left: 5px;">
                                                ₹{{ number_format($orderItem->sale_price, 2) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-right">{{ $orderItem->quantity }}</td>
                                    <td class="text-right">₹{{ number_format($orderItem->total, 2) }}</td>
                                </tr>
                            @endforeach
                            <!-- Subtotal Row -->
                            <tr>
                                <td colspan="6" class="text-right"><strong>SubTotal:
                                        ₹{{ number_format($order->subtotal, 2) }}</strong></td>
                                <!-- Dynamic Subtotal -->
                            </tr>

                            <!-- Coupon Applied Row (Uncomment if needed) -->
                            {{-- <tr>
                                <td colspan="4" class="text-right"><strong>Coupon Applied (@{{ $order->coupon_code }}):</strong></td>
                            <td><strong>- ₹{{ number_format($order->coupon_discount, 2) }}</strong></td>
                            </tr> --}}

                            <!-- Total Quantity and Total Price Row -->
                            <tr>
                                <td colspan="5" class="text-right"><strong>Total Quantity:</strong>
                                    {{ $order->quantity }}</td>
                                <td class="text-right"><strong>Total Price: ₹{{ number_format($order->grand_total, 2) }}</strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>



        <!-- Order Actions -->
        <div class="row">
            <div class="col-12 mb-2">
                <h4>Actions</h4>
                <div class="btn-group">
                    <a href="#" class="btn btn-secondary">View Invoice</a>
                </div>
                <div class="btn-group">
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">Back to My Account</a>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection
