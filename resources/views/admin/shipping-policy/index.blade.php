@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Shipping-policy</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Update Shipping-policy</h4>

            </div>
            <div class="card-body">
                <form action="{{ route('admin.shipping-policy.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                  
                 
                    <div class="form-group">
                        <label>Content</label>
                        <textarea name="content" class="summernote" class="form-control">{!! @$shippingPolicy->content !!}</textarea>
                    </div>
                  
                    <button type="submit" class="btn btn-primary d-flex justify-content-center mx-auto">Update</button>
                </form>
            </div>
        </div>
    </section>
@endsection


