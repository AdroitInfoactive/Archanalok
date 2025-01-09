@extends('frontend.layouts.master')
@section('content')
    <!-- Hero Banner Start -->
    <section class="page_banner" style="background-image: url({{ asset('assets/images/banner.jpg') }});">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="pb_title">My Address</h3>
                    <div class="page_crumb">
                        <a href="{{ route('home') }}">Home</a> | <span>My Account</span> | <span>My Address</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner End -->

    <section class="account-section">
        <div class="container">
            <h2 class="section-title">Select Shipping Address</h2>

            <!-- Address Summary -->
            <div class="row justify-content-center mb-4">
                <div class="col-md-12">
                    <div class="account-box">
                        <h4>Address Book</h4>
                        <p>You have <strong>{{ $userAddresses->count() }}</strong> addresses saved.</p>
                    </div>
                </div>
            </div>

            <!-- Display Existing Addresses -->
            <div class="row">
                @foreach ($userAddresses as $address)
                    <div class="col-md-6 mb-4">
                        <div class="address-box">
                            <h5>{{ $address->name }}</h5>
                            <button class="close remove-address delete-item"
                                data-url="{{ route('address.destroy', $address->id) }}">&times;</button>

                            <p>Address: {{ $address->address }}</p>
                            <p>{{ $address->city }}, {{ $address->stateName->name }}, {{ $address->zip }}</p>
                            <p>{{ $address->country }}</p>
                            <p>Email: {{ $address->email }}</p>
                            <p>Phone: {{ $address->phone }}</p>

                            <!-- Default Billing Address Checkbox -->
                            <input type="checkbox" class="default-billing" name="is_default_billing" id="is_default_billing_{{ $address->id }}"
                                value="{{ $address->id }}" {{ $address->is_default_billing ? 'checked' : '' }}>
                            <label for="is_default_billing_{{ $address->id }}">Default Billing Address</label>

                            <!-- Default Shipping Address Checkbox -->
                            <input type="checkbox" class="default-shipping" name="is_default_shipping" id="is_default_shipping_{{ $address->id }}"
                                value="{{ $address->id }}" {{ $address->is_default_shipping ? 'checked' : '' }}>
                            <label for="is_default_shipping_{{ $address->id }}">Default Shipping Address</label>

                            <a href="javascript:void(0);" class="btn btn-secondary edit-address"
                                data-id="{{ $address->id }}" data-name="{{ $address->name }}" data-email="{{ $address->email }}"
                                data-address="{{ $address->address }}" data-city="{{ $address->city }}"
                                data-state="{{ $address->state }}" data-zip="{{ $address->zip }}" data-phone="{{ $address->phone }}" data-company="{{ $address->company }}" data-gst="{{ $address->gst }}"
                                data-is_default_billing="{{ $address->is_default_billing }}" data-is_default_shipping="{{ $address->is_default_shipping }}" data-toggle="modal"
                                data-target="#editAddressModal">
                                Edit Address
                            </a>
                        </div>
                    </div>
                @endforeach
                            </div>

            <!-- Add Address Button -->
            <div class="row">
                <div class="col-md-12 mb-4">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#addAddressModal">Add New
                        Address</button>
                </div>
            </div>
        </div>

        <!-- Add Address Modal -->
        <div class="modal fade" id="addAddressModal">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Add New Address</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form id="addAddressForm">
                        @csrf
                        <div class="modal-body">
                            @include('frontend.dashboard.sections.address_form_fields', [
                                'prefix' => 'add',
                            ])
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save Address</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Address Modal -->
        <div class="modal fade" id="editAddressModal">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Edit Address</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form id="editAddressForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="address_id">
                        <div class="modal-body">
                            @include('frontend.dashboard.sections.address_form_fields', [
                                'prefix' => 'edit',
                            ])
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Update Address</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Ensure only one Default Billing Address is selected
            document.querySelectorAll('.default-billing').forEach(function (checkbox) {
                checkbox.addEventListener('change', function () {
                    if (this.checked) {
                        // Uncheck other billing checkboxes
                        document.querySelectorAll('.default-billing').forEach(function (otherCheckbox) {
                            if (otherCheckbox !== checkbox) {
                                otherCheckbox.checked = false;
                            }
                        });

                        // Send AJAX request to set the default billing address
                        setDefaultAddress(this.value, 'billing');
                    }
                });
            });

            // Ensure only one Default Shipping Address is selected
            document.querySelectorAll('.default-shipping').forEach(function (checkbox) {
                checkbox.addEventListener('change', function () {
                    if (this.checked) {
                        // Uncheck other shipping checkboxes
                        document.querySelectorAll('.default-shipping').forEach(function (otherCheckbox) {
                            if (otherCheckbox !== checkbox) {
                                otherCheckbox.checked = false;
                            }
                        });

                        // Send AJAX request to set the default shipping address
                        setDefaultAddress(this.value, 'shipping');
                    }
                });
            });

            // Function to update default address via AJAX
            async function setDefaultAddress(addressId, type) {
                try {
                    const response = await fetch('{{ route('address.setDefault') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        },
                        body: JSON.stringify({ address_id: addressId, type: type }),
                    });
                    const data = await response.json();
                    if (data.success) {
                        toastr.success(data.message || 'Default address updated successfully.');
                    } else {
                        toastr.error(data.message || 'Failed to update default address.');
                    }
                } catch (error) {
                    console.error('Error updating default address:', error);
                    toastr.error('An error occurred. Please try again.');
                }
            }
        });



        $(document).ready(function() {
            // CSRF Setup
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            // Add Address
            $('#addAddressForm').on('submit', function(e) {
                e.preventDefault();
                const formData = $(this).serialize();
                $.post("{{ route('address.store') }}", formData, function(response) {
                    toastr.success(response.message || 'Address added successfully!');
                    $('#addAddressModal').modal('hide');
                    window.location.reload();
                }).fail(function(xhr) {
                    showErrors(xhr.responseJSON.errors);
                });
            });

            // Clear form fields when Add Address modal is shown
            $('#addAddressModal').on('show.bs.modal', function() {
                $('#addAddressForm')[0].reset(); // Reset all form fields
            });
            // Edit Address (Load Data into Form)
            $('.edit-address').on('click', function () {
                const fields = ['name', 'email', 'address', 'city', 'state', 'zip', 'company', 'gst', 'phone'];
                
                // Populate input fields
                $('#address_id').val($(this).data('id'));
                fields.forEach(field => $('#edit_' + field).val($(this).data(field)));

                // Handle checkbox fields explicitly
                $('#edit_is_default_billing').prop('checked', !!$(this).data('is_default_billing'));
                $('#edit_is_default_shipping').prop('checked', !!$(this).data('is_default_shipping'));
            });


            // Update Address
            $('#editAddressForm').on('submit', function(e) {
                e.preventDefault();
                const addressId = $('#address_id').val();
                const formData = $(this).serialize();
                $.ajax({
                    url: `{{ route('address.update', ':id') }}`.replace(':id', addressId),
                    method: 'PUT',
                    data: formData,
                    success: function(response) {
                        toastr.success(response.message || 'Address updated successfully!');
                        $('#editAddressModal').modal('hide');
                        window.location.reload();
                    },
                    error: function(xhr) {
                        showErrors(xhr.responseJSON.errors);
                    }
                });
            });


            // Display Validation Errors
            function showErrors(errors) {
                if (errors) {
                    Object.values(errors).forEach(error => toastr.error(error[0]));
                } else {
                    toastr.error('Something went wrong. Please try again.');
                }
            }
        });
    </script>
@endpush

@push('styles')
    <style>
        .account-section {
            padding: 20px;
        }

        .account-box {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            background-color: #f9f9f9;
            margin-bottom: 20px;
        }

        .address-box {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            background-color: #f9f9f9;
            margin-bottom: 15px;
        }

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

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .address-box {
                padding: 10px;
                /* Reduce padding on mobile */
            }

            .btn-primary,
            .btn-secondary {
                width: 100%;
                /* Full-width buttons on mobile */
            }
        }

        .modal-content {
            padding: 20px;
        }

        .modal-header {
            border-bottom: none;
        }

        .modal-body {
            padding: 20px;
        }

        .form-control {
            margin-bottom: 15px;
        }


        .remove-address {
            background: none;
            border: none;
            color: red;
            /* Color for the X button */
            font-size: 20px;
            /* Size of the X */
            position: absolute;
            right: 10px;
            /* Positioning of the button */
            top: 10px;
            /* Positioning of the button */
            cursor: pointer;
            /* Pointer cursor on hover */
        }

        .address-box {
            position: relative;
            /* To position the remove button */
            padding: 10px;
            border: 1px solid #ddd;
            /* Example styling */
            border-radius: 5px;
            /* Rounded corners */
            margin-bottom: 15px;
            /* Spacing between address boxes */
        }
    </style>
@endpush
