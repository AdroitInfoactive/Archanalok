@extends('admin.layouts.master')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1> Product Category</h1>
        </div>
    </section>
    <div class="card card-primary">
        <div class="card-header">
            <h4>Add Category</h4>

        </div>
        <div class="card-body">
            <form action="{{ route('admin.sub-category.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label>Main Category</label>
                    <select name="main_category_id" class="form-control select2" id="mainCategorySelect">
                        <option value="">Select</option>
                        @foreach ($maincategories as $maincat)
                            <option value="{{ $maincat->id }}">{{ $maincat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Category</label>
                    <select name="category_id" class="form-control select2" id="categorySelect">
                        <option value="">Select</option>
                        <!-- Options will be populated by JavaScript -->
                    </select>
                </div>

                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control">
                </div>

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
                            <label>Image </label>
                            <div id="image-preview" class="image-preview">
                                <label for="image-upload" id="image-label">Choose Image</label>
                                <input type="file" name="image" id="image-upload" />
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
        $('#mainCategorySelect').on('change', function() {
            var mainCategoryId = this.value;
            if (mainCategoryId) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('admin.get-category.getCategoriesByMainCategory', '') }}" + '/' +
                        mainCategoryId,
                    success: function(data) {
                        $('#categorySelect').empty().append('<option value="">Select</option>');
                        $.each(data, function(key, value) {
                            $('#categorySelect').append('<option value="' + value.id + '">' +
                                value.name + '</option>');
                        });
                    },
                    error: function(data) {
                        console.error("Error fetching categories:", data);
                    }
                });
            } else {
                $('#categorySelect').empty().append('<option value="">Select</option>');
            }
        });
    </script>
@endpush
