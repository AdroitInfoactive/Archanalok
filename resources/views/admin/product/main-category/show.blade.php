@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Product Main Category</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>View ProductMain Category</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">Name: <b>{!! @$maincategory->name !!}</b></div>
                    <div class="col-6">Seo Title: <b>{!! @$maincategory->seo_title !!}</b></div>
                </div>
                <div class="row">
                    <div class="col-6">Description: <b>{!! @$maincategory->description !!}</b></div>
                    <div class="col-6">Seo Description: <b>{!! @$maincategory->seo_description !!}</b></div>
                </div>
                <div class="row">
                    <div class="col-6">Position: <b>{{ @$maincategory->position }}</b></div>
                    <div class="col-6">Status:
                        <b>
                            @if (@$maincategory->status == 1)
                                Active
                            @else
                                Inactive
                            @endif
                        </b>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">Logo:<img src="{{ asset(@$maincategory->logo) }}" alt="" width="100px" height="100px"></div>
                    <div class="col-6">Image:<img src="{{ asset(@$maincategory->image) }}" alt="" width="100px" height="100px"></div>
                </div>
            </div>
    </section>
@endsection
