@extends('frontend.layouts.cat-master')
@section('content')

@include('frontend.home.category.header')
@include('frontend.home.category.banner')

<!-- Popup Search End -->
<section class="popup_search_sec">
    <div class="popup_search_overlay"></div>
    <div class="pop_search_background">
        <div class="middle_search">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="popup_search_form">
                            <form method="get" action="#">
                                <input type="search" name="s" id="s"
                                    placeholder="Type Words and Hit Enter" />
                                <button type="submit"><i class="nss-search1"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@include('frontend.home.category.cat-products')

@endsection