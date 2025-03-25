@extends('frontend.layouts.master')
@section('content')
<section class="page_banner" style="background-image: url(assets/images/banner.jpg);">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="pb_title">Orders</h3>
                <div class="page_crumb">
                    <a href="{{ route('home') }}">Home</a> | <span>Orders</span>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="order-detail-section cart-section">
    <div class="container">
        <h2 class="section-title">Your Orders</h2>
        <div class="row justify-content-center">
            <div class="col-12 mb-4">
                <!-- Order Summary Box -->
                <div class="account-box">
                    <h4>Order Summary</h4>
                    <p>You have <strong>{{ $orderCount }}</strong> orders in total.</p>
                    <p>Last order placed on <strong>{{ $lastOrderedDate }}</strong>.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 mb-4">
                <!-- Orders List -->
                <h4>Recent Orders</h4>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th class="d-none d-md-table-cell">Date</th> <!-- Hide on mobile -->
                                <th class="d-none d-md-table-cell">Status</th> <!-- Hide on mobile -->
                                <th>Total</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
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
                                @endphp
                                <tr>
                                    <td><a href="{{ route('orders.show', $order->id) }}" target="_blank">{{ $invoiceNo }}</a></td>
                                    <td class="d-none d-md-table-cell">{{ $formattedDate }}</td> <!-- Hide on mobile -->
                                    <td class="d-none d-md-table-cell">
                                        <span class="badge badge-{{ $orderStatus['color'] }}">
                                            {{ $orderStatus['label'] }}
                                        </span>
                                    </td>
                                    <!-- Hide on mobile -->
                                    <td>{{ currencyPosition(@$order->grand_total) }}</td>
                                    <td>
                                        <a href="{{ route('orders.show', $order->id) }}"
                                            class="btn btn-secondary btn-sm d-block d-md-inline">View
                                            Order</a> <!-- Small on mobile -->
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
