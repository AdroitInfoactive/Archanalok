@extends('frontend.layouts.master')

@section('content')
    <!-- Hero Banner Start -->
    <section class="page_banner" style="background-image: url(assets/images/banner.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="pb_title">My Account</h3>
                    <div class="page_crumb">
                        <a href="index.html">Home</a> | <span>My Account</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner End -->

    <section class="auth-section">
        <div class="container">
            <div class="row justify-content-center"> <!-- Centering the row -->

                <div class="col-xl-5 col-md-6"> <!-- Register Form -->
                    <h2>Register</h2>

                    <form method="POST" class="signup-form" action="{{ route('register') }}">
                        @csrf
                       

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" placeholder="Full Name" name="name" value="{{ old('name') }}">
                        </div>
                        <div class="form-group">
                            <label for="signup-email">Email Address:</label>
                            <input type="email" placeholder="Email Id" id="email" name="email" value="{{ old('email') }}">
                        </div>
                        <div class="dropdown">
                            <label for="user-type">User Type:</label>
                            <select id="user_type" name="user_type">
                                <option value="">Select User Type</option>
                                <option value="user">General</option>
                                <option value="ws">Wholesale</option>
                                <option value="dr">Distributor</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="signup-password">Password:</label>
                            <input type="password" id="password" placeholder="Password" name="password" placeholder="Password" autocomplete="new-password">
                        </div>
                        <div class="form-group">
                            <label for="confirm-password">Confirm Password:</label>
                            <input type="password" name="password_confirmation" placeholder="Confirm Password" placeholder="Confirm Password">
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn">Register</button>
                        </div>
                    </form>
                    <div class="text-center" style="margin-top: 10px;">
                        <a href="{{ route('login') }}" class="forgot-password">Dont’t have an account ? Login</a>
                    </div>
                </div>

            </div>
        </div>
    </section>
  <!-- Back To Top -->
  <a href="#" id="back-to-top">
    <i class="arrow_carrot-2up"></i>
</a>
<!-- Back To Top -->
@endsection

@push('scripts')
<script>
    document.getElementById('my-address-btn').addEventListener('mouseover', function() {
    document.querySelector('.address-edit-options').style.display = 'block';
});

document.getElementById('my-address-btn').addEventListener('mouseout', function() {
    document.querySelector('.address-edit-options').style.display = 'none';
});

</script>
@endpush

@push('styles')
<style>

    .auth-section {
    padding: 50px 0; /* Add padding for spacing */
}

.auth-section h2 {
    margin-bottom: 30px; /* Space between heading and form */
}

.auth-section .form-group {
    margin-bottom: 20px; /* Space between form fields */
}

.auth-section .form-group label {
    margin-bottom: 5px; /* Space between label and input */
    display: block; /* Ensure label takes up full width */
}

.auth-section input {
    width: 100%; /* Make inputs full width */
    padding: 10px; /* Add padding for input fields */
    border: 1px solid #ccc; /* Add border to inputs */
    border-radius: 5px; /* Rounded corners for inputs */
}

.auth-section .btn {
    display: inline-block; /* Keep button inline */
    width: 100%; /* Set width of button to 100% */
    text-align: center; /* Center text inside the button */
    background-color: orange; /* Button color */
    color: white; /* Button text color */
    border: none; /* Remove default border */
    padding: 10px; /* Padding for the button */
    border-radius: 5px; /* Rounded corners */
    cursor: pointer; /* Pointer cursor on hover */
}

.auth-section .btn:hover {
    background-color: #f36e2d; /* Darker shade on hover */
}

.text-center {
    text-align: center; /* Center text inside */
    margin-top: 15px; /* Add space above the button */
}

@media (max-width: 768px) {
    .auth-section .col-xl-5, 
    .auth-section .col-md-6 {
        width: 100%; /* Stack forms on smaller screens */
    }
}

.forgot-password {
    color: orange; /* Color for the link */
    text-decoration: none; /* Remove underline from the link */
}

.forgot-password:hover {
    text-decoration: underline; /* Underline on hover for better visibility */
}




.btn-orange {
    background-color: orange; /* Set button color to orange */
    color: white; /* Text color */
    border: none; /* Remove border */
    padding: 10px 15px; /* Add padding */
    border-radius: 5px; /* Rounded corners */
    cursor: pointer; /* Pointer cursor on hover */
}

.btn-orange i {
    margin-right: 5px; /* Space between icon and text */
}

.btn-orange:hover {
    opacity: 0.9; /* Slightly dim button on hover */
}



.position-relative {
    position: relative; /* Position relative for dropdown */
}

.address-edit-options {
    position: absolute;
    background-color: white; /* Background color for dropdown */
    border: 1px solid #ccc; /* Border for dropdown */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Shadow for dropdown */
    margin-top: 10px; /* Space between button and dropdown */
    z-index: 1000; /* Ensures dropdown is on top */
}

#my-address-btn:hover + .address-edit-options,
.address-edit-options:hover {
    display: block; /* Show dropdown on hover */
}



.button-group {
    display: flex;
    justify-content: center; /* Center the buttons */
    gap: 20px; /* Space between buttons */
}

.btn {
    background-color: orange; /* Orange background */
    color: white; /* White text */
    border: none; /* Remove default border */
    padding: 10px 20px; /* Padding for buttons */
    cursor: pointer; /* Pointer on hover */
    border-radius: 5px; /* Rounded corners */
}

.address-edit-options {
    position: absolute;
    background-color: white; /* Background color for dropdown */
    border: 1px solid #ccc; /* Border for dropdown */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Shadow for dropdown */
    margin-top: 10px; /* Space between button and dropdown */
    z-index: 1000; /* Ensure dropdown is on top */
    display: none; /* Hide by default */
}

#my-address-btn:hover + .address-edit-options,
.address-edit-options:hover {
    display: block; /* Show dropdown on hover */
}


.dropdown {
    margin-bottom: 15px;
}

.dropdown select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

</style>  
@endpush
