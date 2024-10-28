@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1> Product Gallery - {{ $product->name }}</h1>
        </div>
        <div>
            <a href="{{ route('admin.product.index') }}" class="btn btn-primary my-3">Back</a>
        </div>
    </section>
    <div class="card card-primary">
        <div class="card-header">
            <h4>All Product Images</h4>
        </div>
        <div class="card-body">
            <div class="col-md-8">

                <form action="{{ route('admin.product-gallery.store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <input type="file" name="image" class="form-control">
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <div class="card card-primary">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($images as $image)
                        <tr>
                            <td> <img src="{{ asset($image->image) }}" width="100px"></td>
                            {{-- <td> <a href="{{ route('admin.product-gallery.destroy', $image->id) }}" class="btn btn-danger delete-item btn-sm mx-2">Delete</td> --}}
                            <td><a href="{{ route('admin.product-gallery.destroy', $image->id) }}"
                                    class="btn btn-danger delete-item btn-sm mx-2"><i class="fa fa-trash"></i></a> </td>
                        </tr>
                    @endforeach
										@if ($images->count() == 0)
											<tr >
												<td colspan="2" class="text-center">No images found</td>
											</tr>
											
										@endif
                </tbody>


            </table>
        </div>
    </div>
@endsection
