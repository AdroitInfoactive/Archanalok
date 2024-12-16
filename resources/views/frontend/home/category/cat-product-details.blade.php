@extends('frontend.layouts.cat-master')
@section('content')
    @include('frontend.home.category.header')


    <!-- Popup Search Start -->
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
                                        placeholder="Type Words and Hit Enter">
                                    <button type="submit"><i class="nss-search1"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Popup Search End -->

    <!-- Hero Banner Start -->
    @php
        // dd(  $product);
        // dd($categories);
    @endphp
    <section class="page_banner" style="background-image: url({{ asset('frontend/images/banner.jpg') }});">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="pb_title">{{ $product->name }}</h3>
                    <div class="page_crumb">
                        <a href="{{ route('home') }}">Home</a> |
                        <a href="{{ route('maincategory.show', $mainCategory->slug) }}">{{ $mainCategory->name }}</a>
                        |
                        <a href=""></a>{{   $product->category->name }}</a>
                        |
                        <span>{{ $product->name }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner End -->

    <!-- Single Shop Start -->
    <section class="singleproduct-setion">
        <div class="container-fluid">
            <div class="row">
                <!-- Product Image Slider -->
                <div class="col-lg-5 col-md-5">
                    <div class="vehicle-detail-banner clearfix">
                        <div class="banner-slider">
                            <div class="slider slider-nav thumb-image">
                                @foreach ($product->images as $image)
                                    <div class="thumbnail-image">
                                        <div class="thumbImg">
                                            <img src="{{ asset(@$image->image_path) }}" alt="{{ @$product->name }}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="slider slider-for">
                                @foreach ($product->images as $image)
                                    <div class="slider-banner-image">
                                        <img src="{{ asset(@$image->image_path) }}" alt="{{ @$product->name }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Product Image Slider End -->

                <!-- Product Details -->
                <div class="col-lg-7 col-md-7">
                    <div class="product-decp">
                        <h4>{{ $product->name }}</h4>
                        <div class="product_price clearfix">
                            @php
                                $price = $product->has_variants == 0 ? $product->sale_price : $product->price;
                            @endphp
                            <span class="price"><span>₹{{ number_format($price, 2) }}</span></span>
                        </div>

                        <div class="metatext"><span>Code:</span> <a href="#">{{ $product->sku ?? 'N/A' }}</a></div>
                        <div class="metatext"><span>Material:</span> <a href="#">{{ $product->materialDetail->name ?? 'N/A' }}</a></div>
                        <div class="metatext"><span>Units:</span> <a href="#">{{$product->unitDetail->name ?? 'N/A' }}</a></div>
                        <div class="metatext"><span>weight type:</span> <a href="#">{{  $product->weightTypeDetail->name ?? 'N/A' }}</a>
                        </div>
                        <div class="metatext"><span>Brand:</span> <a href="#">{{ $product->brandName->name ?? 'N/A' }}</a></div>
                     
                        <div class="excerpt">

                        </div>

                        <!-- Sizes Dropdown -->
                        {{-- @if ($product->sizes->isNotEmpty())
                        <div class="excerpt">
                            <h4 class="">Sizes</h4>
                            <div class="dropdown">
                                <button class="btn btn-secondary" type="button" id="sizeDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Select Size
                                </button>
                                <div class="dropdown-menu" aria-labelledby="sizeDropdown">
                                    @foreach ($product->sizes as $size)
                                        <a class="dropdown-item" href="#">{{ $size }}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Colors Section -->
                    @if ($product->colors->isNotEmpty())
                        <div class="excerpt">
                            <h4 class="">Available Colors</h4>
                            <div class="color-options d-flex">
                                @foreach ($product->colors as $color)
                                    <div class="color-option" style="background-color: {{ $color }}; width: 50px; height: 50px; margin-right: 10px; cursor: pointer;" title="{{ $color }}"></div>
                                @endforeach
                            </div>
                        </div>
                    @endif --}}

                        <!-- Quantity Section -->
                        <div class="quantityd clearfix">
                            <button class="qtyBtn btnMinus"><span>-</span></button>
                            <input name="qty" value="1" title="Qty" class="input-text qty text carqty"
                                type="text">
                            <button class="qtyBtn btnPlus">+</button>
                        </div>
                        <div class="listing-meta">
                            <a class="add-to-cart" href="cart.html"><i class="nss-shopping-cart1"></i>Add To Cart</a>
                            <a href="wishlist.html" class="whishlist"><i class="nss-heart1"></i></a>
                        </div>
                    </div>
                </div>
                <!-- Product Details End -->
            </div>

            <!-- Tabs Section -->
            <div class="row">
                <div class="col-lg-12">
                    <ul class="productTabs nav nav-tabs">
                        @if ($product->description != null)
                            <li><a class="active" href="#description" data-toggle="tab">Description</a></li>
                        @endif
                        @if ($product->specification != null)
                            <li><a href="#additional" data-toggle="tab">Additional Information</a></li>
                        @endif
                    </ul>

                    <div class="tab-content">
                        <!-- Description Tab -->
                        <div class="tab-pane fade in active show" id="description" role="tabpanel">
                            <div class="tab-description">
                               
                                <p>{!! $product->description !!}</p>
                            </div>
                        </div>
                        <!-- Additional Info Tab -->
                        <div class="tab-pane fade in" id="additional" role="tabpanel">
                            <div class="tab-info">
                                <p>{!! $product->specification !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Tabs Section End -->
        </div>
    </section>
    <!-- Single Shop End -->

    <!-- Related Products Section -->
    <section class="related-section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2 class="sec_titles">Related Products</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="popular-slider owl-carousel">
                        @foreach (@$relatedProducts as $related)
                            <div class="product-item-2 text-center">
                                <div class="product-thumb">
                                    <a href="{{ route('product.show', $related->slug) }}">
                                        <img src="{{ asset(optional($related->images->first())->image_path) }}"
                                            alt="{{ $related->name }}">
                                    </a>
                                </div>
                                <div class="product-details">
                                    <h5><a href="{{ route('product.show', $related->slug) }}">{{ $related->name }}</a>
                                    </h5>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Related Products End -->
@endsection

@push('scripts')
    <script>
        $('.slider-for').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            asNavFor: '.slider-nav'
        });
        $('.slider-nav').slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            vertical: true,
            asNavFor: '.slider-for',
            dots: false,
            focusOnSelect: true,
            verticalSwiping: true,
            responsive: [{
                    breakpoint: 992,
                    settings: {
                        vertical: false,
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        vertical: false,
                    }
                },
                {
                    breakpoint: 580,
                    settings: {
                        vertical: false,
                        slidesToShow: 3,
                    }
                },
                {
                    breakpoint: 380,
                    settings: {
                        vertical: false,
                        slidesToShow: 2,
                    }
                }
            ]
        });
    </script>
@endpush
{{-- @push('styles') --}}
<style>
    .vehicle-detail-banner .car-slider-desc {
        max-width: 180px;
        margin: 0 auto;
    }

    .banner-slider .slider.slider-for {
        max-width: 84%;
        padding-right: 35px;
    }

    .banner-slider .slider.slider-nav {
        max-width: 16%;
    }

    .banner-slider .slider.slider-for,
    .banner-slider .slider.slider-nav {
        width: 100%;
        float: left;
    }

    .banner-slider .slider.slider-nav {
        height: 610px;
        overflow: hidden;

    }

    .slider-banner-image {
        height: 610px;
    }

    .banner-slider .slider.slider-nav {
        padding: 20px 0 0;
    }

    .slider-nav .slick-slide.thumbnail-image .thumbImg {
        max-width: 178px;
        height: 110px;
        margin: 0 auto;
        border: 1px solid #EBEBEB;
    }

    .slider-banner-image img,
    .slider-nav .slick-slide.thumbnail-image .thumbImg img {
        height: 100%;
        width: 100%;
        object-fit: cover;
        border: #ddd 1px solid;
    }

    .slick-vertical .slick-slide:active,
    .slick-vertical .slick-slide:focus,
    .slick-arrow:hover,
    .slick-arrow:focus {
        border: 0;
        outline: 0;
    }

    .slider-nav .slick-slide.slick-current.thumbnail-image .thumbImg {
        border: 2px solid #196DB6;
    }

    .thumbnail-image img {
        width: 100px;
        height: 100px;
        border: #ddd 1px solid;
    }

    .slider-nav .slick-slide.slick-current span {
        color: #196DB6;
    }

    .slider-nav .slick-slide {
        text-align: center;
    }

    .slider-nav .slick-slide span {
        font-size: 14px;
        display: block;
        padding: 5px 0 15px;
    }

    .slick-arrow {
        width: 100%;
        background-color: transparent;
        border: 0;
        background-position: center;
        background-repeat: no-repeat;
        font-size: 0;
        height: 18px;
        position: absolute;
        left: 0;
        right: 0;
        z-index: 99;
    }

    .slick-prev {
        top: 0;
    }

    .slick-next {
        bottom: 0;
        background-color: #fff;
    }

    .slick-prev.slick-arrow {
        background-image: url(../images/black-up-arrow.png);
    }

    .slick-next.slick-arrow {
        background-image: url(../images/black-down-arrow.png);
    }

    /*End USE CSS for Slider*/

    @media screen and (max-width : 991px) {

        .banner-slider .slider.slider-for,
        .banner-slider .slider.slider-nav {
            max-width: 100%;
            float: none;
        }

        .banner-slider .slider.slider-for {
            padding-right: 0;
        }

        .banner-slider .slider.slider-nav {
            height: auto;
        }

        .slider-banner-image {
            height: 500px;
        }

        .slider.slider-nav.thumb-image {
            padding: 10px 30px 0;
        }

        .slider-nav .slick-slide span {
            padding: 5px 0;
        }

        .slick-arrow {
            padding: 0;
            width: 30px;
            height: 30px;
            top: 50%;
            bottom: 0;
            -webkit-transform: translateY(-50%) rotate(-90deg);
            -moz-transform: translateY(-50%) rotate(-90deg);
            -ms-transform: translateY(-50%) rotate(-90deg);
            transform: translateY(-50%) rotate(-90deg);
        }

        .slick-prev {
            left: 0;
            right: unset;
        }

        .slick-next {
            left: unset;
            right: 0;
            background-color: transparent;
        }

        .vehicle-detail-banner .car-slider-desc {
            max-width: 340px;
        }

        .bid-tag {
            padding: 10px 0 15px;
        }

        .slider.slider-nav.thumb-image {
            white-space: nowrap;
        }

        .thumbnail-image.slick-slide {
            padding: 0px 5px;
            min-width: 75px;
            display: inline-block;
            float: none;
        }
    }

    @media screen and (max-width : 767px) {
        .slider-banner-image {
            height: 400px;
        }

        .slider.slider-nav.thumb-image {
            padding: 0px 20px 0;
            margin: 10px 0px 0;
        }

        .slider-nav .slick-slide.thumbnail-image .thumbImg {
            max-width: 140px;
            height: 80px;
        }

        .slick-prev.slick-arrow {
            background-position: center 10px;
        }

        .slick-next.slick-arrow {
            background-position: center 10px, center;
        }

        .slider-nav .slick-slide span {
            font-size: 12px;
            white-space: normal;
        }
    }

    @media screen and (max-width: 580px) {
        .slider-banner-image {
            height: 340px;
        }
    }

    @media screen and (max-width : 480px) {
        .slider-banner-image {
            height: 280px;
        }
    }


    .dropdown-menu {
        display: none;
        /* Hide the menu by default */
        opacity: 0;
        /* Start with no opacity */
        transition: opacity 0.3s ease, visibility 0.3s ease;
        /* Transition for smoothness */
    }

    .dropdown:hover .dropdown-menu {
        display: block;
        /* Show the menu on hover */
        opacity: 1;
        /* Fade in */
        visibility: visible;
        /* Make it visible */
    }
</style>
{{-- @endpush --}}
