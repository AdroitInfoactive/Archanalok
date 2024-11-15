@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Edit Banner Slider</h1>
    </div>
</section>

<form action="{{ route('admin.banner-slider.update', $bannerSlider->id) }}" method="POST" enctype="multipart/form-data" class="form">
    @csrf
    @method('PUT')

    <div class="row">
        <!-- Banner Details Card -->
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Banner Details</h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" name="title" value="{{ $bannerSlider->title }}">
                    </div>
                    <div class="form-group">
                        <label for="sub_title">Sub Title</label>
                        <input type="text" class="form-control" name="sub_title" value="{{ $bannerSlider->sub_title }}">
                    </div>
                    <div class="form-group">
                        <label for="url">URL</label>
                        <input type="text" class="form-control" name="url" value="{{ $bannerSlider->url }}">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" class="form-control">{{ $bannerSlider->description }}</textarea>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                        <label>Priority</label>
                        <input type="number" name="position" value="{{ $bannerSlider->position }}" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="1" @if($bannerSlider->status === 1) selected @endif>Active</option>
                            <option value="0" @if($bannerSlider->status === 0) selected @endif>Inactive</option>
                        </select>
                    </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Banner Image Card -->
        <div class="col-md-4">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Banner Image</h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Upload Image <span class="text-danger">(1920x950px)</span></label>
                        <div id="image-preview" class="image-preview" style="background-image: url({{ asset($bannerSlider->banner) }}); background-size: cover; background-position: center center;">
                            <label for="image-upload" id="image-label">Choose File</label>
                            <input type="file" name="image" id="image-upload">
                            <input type="hidden" name="old_image" value="{{ $bannerSlider->banner }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-3">
        <button type="submit" class="btn btn-primary">Update</button>
        <button type="button" class="btn btn-danger" onclick="history.back()">Cancel</button>
    </div>
</form>
@endsection
@push('scripts')
    <script>
        $(document).ready(function(){
            $('.image-preview').css({
                'background-image': 'url({{ asset($bannerSlider->banner) }})',
                'background-size': 'cover',
                'background-position': 'center center'
            })
        })
    </script>
@endpush
