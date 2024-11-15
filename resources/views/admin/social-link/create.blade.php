@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Social Link</h1>
    </div>

    <div class="card card-primary mx-auto" style="max-width: 600px;">
        <div class="card-header">
            <h4>Create Link</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.social-link.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group text-center">
                    <label for="">Icon</label>
                    <br>
                    <button class="btn btn-secondary" role="iconpicker" name="icon" data-icon=""></button>
                </div>
                

                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control">
                </div>

                <div class="form-group">
                    <label>Link</label>
                    <input type="text" name="link" class="form-control">
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
