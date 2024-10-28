@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Product Category</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>View Product Category</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">Main Category: <b>{!! @$category->maincategory->name !!}</b></div>
                </div>
                <div class="row">
                    <div class="col-6">Name: <b>{!! @$category->name !!}</b></div>
                    <div class="col-6">Seo Title: <b>{!! @$category->seo_title !!}</b></div>
                </div>
                <div class="row">
                    <div class="col-6">Description: <b>{!! @$category->description !!}</b></div>
                    <div class="col-6">Seo Description: <b>{!! @$category->seo_description !!}</b></div>
                </div>
                <div class="row">
                    <div class="col-6">Position: <b>{{ @$category->position }}</b></div>
                    <div class="col-6">Status:
                        <b>
                            @if (@$category->status == 1)
                                Active
                            @else
                                Inactive
                            @endif
                        </b>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">Image:<img src="{{ asset(@$category->image) }}" alt="" width="100px" height="100px"></div>
                </div>
            </div>
    </section>
@endsection
