@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>About Home Page</h1>
    </div>

    <div class="card card-primary mx-auto" style="max-width: 700px;">
        <div class="card-header">
            <h4>Update About Home Page</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.home-info.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control" value="{{ @$homeInfo->title }}">
                        </div>
                      
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="summernote form-control">{!! @$homeInfo->description !!}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Short Description</label>
                            <textarea name="short_description" class="summernote form-control">{!! @$homeInfo->short_description !!}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Url</label>
                            <input type="text" name="url" class="form-control" value="{{ @$homeInfo->url }}">
                        </div>
                    

                   
                {{-- </div> --}}

                <button type="submit" class="btn btn-primary mt-4 d-flex justify-content-center mx-auto">Update</button>
            </form>
        </div>
    </div>
</section>
@endsection

