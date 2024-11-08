@extends('admin.layouts.master')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1> Products</h1>
        </div>
    </section>
    <div class="card card-primary">
        <div class="card-header">
            <h4>Add Product</h4>

        </div>
        <div class="card-body">
            <form action="{{ route('admin.product.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <div id="image-preview" class="image-preview">
                        <label for="image-upload" id="image-label">Choose File</label>
                        <input type="file" name="image" id="image-upload" />
                    </div>
                </div>
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control">
                </div>
                <div class="form-group">
                    <label>Category</label>
                    <select name="category" class="form-control select2">
                        <option value="">Select</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach

                    </select>
                </div>
                <div class="form-group">
                    <label>Price</label>
                    <input type="text" name="price" value="{{ old('price') }}" class="form-control">
                </div>

                <div class="form-group">
                    <label>Offer Price</label>
                    <input type="text" name="offer_price" value="{{ old('offer_price') }}" class="form-control">
                </div>
                <div class="form-group">
                    <label>Quantity</label>
                    <input type="text" name="quantity" value="{{ old('quantity') }}" class="form-control">
                </div>

                <div class="form-group">
                    <label>Short Description</label>
                    <textarea name="short_description"  class="form-control">{{ old('short_description') }}</textarea>
                </div>
                <div class="form-group">
                    <label>Long Description</label>
                    <textarea name="long_description"  class="form-control summernote">{{ old('long_description') }}</textarea>
                </div>
                <div class="form-group">
                    <label>Sku</label>
                    <input type="text" name="sku" value="{{ old('sku') }}" class="form-control">
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
                    <label>Show At Home</label>
                    <select name="show_at_home" class="form-control">
                        <option value="1">Yes</option>
                        <option selected value="0">No</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                <button class="btn btn-primary btn-lg" type="submit">Create</button>
            </form>

        </div>
    </div>
@endsection
