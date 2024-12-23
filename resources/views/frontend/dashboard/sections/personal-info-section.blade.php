@extends('frontend.layouts.master')
@section('content')
    <!-- Hero Banner Start -->
    <section class="page_banner" style="background-image: url(assets/images/banner.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="pb_title">My Account</h3>
                    <div class="page_crumb">
                        <a href="index.html">Home</a> | <span>My Account</span> | <span>Profile</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner End -->
    <div class="wrapper">
        <div class="container-2">
            <h2>Personal Information</h2>
            <img src="{{ asset($user->avatar) }}" alt="Profile Picture" class="profile-pic">
            <label for="upload"><i class="fas fa-camera"></i></label>
            <form id="avatar_form">
                <input type="file" id="upload" hidden name="avatar">
            </form>
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PUT')
            <div class="info">
                <p><strong>Name:</strong> <span class="required">*</span> 
                    <span id="name-display">{{ $user->name }}</span>
                    <input type="text" id="name-edit" name="name" value="{{ $user->name }}" style="display: none;">
                </p>
                <p><strong>Email:</strong> <span class="required">*</span> 
                    <span id="email-display">{{ $user->email }}</span>
                    <input type="email" id="email-edit" name="email" value="{{ $user->email }}" style="display: none;">
                </p>
            </div>
            <a href="javascript:void(0);" class="btn-edit" id="edit-button">Edit</a>
            <a href="javascript:void(0);" class="btn-edit" id="save-button" style="display: none;">Save</a>
            </form>
        </div>
        
      
    </div>
    <!-- Centered Home Button -->
    <div class="text-center mt-4 mb-5">
        <a href="{{ route('dashboard') }}" class="btn btn-primary">Go to My Account</a>
    </div>
@endsection
@push('scripts')
<script>
    document.getElementById('edit-button').addEventListener('click', function () {
        // Toggle visibility of static text and input fields
        document.getElementById('name-display').style.display = 'none';
        document.getElementById('email-display').style.display = 'none';
        document.getElementById('name-edit').style.display = 'block';
        document.getElementById('email-edit').style.display = 'block';

        // Show "Save" button and hide "Edit" button
        this.style.display = 'none';
        document.getElementById('save-button').style.display = 'inline-block';
    });

    document.getElementById('save-button').addEventListener('click', function () {
        // Submit the form to the backend
        this.closest('form').submit();
    });
</script>


    <script>
        $(document).ready(function() {
            $('#upload').on('change', function() {
                let form = $('#avatar_form')[0];
                let formData = new FormData(form);

                $.ajax({
                    method: 'POST',
                    url: "{{ route('profile.avatar.update') }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status === 'success') {
                            toastr.success(response.message);
                            window.location.reload();
                        }
                    },
                    error: function(error) {
                        console.error(response);
                    }
                })
            })
        })
    </script>
@endpush
@push('styles')
    <style>
        label {
            display: inline-block;
            cursor: pointer;
            font-size: 20px;
            /* Adjust size */
            color: #000;
            /* Adjust color */
        }

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
            border: 1px solid #ccc;
            padding: 20px;
            width: 500px;
            /* Set width for the profile container */
            /* border-radius: 10px; */
            text-align: center;
            background-color: white;
            /* Background color for the container */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            /* Subtle shadow */
            margin-top: 45px;
            margin-bottom: 45px;
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


        .required {
            color: red;
            /* Color for required field indicator */
            font-size: 14px;
            /* Size of the required indicator */
        }
    </style>
@endpush
