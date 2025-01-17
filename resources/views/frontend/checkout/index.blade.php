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
            <div class="col-lg-7">
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
                                    <td><strong>₹ {{ Cart::subtotal() }}</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="8" class="actions">
                                        <button type="button" class="button fishto-btn clear-cart" id="continueShoppingBtn">Continue Shopping</button>
                                        <button type="button" class="button fishto-btn proceed-checkout" id="editCartBtn">Edit Cart</button>
                                    </td>
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
            <div class="col-lg-5">
                <div class="cart-totals">
                    <h4>Cart Totals</h4>
                    <table class="shop_table shop_table_responsive">
                        <tbody>
                            <tr class="cart-subtotal">
                                <th>Shipping Address</th>
                                <td data-title="Subtotal">
                                    @php
                                        $defaultShippingAddress = $addresses->firstWhere('is_default_shipping', 1);
                                    @endphp

                                    @if($defaultShippingAddress)
                                        <strong>{{ $defaultShippingAddress->name }}</strong>
                                        <br>
                                        {{ $defaultShippingAddress->address }}, {{ $defaultShippingAddress->city }},
                                        {{ $defaultShippingAddress->state }},
                                        {{ $defaultShippingAddress->country }},
                                        {{ $defaultShippingAddress->zip }}
                                    @else
                                        <p>No default shipping address found.</p>
                                    @endif
                                    <div>
                                        <a href="javascript:void(0);" class="change-address text-primary"
                                            style="text-decoration: underline" data-toggle="modal"
                                            data-target="#changeAddressModal">Change</a>
                                    </div>
                                </td>
                            </tr>
                            <tr class="order-total">
                                <th>Subtotal</th>
                                <td data-title="Subtotal">
                                    <span class="woocommerce-Price-amount amount"><span
                                            class="woocommerce-Price-currencySymbol">₹ </span>{{ Cart::subtotal() }}</span>
                                </td>
                            </tr>
                            <tr class="woocommerce-shipping-totals shipping">
                                <th>Shipping</th>
                                <td class="text-right">To be paid on delivery
                                </td>
                            </tr>
                            <tr class="order-total">
                                <th>Total</th>
                                <td data-title="Total">
                                    <span class="woocommerce-Price-amount amount"><span
                                            class="woocommerce-Price-currencySymbol">₹</span> {{ Cart::subtotal() }}</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="wc-proceed-to-checkout">
                        <button type="button" id="confirmOrder" class="fishto-btn button alt wc-forward">
                            Confirm Order
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="changeAddressModal" tabindex="-1" role="dialog" aria-labelledby="changeAddressModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changeAddressModalLabel">Select Address</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h4>Confirm Your Billing and Shipping Address</h4>
                <p>Please ensure your billing address is exactly as it appears on the statement of the card you will be using.</p>
                <table class="table table-bordered address-table">
                    <thead>
                        <tr>
                            <th>Address</th>
                            <th>Billing</th>
                            <th>Shipping</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($addresses as $address)
                            <tr>
                                <td>
                                    <strong>{{ $address->name }}</strong>
                                    <br>
                                    {{ $address->address }}, {{ $address->city }}, {{ $address->state }}, {{ $address->country }}, {{ $address->zip }}
                                </td>
                                <td class="text-center">
                                    <input 
                                        type="radio" 
                                        name="billing_address" 
                                        value="{{ $address->id }}" 
                                        {{ $address->is_default_billing ? 'checked' : '' }}>
                                </td>
                                <td class="text-center">
                                    <input 
                                        type="radio" 
                                        name="shipping_address" 
                                        value="{{ $address->id }}" 
                                        {{ $address->is_default_shipping ? 'checked' : '' }}>
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="3" class="text-right">
                                <button type="button" class="btn btn-secondary edit-address-btn" data-id="{{ $address->id }}">Add / Edit</button>
                                <button type="button" class="btn btn-secondary confirm-address-btn" data-id="{{ $address->id }}">Confirm</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
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
        .address-table-container {
            margin: 20px 0;
        }

        .address-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .address-table th {
            background-color: #f8f9fa;
            text-align: center;
            font-weight: bold;
            padding: 10px;
        }

        .address-table td {
            padding: 15px;
            vertical-align: middle;
        }

        .address-table td.text-center {
            text-align: center;
        }

        .btn-secondary {
            background-color: #f36e2d;
            border: none;
            color: white;
            padding: 5px 10px;
            font-size: 0.9em;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background-color: #d35400;
        }

        h4 {
            font-weight: bold;
            margin-bottom: 10px;
        }

        p {
            color: #555;
            font-size: 0.9em;
            margin-bottom: 20px;
        }

    </style>
@endpush
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Redirect to the shopping page
            const continueShoppingBtn = document.getElementById('continueShoppingBtn');
            if (continueShoppingBtn) {
                continueShoppingBtn.addEventListener('click', function () {
                    window.location.href = '{{ route('home') }}'; // Replace '/shop' with the appropriate shopping page route
                });
            }
            // Redirect to the cart edit page
            const editCartBtn = document.getElementById('editCartBtn');
            if (editCartBtn) {
                editCartBtn.addEventListener('click', function () {
                    window.location.href = '{{ route('cart.index') }}'; // Replace '/cart/edit' with the appropriate cart edit page route
                });
            }
            document.querySelectorAll('.edit-address-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    window.location.href = '{{ route('address.index') }}';
                });
            });
            document.querySelectorAll('.confirm-address-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    const shippingAddressId = document.querySelector(`input[name="shipping_address"]:checked`).value;
                    const billingAddressId = document.querySelector(`input[name="billing_address"]:checked`).value;
                    // Update default billing address
                    updateDefaultAddress(billingAddressId, 'billing').then(() => {
                        // Update default shipping address after billing is updated
                        return updateDefaultAddress(shippingAddressId, 'shipping');
                    }).then(() => {
                        toastr.success('Default addresses updated successfully!');
                        window.location.reload(); // Reload the page to reflect changes
                    }).catch(error => {
                        console.error('Error updating default addresses:', error);
                        toastr.error('An error occurred while updating the default addresses. Please try again.');
                    });
                });
            });

            function updateDefaultAddress(addressId, type) {
                return fetch('{{ route('address.setDefault') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({
                        address_id: addressId,
                        type: type
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        throw new Error(data.message || 'Failed to update address.');
                    }
                });
            }

            const confirmOrderBtn = document.getElementById('confirmOrder');

            if (confirmOrderBtn) {
                confirmOrderBtn.addEventListener('click', async function () {
                    confirmOrderBtn.disabled = true; // Disable button to prevent multiple clicks

                    try {
                        const validationResponse = await fetchData('{{ route('cart.validateBeforeCheckout') }}');
                        
                        if (validationResponse.success) {
                            await processCheckout();
                        } else {
                            toastr.error(validationResponse.message || 'Some items in your cart are not available.');
                        }
                    } catch (error) {
                        console.error('Error during checkout validation:', error);
                        toastr.error('An error occurred while proceeding to checkout. Please try again.');
                    } finally {
                        confirmOrderBtn.disabled = false; // Re-enable button after processing
                    }
                });
            }

            /**
             * Generic function to make an API request.
             */
            async function fetchData(url) {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }

                return response.json();
            }

            /**
             * Function to handle the checkout process.
             */
            async function processCheckout() {
                try {
                    const checkoutResponse = await fetchData('{{ route('checkout.process') }}');

                    if (checkoutResponse.success) {
                        window.location.href = checkoutResponse.redirect_url;
                    } else {
                        toastr.error(checkoutResponse.message || 'Failed to store checkout data.');
                    }
                } catch (error) {
                    console.error('Error storing checkout data:', error);
                    toastr.error('An error occurred while storing checkout data.');
                }
            }
        });
    </script>
@endpush