@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Product Sub Category</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>View Product Sub Category</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">Main Category: <b>{!! @$subcategory->maincategory->name !!}</b></div>
                    <div class="col-6">Category: <b>{!! @$subcategory->category->name !!}</b></div>
                </div>
                <div class="row">
                    <div class="col-6">Name: <b>{!! @$subcategory->name !!}</b></div>
                    <div class="col-6">Seo Title: <b>{!! @$subcategory->seo_title !!}</b></div>
                </div>
                <div class="row">
                    <div class="col-6">Description: <b>{!! @$subcategory->description !!}</b></div>
                    <div class="col-6">Seo Description: <b>{!! @$subcategory->seo_description !!}</b></div>
                </div>
                <div class="row">
                    <div class="col-6">Position: <b>{{ @$subcategory->position }}</b></div>
                    <div class="col-6">Status:
                        <b>
                            @if (@$subcategory->status == 1)
                                Active
                            @else
                                Inactive
                            @endif
                        </b>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">Image:<img src="{{ asset(@$subcategory->image) }}" alt="" width="100px" height="100px"></div>
                </div>
            </div>
    </section>
@endsection
