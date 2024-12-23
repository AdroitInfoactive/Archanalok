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

    <section class="account-section">
        <div class="container">
            <div class="row justify-content-center"> <!-- Centering the row -->
                <div class="col-md-6 col-xl-3 mb-4"> <!-- Profile Box -->
                    <div class="account-box">
                        <i class="fas fa-user icon"></i>
                        <h4>Profile</h4>
                        <a href="{{ route('profile.index') }}" class="btn">Edit Profile</a>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3 mb-4"> <!-- My Orders Box -->
                    <div class="account-box">
                        <i class="fas fa-box icon"></i>
                        <h4>My Orders</h4>
                        <a href="myorders.html" class="btn">View Orders</a>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3 mb-4"> <!-- Wishlist Box -->
                    <div class="account-box">
                        <i class="fas fa-heart icon"></i>
                        <h4>Wishlist</h4>
                        <a href="{{ route('wishlist.index') }}" class="btn">View Wishlist</a>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3 mb-4"> <!-- My Address Box -->
                    <div class="account-box">
                        <i class="fas fa-map-marker-alt icon"></i>
                        <h4>My Address</h4>
                        <a href="{{ route('address.index') }}" class="btn">Manage Address</a>
                    </div>
                </div>
                <!-- Logout -->
                <div class="col-md-6 col-xl-3 mb-4">
                    <div class="account-box">
                        <i class="fas fa-sign-out-alt icon"></i>
                        <h4>Logout</h4>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                        <a href="#" onclick="event.preventDefault(); this.closest('form').submit();" class="btn">Logout</a>
                        </form>
                    </div>
                </div>
                
            </div>
        </div>
    </section>
@endsection
@push('styles')
    <style>
        .account-section {
            padding: 50px 0;
            /* Add padding to the section */
        }

        .account-box {
            border: 1px solid #ccc;
            /* Border for the boxes */
            border-radius: 8px;
            /* Rounded corners */
            padding: 40px;
            /* Padding inside the box */
            text-align: center;
            /* Center text */
            background-color: #fff;
            /* Background color */
            transition: box-shadow 0.3s;
            /* Transition for hover effect */
        }

        .account-box:hover {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            /* Shadow effect on hover */
        }

        .icon {
            font-size: 40px;
            /* Icon size */
            color: #545454;
            /* Icon color */
            margin-bottom: 10px;
            /* Space below the icon */
        }

        h4 {
            font-size: 1.2rem;
            /* Smaller heading size */
            margin: 10px 0;
            /* Space above and below the heading */
        }

        .btn {
            background-color: #f36e2d;
            /* Button background color */
            color: white;
            /* Button text color */
            border: none;
            /* Remove default border */
            padding: 10px 15px;
            /* Button padding */
            border-radius: 5px;
            /* Rounded corners */
            text-decoration: none;
            /* Remove underline */
            transition: background-color 0.3s;
            /* Transition for hover */
        }

        .btn:hover {
            background-color: #E2EEFF;
            /* Darker color on hover */
            font-weight: bold;
        }

        .wrapper {
            display: flex;
            justify-content: center;
            /* Center horizontally */
            align-items: center;
            /* Center vertically */
            margin: 0;

        }

        .container-2 {
            /* border: 1px solid #ccc; */
            padding: 20px;
            width: 500px;
            /* Set width for the profile container */
            /* border-radius: 10px; */
            text-align: center;
            background-color: white;
            /* Background color for the container */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            /* Subtle shadow */
            margin-top: 25px;
        }

        .profile-pic {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 15px;
        }


        h2 {
            margin-bottom: 15px;
            /* Space below heading */
        }

        .info {
            display: flex;
            flex-direction: column;
            /* Stack elements vertically */
            align-items: flex-start;
            /* Align items to the left */
        }

        .btn-edit {
            margin-top: 15px;
            /* Space above button */
            padding: 10px 15px;
            color: white;
            background-color: #f36e2d;
            /* Button color */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            /* No underline */
        }

        .btn-edit:hover {
            background-color: #E2EEFF;
            /* Darker shade on hover */
            font-weight: bold;
            color: #222F5A;
        }
    </style>
@endpush
