@extends('admin.layouts.master')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Product Main Category</h1>
        </div>
    </section>
    <div class="card card-primary">
        <div class="card-header">
            <h4>Add Main Category</h4>

        </div>
        <div class="card-body">
            <form action="{{ route('admin.main-category.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label>Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control">
                </div>
               {{--  <div class="form-group">
                    <label>Colour</label>
                    <input type="text" name="colour" value="{{ old('colour') }}" class="form-control">
                </div> --}}
                <div class="form-group">
                    <label> Description</label>
                    <textarea name="description" class="form-control summernote">{{ old('description') }}</textarea>
                </div>
                <div class="form-group">
                    <label>Seo Title</label>
                    <input type="text" name="seo_title" value="{{ old('seo_title') }}" class="form-control">
                </div>
                <div class="form-group">
                    <label>Seo Description</label>
                    <textarea name="seo_description" class="form-control">{{ old('seo_description') }}</textarea>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                  <div class="form-group">
                    <label>Proirity</label>
                    <input type="text" name="position" value="{{ old('position') }}" class="form-control">
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Logo *</label>
                            <div id="image-preview" class="image-preview">
                                <label for="image-upload" id="image-label">Choose logo</label>
                                <input type="file" name="logo" id="image-upload" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Image</label>
                            <div id="image-preview-2" class="image-preview img">
                                <label for="image-upload-2" id="image-label-2">Choose Image</label>
                                <input type="file" name="image" id="image-upload-2" />
                            </div>
                        </div>
                    </div>
                </div>
                    <button class="btn btn-primary btn-lg" type="submit">Create</button>
            </form>

        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $.uploadPreview({
            input_field: "#image-upload", // Default: .image-upload
            preview_box: "#image-preview", // Default: .image-preview
            label_field: "#image-label", // Default: .image-label
            label_default: "Choose File", // Default: Choose File
            label_selected: "Change File", // Default: Change File
            no_label: false, // Default: false
            success_callback: null // Default: null
        });
        $.uploadPreview({
            input_field: "#image-upload-2", // Default: .image-upload
            preview_box: "#image-preview-2", // Default: .image-preview
            label_field: "#image-label-2", // Default: .image-label
            label_default: "Choose File", // Default: Choose File
            label_selected: "Change File", // Default: Change File
            no_label: false, // Default: false
            success_callback: null // Default: null
        });
    </script>
@endpush
