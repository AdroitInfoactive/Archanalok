@extends('frontend.layouts.master')

@section('content')
   
          <!-- Hero Banner Start -->
          <section class="page_banner" style="background-image: url(assets/images/banner.jpg);">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="pb_title">Shipping Policy</h3>
                        <div class="page_crumb">
                            <a href="{{ url('/') }}">Home</a> | <span>Shipping Policy</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>  
        <!-- Banner End -->

    <section class="about-section-2 pad_top">
        <div class="container">
            <div class="row">
             {!! @$shippingPolicy->content !!}
                <a href="{{ url('/') }}" class="fishto-btn">go home</a>
            </div>
        </div>
    </section>
@endsection
