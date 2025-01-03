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
                                        <button type="submit" class="button fishto-btn clear-cart">Clear All</button>
                                        <button type="submit" class="button fishto-btn clear-cart">Proceed to
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
                  const unitPrice = parseFloat(unitPriceElement.textContent.replace(/,/g, ''));
                  totalPriceElement.textContent = (unitPrice * newQty).toLocaleString(undefined, {
                      minimumFractionDigits: 2,
                      maximumFractionDigits: 2
                  });
              } else {
                  // Show error message
                  qtyError.textContent = result.message || 'An error occurred.';
                  qtyError.classList.remove('d-none');
                  if (result.max_qty) {
                      qtyInput.value = result.max_qty || newQty; // Set corrected quantity if available
                  } else {
                      qtyInput.value = result.min_qty || newQty;
                  }
              }
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
              const result = await updateCart(rowId, productId, variantId, newQty);
              if (result.success) {
                  qtyError.classList.add('d-none'); // Hide error if successful

                  // Update the UI with the new quantity and total price
                  this.value = newQty;
                  const unitPrice = parseFloat(unitPriceElement.textContent.replace(/,/g, ''));
                  totalPriceElement.textContent = (unitPrice * newQty).toLocaleString(undefined, {
                      minimumFractionDigits: 2,
                      maximumFractionDigits: 2
                  });
              } else {
                  // Show error message
                  qtyError.textContent = result.message || 'An error occurred.';
                  qtyError.classList.remove('d-none');
                  if (result.max_qty) {
                      this.value = result.max_qty || newQty; // Set corrected quantity if available
                  } else {
                      this.value = result.min_qty || newQty;
                  }
              }
          }, 300)); // Debounced to reduce frequent server calls
      });

      async function updateCart(rowId, productId, variantId, quantity) {
          try {
              const response = await fetch('{{ route('cart.update') }}', {
                  method: 'POST',
                  headers: {
                      'Content-Type': 'application/json',
                      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
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
              return { success: false, message: 'A network error occurred. Please try again.' };
          }
      }

      removeButtons.forEach(button => {
          button.closest('a').addEventListener('click', async function (event) {
              event.preventDefault(); // Prevent default anchor click behavior

              const row = button.closest('.cart-item');
              const rowId = row.dataset.rowId;

              if (confirm('Are you sure you want to remove this item from the cart?')) {
                  try {
                      const response = await fetch('{{ route('cart.remove') }}', {
                          method: 'POST',
                          headers: {
                              'Content-Type': 'application/json',
                              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                          },
                          body: JSON.stringify({ row_id: rowId }),
                      });

                      const data = await response.json();

                      if (data.success) {
                          toastr.success(data.message);
                          row.remove();
                          location.reload();
                      } else {
                          toastr.error(data.message || 'Failed to remove item. Please try again.');
                      }
                  } catch (error) {
                      console.error('Error removing item:', error);
                      toastr.error('An error occurred. Please try again.');
                  }
              }
          });
      });

      function debounce(func, delay) {
          let timeout;
          return function (...args) {
              clearTimeout(timeout);
              timeout = setTimeout(() => func.apply(this, args), delay);
          };
      }
  });
  </script>
@endpush
