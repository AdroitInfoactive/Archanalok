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

        <div class="row justify-content-center mb-4">
            <div class="col-md-12">
                <div class="account-box">
                    <h4>Address Book</h4>
                    <p>You have <strong>{{ $userAddresses->count() }}</strong> addresses saved.</p>
                </div>
            </div>
        </div>

        <div class="row">
            @foreach($userAddresses as $address)
                <div class="col-md-6 mb-4">
                    <div class="address-box">
                        <h5>{{ $address->is_default ? 'Default Shipping Address' : 'Additional Address' }}</h5>
                        <button class="close remove-address" onclick="deleteAddress({{ $address->id }})">&times;</button>
                        <p>{{ $address->first_name }} {{ $address->last_name }}</p>
                        <p>{{ $address->address }}</p>
                        <p>{{ $address->city }}, {{ $address->state }}, {{ $address->zip }}</p>
                        <p>{{ $address->country }}</p>
                        <p>Phone: {{ $address->phone }}</p>
                        <a href="javascript:void(0);" 
                           class="btn btn-secondary edit-address" 
                           data-id="{{ $address->id }}"
                           data-first_name="{{ $address->first_name }}"
                           data-last_name="{{ $address->last_name }}"
                           data-address="{{ $address->address }}"
                           data-city="{{ $address->city }}"
                           data-state="{{ $address->state }}"
                           data-zip="{{ $address->zip }}"
                           data-country="{{ $address->country }}"
                           data-phone="{{ $address->phone }}"
                           data-toggle="modal" data-target="#editAddressModal">
                            Edit Address
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row">
            <div class="col-md-12 mb-4">
                <button class="btn btn-primary" data-toggle="modal" data-target="#addAddressModal">Add New Address</button>
            </div>
        </div>
    </div>

    <!-- Add Address Modal -->
    <div class="modal fade" id="addAddressModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Add New Address</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="addAddressForm">
                    @csrf
                    <div class="modal-body">
                        @include('frontend.dashboard.sections.address_form_fields', ['prefix' => 'add'])
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
        <div class="modal-dialog">
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
                        @include('frontend.dashboard.sections.address_form_fields',  ['prefix' => 'edit'])
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
    // CSRF Setup
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
    });

    // Add Address
    $('#addAddressForm').on('submit', function (e) {
        e.preventDefault();
        const formData = $(this).serialize();

        $.post("{{ route('address.store') }}", formData, function (response) {
            toastr.success(response.message || 'Address added successfully!');
            $('#addAddressModal').modal('hide');
            window.location.reload();
        }).fail(function (xhr) {
            showErrors(xhr.responseJSON.errors);
        });
    });

    // Edit Address (Load Data into Form)
    $('.edit-address').on('click', function () {
        const fields = ['first_name', 'last_name', 'email', 'address', 'city', 'state', 'zip', 'country', 'phone'];
        $('#address_id').val($(this).data('id'));
        fields.forEach(field => $('#edit_' + field).val($(this).data(field)));
    });

    // Update Address
    $('#editAddressForm').on('submit', function (e) {
        e.preventDefault();
        const addressId = $('#address_id').val();
        const formData = $(this).serialize();

        $.ajax({
            url: `/address/${addressId}`,
            method: 'PUT',
            data: formData,
            success: function (response) {
                toastr.success(response.message || 'Address updated successfully!');
                $('#editAddressModal').modal('hide');
                window.location.reload();
            },
            error: function (xhr) {
                showErrors(xhr.responseJSON.errors);
            }
        });
    });

    // Delete Address
    function deleteAddress(id) {
        if (confirm('Are you sure you want to delete this address?')) {
            $.ajax({
                url: `/address/${id}`,
                method: 'DELETE',
                success: function (response) {
                    toastr.success(response.message || 'Address deleted successfully!');
                    window.location.reload();
                },
                error: function () {
                    toastr.error(response.message || 'Something went wrong. Please try again.');
                }
            });
        }
    }

    // Display validation errors
    function showErrors(errors) {
        if (errors) {
            Object.values(errors).forEach(error => toastr.error(error[0]));
        } else {
            toastr.error(response.message || 'Something went wrong. Please try again.');
        }
    }
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
        transition: background-color 0.3s ease; /* Smooth transition */
    }
    
    .btn-secondary {
        background-color: #f36e2d !important;
        border: none;
        color: white;
        padding: 10px 15px;
        transition: background-color 0.3s ease; /* Smooth transition */
    }
    
    .btn-primary:hover,
    .btn-secondary:hover {
        background-color: #E2EEFF !important; /* Change to blue on hover */
        color: #222F5A; /* Keep text color white */
        font-weight: bold;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .address-box {
            padding: 10px; /* Reduce padding on mobile */
        }
    
        .btn-primary, .btn-secondary {
            width: 100%; /* Full-width buttons on mobile */
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
        color: red; /* Color for the X button */
        font-size: 20px; /* Size of the X */
        position: absolute;
        right: 10px; /* Positioning of the button */
        top: 10px; /* Positioning of the button */
        cursor: pointer; /* Pointer cursor on hover */
    }
    .address-box {
        position: relative; /* To position the remove button */
        padding: 10px;
        border: 1px solid #ddd; /* Example styling */
        border-radius: 5px; /* Rounded corners */
        margin-bottom: 15px; /* Spacing between address boxes */
    }
    </style>
@endpush