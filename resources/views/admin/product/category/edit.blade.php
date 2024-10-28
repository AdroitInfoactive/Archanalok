@extends('admin.layouts.master')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Product Category</h1>
        </div>
    </section>
    <div class="card card-primary">
        <div class="card-header">
            <h4>Edit Product Category</h4>

        </div>
        <div class="card-body">
            <form action="{{ route('admin.category.update', $category->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Main Category</label>
                    <select name="main_category_id" class="form-control select2">
                        <option value="">Select</option>
                        @foreach ($maincategories as $maincat)
                            <option value="{{ $maincat->id }}" @selected($category->main_category_id == $maincat->id)>{{ $maincat->name }}</option>
                        @endforeach

                    </select>
                </div>
                <div class="form-group">
                    <label>name</label>
                    <input type="text" name="name" value="{{ $category->name }}" class="form-control">
                </div>
                <div class="form-group">
                    <label> Description</label>
                    <textarea name="description"  class="form-control summernote">{!! $category->description !!}</textarea>
                </div>
                <div class="form-group">
                    <label>Seo Title</label>
                    <input type="text" name="seo_title" value="{!! $category->seo_title !!}" class="form-control">
                </div>
                <div class="form-group">
                    <label>Seo Description</label>
                    <textarea name="seo_description" class="form-control">{!! $category->seo_description !!}</textarea>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option   @selected($category->status===1)  value="1">Active</option>
                        <option    @selected($category->status===0) value="0">Inactive</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Proirity</label>
                    <input type="text" name="position" value="{!! $category->position !!}" class="form-control">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Image</label>
                        <div id="image-preview-2" class="image-preview img">
                            <label for="image-upload-2" id="image-label-2">Choose Image</label>
                            <input type="file" name="image" id="image-upload-2" />
                            <input type="hidden" name="old_image" value="{{ @$category->image}}">
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
            $('.image-preview').css ({
                'background-image': 'url({{ asset($category->image) }})',
                'background-size': 'cover',
                'background-position': 'center center',
            })
        })
    </script>
@endpush
