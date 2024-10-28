@extends('admin.layouts.master')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1> Products</h1>
        </div>
    </section>
    <div class="card card-primary">
        <div class="card-header">
            <h4>Edit Product</h4>

        </div>
        <div class="card-body">
            <form action="{{ route('admin.product.update', $product->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <div id="image-preview" class="image-preview">
                        <label for="image-upload" id="image-label">Choose File</label>
                        <input type="file" name="image" id="image-upload" />
                    </div>
                </div>
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" value="{{ $product->name }}" class="form-control">
                </div>
                <div class="form-group">
                    <label>Category</label>
                    <select name="category" class="form-control select2">
                        <option value="">Select</option>
                        @foreach ($categories as $category)
                            <option @selected($product->category_id === $category->id) value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach

                    </select>
                </div>
                <div class="form-group">
                    <label>Price</label>
                    <input type="text" name="price" value="{{ $product->price }}" class="form-control">
                </div>

                <div class="form-group">
                    <label>Offer Price</label>
                    <input type="text" name="offer_price" value="{{ $product->offer_price }}" class="form-control">
                </div>
                <div class="form-group">
                    <label>Quantity</label>
                    <input type="text" name="quantity" value="{{ $product->quantity }}" class="form-control">
                </div>

                <div class="form-group">
                    <label>Short Description</label>
                    <textarea name="short_description"  class="form-control">{!! $product->short_description !!}</textarea>
                </div>
                <div class="form-group">
                    <label>Long Description</label>
                    <textarea name="long_description"  class="form-control summernote">{!! $product->long_description !!}</textarea>
                </div>
                <div class="form-group">
                    <label>Sku</label>
                    <input type="text" name="sku" value="{{ $product->sku }}" class="form-control">
                </div>
                <div class="form-group">
                    <label>Seo Title</label>
                    <input type="text" name="seo_title" value="{!! $product->seo_title !!}" class="form-control">
                </div>
                <div class="form-group">
                    <label>Seo Description</label>
                    <textarea name="seo_description" class="form-control">{!! $product->seo_description !!}</textarea>
                </div>
                <div class="form-group">
                    <label>Show At Home</label>
                    <select name="show_at_home" class="form-control">
                        <option  @selected($product->show_at_home ===1) value="1">Yes</option>
                        <option  @selected($product->show_at_home ===0)  value="0">No</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option  @selected($product->status ===1) value="1">Active</option>
                        <option  @selected($product->status ===0) value="0">Inactive</option>
                    </select>
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
                'background-image': 'url({{ asset($product->thumb_image) }})',
                'background-size': 'cover',
                'background-position': 'center center',
            })
        })
    </script>
@endpush
