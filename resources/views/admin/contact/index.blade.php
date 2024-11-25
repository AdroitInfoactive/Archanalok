@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Contact</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Update Contact</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.contact.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Phone Fields -->
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="phone_one">Phone One</label>
                        <input type="text" class="form-control" name="phone_one" value="{{ @$contact->phone_one }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="phone_two">Phone Two</label>
                        <input type="text" class="form-control" name="phone_two" value="{{ @$contact->phone_two }}">
                    </div>
                </div>

                <!-- Email Fields -->
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="mail_one">Email One</label>
                        <input type="text" class="form-control" name="mail_one" value="{{ @$contact->mail_one }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="mail_two">Email Two</label>
                        <input type="text" class="form-control" name="mail_two" value="{{ @$contact->mail_two }}">
                    </div>
                </div>

                <!-- Address Field -->
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" name="address" value="{{ @$contact->address }}">
                </div>

                <!-- Google Map Link -->
                <div class="form-group">
                    <label for="map_link">Google Map Link</label>
                    <input type="text" class="form-control" name="map_link" value="{{ @$contact->map_link }}">
                </div>

                <button type="submit" class="btn btn-primary d-flex justify-content-center mx-auto">Update</button>
            </form>
        </div>
    </div>
</section>
@endsection
