@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Social Link</h1>
    </div>

    <div class="card card-primary mx-auto" style="max-width: 600px;">
        <div class="card-header">
            <h4>Update Link</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.social-link.update', $link->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group text-center">
                    <label for="">Icon</label>
                    <br>
                    <button class="btn btn-secondary" role="iconpicker" name="icon" data-icon="{{ $link->icon }}"></button>
                </div>
                

                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $link->name }}">
                </div>

                <div class="form-group">
                    <label>Link</label>
                    <input type="text" name="link" class="form-control" value="{{ $link->link }}">
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option @selected($link->status === 1) value="1">Yes</option>
                        <option @selected($link->status === 0) value="0">No</option>
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
