@extends('frontend.layouts.master')
@section('content')
<section class="page_banner" style="background-image: url(assets/images/banner.jpg);">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="pb_title">Cart</h3>
                <div class="page_crumb">
                    <a href="{{ route('home') }}">Home</a> | <span>Cart</span>
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
                                    <th class="product-price">Price</th>
                                    <th class="product-quantity">Quantity</th>
                                    <th class="product-total">Subtotal</th>
                                    <th class="product-remove">Remove</th>
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
                                        <td class="product-quantity clearfix">
                                            <div class="quantityd clearfix">
                                                <button type="button" class="qtyBtn btnMinus"
                                                    data-action="decrease">-</button>
                                                <input name="qty" value="{{ $item->qty }}"
                                                    class="input-text qty text carqty" type="text" min="1">
                                                <button type="button" class="qtyBtn btnPlus"
                                                    data-action="increase">+</button>
                                            </div>
                                            <p class="qty-error text-danger d-none"></p>
                                        </td>
                                        <td class="product-total">
                                            <div class="product_price clearfix">
                                                <span class="price">₹<span
                                                        class="total-price">{{ number_format($item->price * $item->qty, 2) }}</span></span>
                                            </div>
                                        </td>
                                        <td class="" style="text-align: center;">
                                            <a href="javascript:void(0);" style="color: red;">
                                                <i class="far fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="8" class="actions">
                                        <button type="button" class="button fishto-btn clear-cart">Clear All</button>
                                        <button type="button" class="button fishto-btn proceed-checkout">Proceed to
                                            Checkout</button>
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
            const cartForm = document.querySelector('.woocommerce-cart-form');
            const qtyButtons = document.querySelectorAll('.qtyBtn');
            const qtyInputs = document.querySelectorAll('.carqty');
            const removeButtons = document.querySelectorAll('.cart-item .fa-trash-alt');
            const proceedCheckoutButton = document.querySelector('.proceed-checkout');
            const clearCartButton = document.querySelector('.clear-cart');

            // Disable the checkout button initially
            disableCheckoutButton(true);

            if (clearCartButton) {
                clearCartButton.addEventListener('click', async function () {
                    if (confirm('Are you sure you want to clear the entire cart?')) {
                        try {
                            const response = await fetch('/cart/clear', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                },
                            });

                            const data = await response.json();

                            if (data.success) {
                                alert('Cart cleared successfully!');
                                location.reload(true); // Reload the page
                            } else {
                                alert('Failed to clear the cart. Please try again.');
                            }
                        } catch (error) {
                            console.error('Error clearing the cart:', error);
                            alert('An error occurred while clearing the cart. Please try again.');
                        }
                    }
                });
            }

            qtyButtons.forEach(button => {
                button.addEventListener('click', async function (event) {
                    event.preventDefault(); // Prevent default form submission

                    const action = this.dataset.action;
                    const row = this.closest('.cart-item');
                    const qtyInput = row.querySelector('.carqty');
                    const unitPriceElement = row.querySelector('.unit-price');
                    const totalPriceElement = row.querySelector('.total-price');
                    const rowId = row.dataset.rowId;
                    const productId = row.dataset.productId;
                    const variantId = row.dataset.variantId;
                    const qtyError = row.querySelector('.qty-error');

                    let currentQty = parseInt(qtyInput.value) || 1;
                    let newQty = currentQty;

                    // Determine the new quantity
                    if (action === 'increase') {
                        newQty++;
                    } else if (action === 'decrease' && currentQty > 1) {
                        newQty--;
                    }

                    // Pass the new quantity to the server
                    const result = await updateCart(rowId, productId, variantId, newQty);
                    if (result.success) {
                        qtyError.classList.add('d-none'); // Hide error if successful

                        // Update the UI with the new quantity and total price
                        qtyInput.value = newQty;
                        const unitPrice = parseFloat(unitPriceElement.textContent.replace(
                            /,/g, ''));
                        totalPriceElement.textContent = (unitPrice * newQty).toLocaleString(
                            undefined, {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                        setTimeout(() => {
                            location.reload(true);
                        }, 500);
                    } else {
                        // Handle quantity adjustment if stock constraints are encountered
                        qtyError.textContent = result.message || 'An error occurred.';
                        qtyError.classList.remove('d-none');

                        // Automatically adjust to the available quantity and update cart
                        if (result.max_qty || result.min_qty) {
                            const adjustedQty = result.max_qty || result.min_qty;

                            // Update the input field to reflect adjusted quantity
                            qtyInput.value = adjustedQty;

                            // Update the cart package and user cart with the adjusted quantity
                            const adjustResult = await updateCart(rowId, productId, variantId, adjustedQty);

                            if (adjustResult.success) {
                                // Update the total price in the UI
                                const unitPrice = parseFloat(unitPriceElement.textContent.replace(/,/g, ''));
                                totalPriceElement.textContent = (unitPrice * adjustedQty).toLocaleString(undefined, {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                });

                                // Reload the page after a delay
                                setTimeout(() => {
                                    location.reload(true);
                                }, 500); // Reload after 2 seconds
                            }
                        }
                    }

                    // Check if checkout button can be enabled
                    validateCart();
                });
            });

            qtyInputs.forEach(qtyInput => {
                qtyInput.addEventListener('input', debounce(async function () {
                    const row = this.closest('.cart-item');
                    const unitPriceElement = row.querySelector('.unit-price');
                    const totalPriceElement = row.querySelector('.total-price');
                    const rowId = row.dataset.rowId;
                    const productId = row.dataset.productId;
                    const variantId = row.dataset.variantId;
                    const qtyError = row.querySelector('.qty-error');

                    let newQty = parseInt(this.value) || 1;

                    // Pass the new quantity to the server
                    const result = await updateCart(rowId, productId, variantId,
                    newQty);
                    if (result.success) {
                        qtyError.classList.add('d-none'); // Hide error if successful

                        // Update the UI with the new quantity and total price
                        this.value = newQty;
                        const unitPrice = parseFloat(unitPriceElement.textContent
                            .replace(/,/g, ''));
                        totalPriceElement.textContent = (unitPrice * newQty)
                            .toLocaleString(undefined, {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                        setTimeout(() => {
                            location.reload(true);
                        }, 500);
                    } else {
                        // Show error message
                        qtyError.textContent = result.message || 'An error occurred.';
                        qtyError.classList.remove('d-none');
                        // Automatically adjust to the available quantity and update cart
                        if (result.max_qty || result.min_qty) {
                            const adjustedQty = result.max_qty || result.min_qty;

                            // Update the input field to reflect adjusted quantity
                            qtyInput.value = adjustedQty;

                            // Update the cart package and user cart with the adjusted quantity
                            const adjustResult = await updateCart(rowId, productId, variantId, adjustedQty);

                            if (adjustResult.success) {
                                // Update the total price in the UI
                                const unitPrice = parseFloat(unitPriceElement.textContent.replace(/,/g, ''));
                                totalPriceElement.textContent = (unitPrice * adjustedQty).toLocaleString(undefined, {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                });

                                // Reload the page after a delay
                                setTimeout(() => {
                                    location.reload(true);
                                }, 500); // Reload after 2 seconds
                            }
                        }
                        setTimeout(() => {
                            location.reload(true);
                        }, 500);
                    }

                    // Check if checkout button can be enabled
                    validateCart();
                }, 300)); // Debounced to reduce frequent server calls
            });

            async function updateCart(rowId, productId, variantId, quantity) {
                try {
                    const response = await fetch('{{ route('cart.update') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .content,
                        },
                        body: JSON.stringify({
                            row_id: rowId,
                            product_id: productId,
                            variant_id: variantId,
                            quantity: quantity
                        }),
                    });
                    const data = await response.json();
                    return data; // Return success or error data
                } catch (error) {
                    console.error('Error:', error);
                    return {
                        success: false,
                        message: 'A network error occurred. Please try again.'
                    };
                }
            }

            removeButtons.forEach(button => {
                button.closest('a').addEventListener('click', async function (event) {
                    event.preventDefault(); // Prevent default anchor click behavior
                    const row = button.closest('.cart-item');
                    const rowId = row.dataset.rowId;

                    if (confirm(
                        'Are you sure you want to remove this item from the cart?')) {
                        try {
                            const response = await fetch(
                                '{{ route('cart.remove') }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]').content,
                                    },
                                    body: JSON.stringify({
                                        row_id: rowId
                                    }),
                                });

                            const data = await response.json();

                            if (data.success) {
                                toastr.success(data.message);
                                // row.remove();
                                setTimeout(() => {
                                    location.reload(true);
                                }, 500);
                            } else {
                                toastr.error(data.message ||
                                    'Failed to remove item. Please try again.');
                            }
                        } catch (error) {
                            console.error('Error removing item:', error);
                            toastr.error('An error occurred. Please try again.');
                        }
                    }
                });
            });

            async function checkStockForCartItems() {
                const cartItems = document.querySelectorAll('.cart-item');
                if (cartItems.length === 0) {
                    return; // Skip stock validation if the cart is empty
                }
                try {
                    const response = await fetch('{{ route('cart.check-stock') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        },
                        body: JSON.stringify({
                            cart_items: Array.from(cartItems).map(row => ({
                                row_id: row.dataset.rowId,
                                product_id: row.dataset.productId,
                                variant_id: row.dataset.variantId,
                                quantity: parseInt(row.querySelector('.carqty').value) || 1,
                            })),
                        }),
                    });

                    const data = await response.json();

                    if (data.success) {
                        data.items.forEach(item => {
                            const row = document.querySelector(`.cart-item[data-row-id="${item.row_id}"]`);
                            const qtyInput = row.querySelector('.carqty');
                            const qtyError = row.querySelector('.qty-error');
                            const removeButton = row.querySelector('.fa-trash-alt');
                            const userType = "{{ auth()->check() ? auth()->user()->role : 'user' }}"; // Fetch user type

                            if (userType === 'user' && item.available_qty === 0) {
                                // Out of stock for users
                                qtyError.textContent = 'Out of Stock. Please remove this item.';
                                qtyError.classList.remove('d-none');
                                qtyInput.disabled = true;
                                removeButton.closest('a').classList.add('highlight-remove'); // Highlight remove button
                            } else if (userType === 'user' && item.requested_qty > item.available_qty) {
                                // Max quantities apply to user only
                                qtyError.textContent = `Only ${item.available_qty} left in stock. Reduce the quantity.`;
                                qtyError.classList.remove('d-none');
                            } else if (userType !== 'user' && item.requested_qty < item.min_order_qty) {
                                // Min quantities apply to distributors
                                qtyError.textContent = `Minimum order quantity is ${item.min_order_qty}.`;
                                qtyError.classList.remove('d-none');
                            } else {
                                // Valid stock
                                qtyError.classList.add('d-none');
                                qtyInput.disabled = false;
                            }
                        });
                    } else {
                        toastr.error('Failed to validate stock availability.');
                    }
                } catch (error) {
                    console.error('Error checking stock:', error);
                    toastr.error('An error occurred while validating stock. Please try again.');
                }
            }

            function disableCheckoutButton(disable) {
                if (proceedCheckoutButton) {
                    proceedCheckoutButton.disabled = disable;
                    proceedCheckoutButton.style.opacity = disable ? '0.5' : '1';
                }
            }

            function validateCart() {
                const errors = document.querySelectorAll('.qty-error:not(.d-none)');
                disableCheckoutButton(errors.length > 0);
            }

            (async function initializeStockCheck() {
                await checkStockForCartItems();
                validateCart();
            })();

            function debounce(func, delay) {
                let timeout;
                return function (...args) {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(this, args), delay);
                };
            }

            if (proceedCheckoutButton) {
                proceedCheckoutButton.addEventListener('click', async function () {
                    try {
                        const response = await fetch('{{ route('cart.validateBeforeCheckout') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            },
                        });

                        const data = await response.json();

                        if (data.success) {
                            // Redirect to checkout page
                            window.location.href = '{{ route('checkout.index') }}';
                        } else {
                            // Display validation errors
                            handleValidationErrors(data.errors);
                        }
                    } catch (error) {
                        console.error('Error validating cart:', error);
                        alert('An error occurred while validating the cart. Please try again.');
                    }
                });
            }

            function handleValidationErrors(errors) {
                errors.forEach(error => {
                    const row = document.querySelector(`.cart-item[data-row-id="${error.row_id}"]`);
                    const qtyError = row.querySelector('.qty-error');

                    if (qtyError) {
                        qtyError.textContent = error.message;
                        qtyError.classList.remove('d-none');
                    }
                });

                alert('Please fix the errors before proceeding to checkout.');
            }
        });
    </script>
@endpush