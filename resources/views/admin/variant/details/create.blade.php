@extends('admin.layouts.master')
@section('content')
<section class="section">
    <div class="section-header">
        <span onclick="goBack()" style="cursor: pointer; font-size: 1.5em;">
            <i class="fas fa-arrow-left"></i>
        </span>&nbsp;
        <h1>Add Variant Details</h1>
    </div>
</section>

<div class="d-flex justify-content-center"> <!-- Center alignment -->
    <form action="{{ route('admin.variant-details.store') }}" method="post" enctype="multipart/form-data" class="form w-50"> <!-- Adjust width as needed -->
        @csrf
        <div class="card card-primary">
            <div class="card-header text-center">
                <h4>Variant Details</h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="variant_master_id">Variant Master</label>
                    <select name="variant_master_id" class="form-control select2">
                        <option value="">Select</option>
                        @foreach($variantMasters as $variantMaster)
                            <option value="{{ $variantMaster->id }}">{{ $variantMaster->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control">
                </div>

               

                <div class="form-group row">
                    <div class="col-md-6">
                        <label>Priority</label>
                        <input type="text" name="position" value="{{ old('position') }}" class="form-control">
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

        <div class="text-center mt-4">
            <button class="btn btn-primary btn-lg" type="submit">Create</button>
            <button class="btn btn-danger btn-lg" type="button" onclick="goBack()">Go Back</button>
        </div>
    </form>
</div>
@endsection
