@extends('admin.layouts.master')
@section('content')
<section class="section">
    <div class="section-header">
        <span onclick="goBack()" style="cursor: pointer; font-size: 1.5em;">
            <i class="fas fa-arrow-left"></i></span>&nbsp;
            <h1>Add Banner Slider</h1>
    </div>
</section>
<form action="{{ route('admin.banner-slider.store') }}" method="POST" enctype="multipart/form-data" class="form">
    @csrf
    <div class="row">
        <div class="col-md-4">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Banner Details</h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="">Title</label>
                        <input type="text" class="form-control" name="title" value="{{ old('title') }}">
                    </div>
                    <div class="form-group">
                        <label for="">Sub Title</label>
                        <input type="text" class="form-control" name="sub_title" value="{{ old('sub_title') }}">
                    </div>
                    <div class="form-group">
                        <label for="">Url</label>
                        <input type="text" class="form-control" name="url" value="{{ old('url') }}">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" id="description"
                            class="form-control">{{ old('description') }}</textarea>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label>Priority</label>
                            <input type="text" name="position" value="{{ old('position') }}"
                                class="form-control" min="1">
                        </div>
                        <div class="col-md-6">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Banner Image</h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Banner Image * <span class="text-danger">(1920x950px)</span></label>
                        <div id="image-preview" class="image-preview">
                            <label for="image-upload" id="image-label">Choose logo</label>
                            <input type="file" name="image" id="image-upload" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>

    <div class="text-center mt-3">
        <button class="btn btn-primary" type="submit">Create</button>
        <button class="btn btn-danger go-back" type="button" onclick="goBack()">Go Back</button>
    </div>
</form>

@endsection
@push('scripts')
    <script src="{{ asset('admin/assets/js/form-script.js') }}"></script>   
    @endpush