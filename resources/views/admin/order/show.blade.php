@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Order Preview</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item">Invoice</div>
        </div>
    </div>
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
    <div class="section-body">
        <div class="invoice">
            <div class="invoice-print">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="invoice-title">
                            <h2>Invoice</h2>
                            <div class="invoice-number">Order # {{ $invoiceNo }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <address>
                                    <strong>Billing Address:</strong><br>
                                     <strong>Name:</strong>
                                     {{ $billingDetails['name'] ?? 'N/A' }}
                                     <br>
                                     <strong>Email:</strong>
                                     {{ $billingDetails['email'] ?? 'N/A' }}
                                     <br>
                                     <strong>Phone:</strong>
                                     {{ $billingDetails['phone'] ?? 'N/A' }}
                                     <br>
                                     <strong>Address:</strong>
                                     {{ $billingDetails['address'] ?? 'N/A' }}
                                     <br>
                                     <strong>City:</strong>
                                     {{ $billingDetails['city'] ?? 'N/A' }}
                                     <br>
                                     <strong>State:</strong>
                                     {{ $billingDetails['state'] ?? 'N/A' }}
                                     <br>
                                     <strong>Country:</strong>
                                     {{ $billingDetails['country'] ?? 'N/A' }}
                                     <br>
                                     <strong>ZIP Code:</strong>
                                     {{ $billingDetails['zip'] ?? 'N/A' }}
                                     <br>
                                     <strong>Company:</strong>
                                     {{ $billingDetails['company'] ?? 'N/A' }}
                                     <br>
                                     <strong>GST:</strong>
                                     {{ $billingDetails['gst'] ?? 'N/A' }}
                                     <br>
                                </address>
                            </div>
                            <div class="col-md-6">
                                <address>
                                    <strong>Shipping Address:</strong><br>
                                    <strong>Name:</strong>
                                    {{ $shippingDetails['name'] ?? 'N/A' }}
                                    <br>
                                    <strong>Email:</strong>
                                    {{ $shippingDetails['email'] ?? 'N/A' }}
                                    <br>
                                    <strong>Phone:</strong>
                                    {{ $shippingDetails['phone'] ?? 'N/A' }}
                                    <br>
                                    <strong>Address:</strong>
                                    {{ $shippingDetails['address'] ?? 'N/A' }}
                                    <br>
                                    <strong>City:</strong>
                                    {{ $shippingDetails['city'] ?? 'N/A' }}
                                    <br>
                                    <strong>State:</strong>
                                    {{ $shippingDetails['state'] ?? 'N/A' }}
                                    <br>
                                    <strong>Country:</strong>
                                    {{ $shippingDetails['country'] ?? 'N/A' }}
                                    <br>
                                    <strong>ZIP Code:</strong>
                                    {{ $shippingDetails['zip'] ?? 'N/A' }}
                                    <br>
                                    <strong>Company:</strong>
                                    {{ $shippingDetails['company'] ?? 'N/A' }}
                                    <br>
                                    <strong>GST:</strong>
                                    {{ $shippingDetails['gst'] ?? 'N/A' }}
                                    <br>
                                </address>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <address>
                                    <strong>Payment Method:</strong> {{ $order->payment_method }}<br>
                                    <strong>Payment Status: </strong>
                                        @if(strtoupper($order->payment_status) == 1)
                                            <span class="badge badge-success">Completed</span>
                                        @elseif(strtoupper($order->payment_status) == 0)
                                            <span class="badge badge-warning">Pending</span>
                                        @else
                                            <span class="badge badge-danger">{{ $order->payment_status }}</span>
                                        @endif
                                </address>
                            </div>
                            <div class="col-md-6 text-md-right">
                                <address>
                                    <strong>Order Date:</strong>
                                        {{ date('F d, Y / H:i', strtotime($order->created_at)) }}<br>
                                    <strong>Order Status:</strong>
                                    <span class="badge badge-warning">{{ $order->order_status }}</span>
                                </address>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="section-title">Order Summary</div>
                        <p class="section-lead">All items here cannot be deleted.</p>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-md">
                                <tr>
                                    <th>S.No</th>
                                    <th>Image</th>
                                    <th class="text-left">Product Name</th>
                                    <th>Price</th>
                                    <th class="text-right">Quantity</th>
                                    <th class="text-right">Total Price</th>
                                </tr>
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
                                        <td><img src="{{ asset($image) }}" alt="product" class="product-image" style="width: 50px; height: 50px;"></td>
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

                            </table>
                        </div>
                        <div class="row mt-4">
                            <div class="col-lg-8">
                                <div class="col-md-4 d-print-none">
                                    <form action="{{ route('admin.orders.status-update', $order->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="">Payment Status</label>
                                            <select class="form-control" name="payment_status" id="">
                                                <option @selected($order->payment_status == 0) value="0">Pending</option>
                                                <option @selected($order->payment_status == 1) value="1">Completed</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="">Order Status</label>
                                            <select class="form-control" name="order_status" id="">
                                                <option @selected($order->order_status === 'Pending')
                                                    value="Pending">Pending</option>
                                                <option @selected($order->order_status === 'Placed')
                                                    value="Placed">Placed</option>
                                                <option @selected($order->order_status === 'Payment Received')
                                                    value="Payment Received">Payment Received</option>
                                                <option @selected($order->order_status === 'Shipped')
                                                    value="Shipped">Shipped</option>
                                                <option @selected($order->order_status === 'Delivered')
                                                    value="Delivered">Delivered</option>
                                                <option @selected($order->order_status === 'Cancelled')
                                                    value="Cancelled">Cancelled</option>
                                                <option @selected($order->order_status === 'Returned')
                                                    value="Returned">Returned</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-info">Update</button>
                                    </form>
                                </div>
                            </div>
                            <div class="col-lg-4 text-right">
                                <div class="invoice-detail-item">
                                    <div class="invoice-detail-name">Subtotal</div>
                                    <div class="invoice-detail-value">{{ currencyPosition($order->subtotal) }}</div>
                                </div>
                                <!-- <div class="invoice-detail-item">
                                    <div class="invoice-detail-name">Shipping</div>
                                    <div class="invoice-detail-value">{{ currencyPosition($order->delivery_charge) }}</div>
                                </div>
                                <div class="invoice-detail-item">
                                    <div class="invoice-detail-name">Discount</div>
                                    <div class="invoice-detail-value">{{ currencyPosition($order->discount) }}</div>
                                </div> -->
                                <hr class="mt-2 mb-2">
                                <div class="invoice-detail-item">
                                    <div class="invoice-detail-name">Total</div>
                                    <div class="invoice-detail-value invoice-detail-value-lg">{{ currencyPosition($order->grand_total) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="text-md-right">
                <div class="float-lg-left mb-lg-0 mb-3">

                </div>
                <button class="btn btn-warning btn-icon icon-left" id="print_btn"><i class="fas fa-print"></i>
                    Print</button>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    $(document).ready(function(){
        $('#print_btn').on('click', function() {
            let printContents = $('.invoice-print').html();

            let printWindow = window.open('', '', 'width=600,height=600');
            printWindow.document.open();
            printWindow.document.write('<html>');
            printWindow.document.write('<link rel="stylesheet" href="{{ asset("admin/assets/modules/bootstrap/css/bootstrap.min.css") }}">');

            printWindow.document.write('<body>');
            printWindow.document.write(printContents);
            printWindow.document.write('</body></html>');
            printWindow.document.close();

            printWindow.print();
            printWindow.close();

        })
    })
</script>
@endpush
