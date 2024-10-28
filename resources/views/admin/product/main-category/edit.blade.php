@extends('admin.layouts.master')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Product Main category</h1>
        </div>
    </section>
    <div class="card card-primary">
        <div class="card-header">
            <h4>Edit Product Main category</h4>

        </div>
        <div class="card-body">
            <form action="{{ route('admin.main-category.update', $maincategory->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>name</label>
                    <input type="text" name="name" value="{{ $maincategory->name }}" class="form-control">
                </div>
                <div class="form-group">
                    <label> Description</label>
                    <textarea name="description"  class="form-control summernote">{!! $maincategory->description !!}</textarea>
                </div>
                <div class="form-group">
                    <label>Seo Title</label>
                    <input type="text" name="seo_title" value="{!! $maincategory->seo_title !!}" class="form-control">
                </div>
                <div class="form-group">
                    <label>Seo Description</label>
                    <textarea name="seo_description" class="form-control">{!! $maincategory->seo_description !!}</textarea>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option   @selected($maincategory->status===1)  value="1">Active</option>
                        <option    @selected($maincategory->status===0) value="0">Inactive</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Proirity</label>
                    <input type="text" name="position" value="{!! $maincategory->position !!}" class="form-control">
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Logo *</label>
                            <div id="image-preview" class="image-preview logo">
                                <label for="image-upload" id="image-label">Choose logo</label>
                                <input type="file" name="logo" id="image-upload" />
                                <input type="hidden" name="old_logo" value="{{ @$maincategory->logo}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Image</label>
                            <div id="image-preview-2" class="image-preview img">
                                <label for="image-upload-2" id="image-label-2">Choose Image</label>
                                <input type="file" name="image" id="image-upload-2" />
                                <input type="hidden" name="old_image" value="{{ @$maincategory->image}}">
                            </div>
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary btn-lg" type="submit">Update</button>
            </form>

        </div>
    </div>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        $('.logo').css ({
            'background-image': 'url({{ asset($maincategory->logo) }})',
            'background-size': 'cover',
            'background-position': 'center center',
        })
        $('.img').css ({
            'background-image': 'url({{ asset($maincategory->image) }})',
            'background-size': 'cover',
            'background-position': 'center center',
        })
    })
</script>
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
