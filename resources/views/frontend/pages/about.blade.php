@extends('frontend.layouts.master')

@section('content')
    <!-- Hero Banner Start -->
    <section class="page_banner" style="background-image: url(assets/images/banner.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="pb_title">About us</h3>
                    <div class="page_crumb">
                        <a href="{{ url('/') }}">Home</a> | <span>About us</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner End -->

    <!-- About Section Start -->
    <section class="about-section-2 pad_top">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="ab-thumb">
                        <img src="{{ asset(@$about->image) }}" alt="about">
                    </div>
                </div>
                <div class="col-lg-6">
                    <h2 style="margin-bottom: 30px;">{!! @$about->title !!}</h2>
                    <p>
                        {!! @$about->description !!}
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!-- About Section End -->

    {{-- oru infrastructure --}}
    <section class="choose-us-section" style="background-image: url(assets/images/1);">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2 class="sec_titles">Our Infrastructure</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="icon-box-1 in_top">
                        <i class="fas fa-building"></i>
                        <h4>Robust Infrastructural Base</h4>
                        <p>
                            Our well-equipped facilities enable us to meet diverse client requirements with premium quality
                            products in bulk.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="icon-box-1 in_top">
                        <i class="fas fa-th-large"></i>
                        <h4>Systematic Departmental Segregation</h4>
                        <p>
                            Our operations cover a broad area and are organized into functional departments, including
                            quality testing, R&D, and sales.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="icon-box-1 in_top">
                        <i class="fas fa-user-check"></i>
                        <h4>Expert Supervision</h4>
                        <p>
                            A dedicated team of experts oversees all departments, ensuring systematic management and
                            operational excellence.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
