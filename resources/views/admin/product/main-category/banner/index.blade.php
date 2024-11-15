@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <span onclick="goBack()" style="cursor: pointer; font-size: 1.5em;">
                <i class="fas fa-arrow-left"></i></span>&nbsp;
            <h1> Product Main Category Banner - {{ $maincategory->name }}</h1>
        </div>
    </section>

    
<div class="card card-primary">
    <div class="card-header">
        <h4>Add Product Main Category Banner</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.main-category-banner.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-row">
                <div class="col-md-4">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control" placeholder="Enter Banner Title" >
                </div>
                <div class="col-md-4">
                    <label for="image">Image</label>
                    <input type="file" name="image" class="form-control" >
                </div>
                <div class="col-md-4">
                    <label for="position">Position</label>
                    <input type="number" name="position" class="form-control" placeholder="Position" min="1" >
                </div>
            </div>
            <input type="hidden" name="main_category_id" value="{{ $maincategory->id }}">
            <div class="text-right mt-3">
                <button type="submit" class="btn btn-primary">Upload Banner</button>
            </div>
        </form>
    </div>
</div>
    <div class="card card-primary">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Position</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($images as $image)
                        <tr>
                            <td> {{ $loop->iteration }} </td>
                            <td> {{ $image->title }} </td>
                            <td> <img src="{{ asset($image->image) }}" width="100px"></td>
                            <td>{{ $image->position }}</td>
                            <td><a href="{{ route('admin.main-category-banner.destroy', $image->id) }}"
                                    class="btn btn-danger delete-item btn-sm mx-2"><i class="fa fa-trash"></i></a> </td>
                        </tr>
                    @endforeach
                    @if ($images->count() == 0)
                        <tr>
                            <td colspan="4" class="text-center">No images found</td>
                        </tr>
                    @endif
                </tbody>


            </table>
        </div>
    </div>
@endsection
@push('scripts')
<script src="{{ asset('admin/assets/js/form-script.js') }}"></script>  
@endpush
