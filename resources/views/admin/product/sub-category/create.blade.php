@extends('admin.layouts.master')
@section('content')
<section class="section">
    <div class="section-header">
        <span onclick="goBack()" style="cursor: pointer; font-size: 1.5em;">
            <i class="fas fa-arrow-left"></i>
        </span>&nbsp;
        <h1>Add Sub-Category</h1>
    </div>
</section>

<form action="{{ route('admin.sub-category.store') }}" method="post" enctype="multipart/form-data"
    class="form">
    @csrf
    <div class="row">
        <div class="col-md-4">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Sub-Category Details</h4>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label>Main Category</label>
                            <select name="main_category_id" class="form-control select2" id="mainCategorySelect">
                                <option value="">Select</option>
                                @foreach($maincategories as $maincat)
                                    <option value="{{ $maincat->id }}">{{ $maincat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Category</label>
                            <select name="category_id" class="form-control select2" id="categorySelect">
                                <option value="">Select</option>
                                <!-- Options will be populated by JavaScript -->
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Name *</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description"
                            class="form-control">{{ old('description') }}</textarea>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label>Priority</label>
                            <input type="text" name="position" value="{{ old('position') }}"
                                class="form-control">
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
                    <h4>SEO Details</h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Seo Title</label>
                        <input type="text" name="seo_title" value="{{ old('seo_title') }}"
                            class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Seo Description</label>
                        <textarea name="seo_description"
                            class="form-control">{{ old('seo_description') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Images</h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Image *</label>
                        <div id="image-preview" class="image-preview">
                            <label for="image-upload" id="image-label">Choose Image</label>
                            <input type="file" name="image" id="image-upload" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="text-center mt-3">
        <button class="btn btn-primary btn-lg" type="submit">Create</button>
        <button class="btn btn-danger btn-lg" type="button" onclick="goBack()">Go Back</button>
    </div>
</form>
@endsection

@push('scripts')
    <script>
        $('#mainCategorySelect').on('change', function () {
            var mainCategoryId = this.value;
            if (mainCategoryId) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('admin.get-category.getCategoriesByMainCategory', '') }}" +
                        '/' + mainCategoryId,
                    success: function (data) {
                        $('#categorySelect').empty().append('<option value="">Select</option>');
                        $.each(data, function (key, value) {
                            $('#categorySelect').append('<option value="' + value.id +
                                '">' + value.name + '</option>');
                        });
                    },
                    error: function (data) {
                        console.error("Error fetching categories:", data);
                    }
                });
            } else {
                $('#categorySelect').empty().append('<option value="">Select</option>');
            }
        });

        $.uploadPreview({
            input_field: "#image-upload", // Default: .image-upload
            preview_box: "#image-preview", // Default: .image-preview
            label_field: "#image-label", // Default: .image-label
            label_default: "Choose File", // Default: Choose File
            label_selected: "Change File", // Default: Change File
            no_label: false, // Default: false
            success_callback: null // Default: null
        });

    </script>
@endpush
