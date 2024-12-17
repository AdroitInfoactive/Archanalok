@extends('frontend.layouts.cat-master')
@section('content')
    @include('frontend.home.category.header')
    <section class="page_banner" style="background-image: url(assets/images/banner.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="pb_title">26MM</h3>
                    <div class="page_crumb">
                        <a href="#">Home</a> | <a href="#">Products</a> | <a href="#">Products</a> | <a
                            href="#">PVC Membrane</a> | <span>26MM</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

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

    <section class="shoppage-setion" style="margin-top:-40px;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-2 col-sm-3">
                    <div class="shop-sidebar ss-right">
                        <button class="filter-toggle">Click for Filters</button>
                        <div class="filter-content">
                            <aside class="widget">
                                <h3 class="widget-title">Filter</h3>
                                <div class="price_slider_wrapper">
                                    <form action="#" method="get" class="clearfix">
                                        <div id="slider-range"></div>
                                    </form>
                                </div>
                            </aside>
                            <aside class="widget">
                                <h3 class="widget-title">Shop by Category</h3>
                                <div class="filters">
                                    <li><label for="natureCheckBox">Front Film</label> <input type="checkbox" name="nature"
                                            id="natureCheckBox"></li>
                                    <li><label for='sunsetCheckBox'>Back Film</label> <input type="checkbox" name="sunset"
                                            id="sunsetCheckBox"></li>
                                    <li><label for='CatsCheckBox'>Membrane Glue</label> <input type="checkbox"
                                            name="cats" id="CatsCheckBox"></li>
                                    <li><label for='techCheckBox'>MDF sheet 5mm Carving</label> <input type="checkbox"
                                            name="technology" id="techCheckBox"></li>
                                    <li><label for='indoorCheckBox'>MDF sheet 11mm Carving</label> <input type="checkbox"
                                            name="indoor" id="indoorCheckBox"></li>
                                </div>
                            </aside>
                            <aside class="widget">
                                <h3 class="widget-title">Shop by Brand</h3>
                                <div class="filters">
                                    <li><label for="brand1CheckBox">Brand 1</label> <input type="checkbox" name="brand1"
                                            id="brand1CheckBox"></li>
                                    <li><label for='brand2CheckBox'>Brand 2</label> <input type="checkbox" name="brand2"
                                            id="brand2CheckBox"></li>
                                    <li><label for='brand3CheckBox'>Brand 3</label> <input type="checkbox" name="brand3"
                                            id="brand3CheckBox"></li>
                                    <li><label for='brand4CheckBox'>Brand 4</label> <input type="checkbox" name="brand4"
                                            id="brand4CheckBox"></li>
                                </div>
                            </aside>
                            <aside class="widget">
                                <h3 class="widget-title">Shop by Material</h3>
                                <div class="filters">
                                    <li><label for="material1CheckBox">Material 1</label> <input type="checkbox"
                                            name="material1" id="material1CheckBox"></li>
                                    <li><label for='material2CheckBox'>Material 2</label> <input type="checkbox"
                                            name="material2" id="material2CheckBox"></li>
                                    <li><label for='material3CheckBox'>Material 3</label> <input type="checkbox"
                                            name="material3" id="material3CheckBox"></li>
                                    <li><label for='material4CheckBox'>Material 4</label> <input type="checkbox"
                                            name="material4" id="material4CheckBox"></li>
                                </div>
                            </aside>
                            <aside class="widget">
                                <h3 class="widget-title">Shop by Type</h3>
                                <div class="filters">
                                    <li><label for="type1CheckBox">Type 1</label> <input type="checkbox" name="type1"
                                            id="type1CheckBox"></li>
                                    <li><label for='type2CheckBox'>Type 2</label> <input type="checkbox" name="type2"
                                            id="type2CheckBox"></li>
                                    <li><label for='type3CheckBox'>Type 3</label> <input type="checkbox" name="type3"
                                            id="type3CheckBox"></li>
                                    <li><label for='type4CheckBox'>Type 4</label> <input type="checkbox" name="type4"
                                            id="type4CheckBox"></li>
                                </div>
                            </aside>
                        </div>
                    </div>
                </div>



                <div class="col-lg-10 col-sm-9">
                    <div class="row">
                        <div class="col-md-7">
                            <ul class="toolbar-btn nav nav-tabs">
                                <li><a class="active" href="#gird"
                                        data-toggle="tab"><span></span><span></span><span></span><span></span></a></li>
                                <li><a class="list" href="#list"
                                        data-toggle="tab"><span></span><span></span><span></span></a></li>
                            </ul>
                            <p class="show-result">Showing all 15 results</p>
                        </div>
                        <div class="col-md-5">
                            <div class="sorting">
                                <select name="orderby" class="orderby">
                                    <option value="sorting" selected="selected">Default sorting</option>
                                    <option value="new">Newest Products</option>
                                    <option value="rating">Average Rating</option>
                                    <option value="price">Price: Low to High</option>
                                    <option value="price-desc">Price: High to Low</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- Tab Content -->
                    <!-- Tab Content -->
                    <div class="tab-content">
                        <!-- Grid View -->
                        <div class="tab-pane fade show in active" id="grid" role="tabpanel">
                            <div class="row">
                                @php
                                    // dd($products);
                                @endphp
                                @foreach ($products as $product)
                                    <div class="col-lg-3 mb-5">
                                        <div class="product-item-1 text-center">
                                            <div class="product-thumb">
                                                <img src="{{ asset($product->product_image) }}"
                                                    alt="{{ $product->name }}">
                                                <div class="product-meta">
                                                    <a href="" class="view"><i class="nss-eye1"></i></a>
                                                    <a href="" class="whishlist"><i class="nss-heart1"></i></a>
                                                </div>
                                                <a class="add-to-cart" href=""><i
                                                        class="nss-shopping-cart1"></i>Add To Cart</a>
                                            </div>
                                            <div class="product-details">
                                                <h5><a
                                                        href="{{ url('product/' . ($product->slug ?? '#')) }}">{{ $product->name }}</a>
                                                </h5>
                                                <div class="product_price clearfix">
                                                    <span
                                                        class="price"><span><span>₹</span>{{ number_format($product->sale_price ?? 100, 2) }}</span></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- Grid View -->

                        <!-- List View -->
                        <div class="tab-pane fade in" id="list" role="tabpanel">
                            <div class="row">
                                @foreach ($products as $product)
                                    <div class="col-md-12">
                                        <div class="product-list-view">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-5">
                                                    <div class="product-thumb">
                                                        <img src="{{ asset($product->product_image) }}"
                                                            alt="{{ $product->name }}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-8 col-md-7">
                                                    <div class="product-details">
                                                        <h5><a
                                                                href="{{ url('product/' . ($product->slug ?? '#')) }}">{{ $product->name }}</a>
                                                        </h5>
                                                        <div class="product_price clearfix">
                                                            <span
                                                                class="price"><span><span>₹</span>{{ number_format($product->sale_price ?? 100, 2) }}</span></span>
                                                        </div>
                                                        <div class="listing-meta">
                                                            <a class="add-to-cart" href=""><i
                                                                    class="nss-shopping-cart1"></i>Add To Cart</a>
                                                            <a href="" class="view"><i class="nss-eye1"></i></a>
                                                            <a href="" class="whishlist"><i
                                                                    class="nss-heart1"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- List View -->
                    </div>
                    <!-- Tab Content -->

                    <!-- Tab Content -->
                </div>
            </div>
        </div>
    </section>
@endsection
