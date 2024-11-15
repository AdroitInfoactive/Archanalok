@extends('frontend.layouts.master')
@section('content')


<!-- Hero Banner Start -->
@include('frontend.home.components.banner')
<!-- Banner End -->
<!-- about Start -->
@include('frontend.home.components.about')
<!-- about End -->

<!-- counter Start -->
@include('frontend.home.components.counter')
<!-- counter End -->

<section class="popular-section section-padding">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 text-center">
                <h2 class="sec_titles" style="font-family: 'Poppins', sans-serif;">Categories</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="popular-slider owl-carousel">
                    <div class="product-item-2 text-center">
                        <div class="product-thumb">
                            <a href="cat-product-page.html"> <img src="{{ asset('frontend/images/product/1.jpg') }}"
                                    alt="product"></a>
                        </div>
                        <div class="product-details">
                            <h5><a href="cat-product-page.html">Flooring</a></h5>
                        </div>
                    </div>
                    <div class="product-item-2 text-center">
                        <div class="product-thumb">
                            <a href="cat-product-page.html"> <img src="{{ asset('frontend/images/product/2.jpg') }}"
                                    alt="product"></a>
                        </div>
                        <div class="product-details">
                            <h5><a href="cat-product-page.html">Laminates </a></h5>
                        </div>
                    </div>
                    <div class="product-item-2 text-center">
                        <div class="product-thumb">
                            <a href="cat-product-page.html"> <img src="{{ asset('frontend/images/product/3.jpg') }}"
                                    alt="product"></a>
                        </div>
                        <div class="product-details">
                            <h5><a href="cat-product-page.html">PVC Membrane</a></h5>
                        </div>
                    </div>
                    <div class="product-item-2 text-center">
                        <div class="product-thumb">
                            <a href="cat-product-page.html"> <img src="{{ asset('frontend/images/product/4.jpg') }}"
                                    alt="product"></a>
                        </div>
                        <div class="product-details">
                            <h5><a href="cat-product-page.html">Artificial leather Cloth </a></h5>
                        </div>
                    </div>
                    <div class="product-item-2 text-center">
                        <div class="product-thumb">
                            <a href="cat-product-page.html"> <img src="{{ asset('frontend/images/product/5.jpg') }}"
                                    alt="product"></a>
                        </div>
                        <div class="product-details">
                            <h5><a href="cat-product-page.html">Pre Laminated MDF Board</a></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- testimonial Start -->
@include('frontend.home.components.testimonial')
<!-- testimonial End -->


<!-- social-media Start -->
@include('frontend.home.components.social-media')
<!-- social-media End -->



@endsection