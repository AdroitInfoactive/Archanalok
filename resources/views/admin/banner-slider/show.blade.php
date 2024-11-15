@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>View Banner Slider</h1>
    </div>
</section>

<div class="row">
    <!-- Banner Details Card -->
    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-header">
                <h4>Banner Details</h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Title:</label>
                    <p>{{ $bannerSlider->title }}</p>
                </div>
                <div class="form-group">
                    <label>Sub Title:</label>
                    <p>{{ $bannerSlider->sub_title }}</p>
                </div>
                <div class="form-group">
                    <label>URL:</label>
                    <p><a href="{{ $bannerSlider->url }}" target="_blank">{{ $bannerSlider->url }}</a></p>
                </div>
                <div class="form-group">
                    <label>Description:</label>
                    <p>{{ $bannerSlider->description }}</p>
                </div>
                <div class="form-group row">
                    <div class="col-md-6">
                    <label>Priority:</label>
                    <p>{{ $bannerSlider->position }}</p>
                </div>
                <div class="col-md-6">
                    <label>Status:</label>
                    <p>{{ $bannerSlider->status == 1 ? 'Active' : 'Inactive' }}</p>
                </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Banner Image Card -->
    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-header">
                <h4>Banner Image</h4>
            </div>
            <div class="card-body text-center">
                @if($bannerSlider->banner)
                    <img src="{{ asset($bannerSlider->banner) }}" alt="Banner Image" class="img-fluid" style="max-height: 300px;">
                @else
                    <p>No Image Available</p>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="text-center mt-3">
    <a href="{{ route('admin.banner-slider.index') }}" class="btn btn-danger">Back to List</a>
    <a href="{{ route('admin.banner-slider.edit', $bannerSlider->id) }}" class="btn btn-primary">Edit</a>
</div>
@endsection
