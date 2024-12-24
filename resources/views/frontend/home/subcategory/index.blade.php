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
                                <li><a class="active" href="#grid"
                                        data-toggle="tab"><span></span><span></span><span></span><span></span></a></li>
                                <li><a class="list" href="#list"
                                        data-toggle="tab"><span></span><span></span><span></span></a></li>
                            </ul>
                            <p class="show-result">Showing all 15 results</p>
                        </div>
                        <div class="col-md-5">
                            <div class="sorting">
                                <select name="orderby" class="orderby">
                                    <option value="sorting"
                                        {{ request('orderby') == 'sorting' || !request('orderby') ? 'selected' : '' }}>
                                        Default sorting
                                    </option>
                                    <option value="new"
                                        {{ request('orderby') == 'new' ? 'selected' : '' }}>
                                        Newest First
                                    </option>
                                    <!-- <option value="rating" 
                                        {{ request('orderby') == 'rating' ? 'selected' : '' }}>
                                        Average Rating
                                    </option> -->
                                    <option value="price-asc"
                                        {{ request('orderby') == 'price-asc' ? 'selected' : '' }}>
                                        Price: Low to High
                                    </option>
                                    <option value="price-desc"
                                        {{ request('orderby') == 'price-desc' ? 'selected' : '' }}>
                                        Price: High to Low
                                    </option>
                                </select>
                            </div>

                        </div>
                    </div>
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
                                                <img src="{{ $product->images->isNotEmpty() ? asset($product->images->first()->image_path) : asset('default-image.jpg') }}"
                                                    alt="{{ $product->name }}">
                                                {{-- <div class="product-meta">
                                                    <a href="" class="view"><i class="nss-eye1"></i></a>
                                                    <a href="" class="whishlist"><i class="nss-heart1"></i></a>
                                                </div> --}}
                                                <div class="product-meta">
                                                    <a href="{{ url('product/' . ($product->slug ?? '#')) }}" class="view"><i class="nss-eye1"></i></a>
                                                    <a href="javascript:;" class="whishlist" onclick="addToWishlist('{{ $product->id }}')">
                                                        <i class="nss-heart1"></i>
                                                    </a>
                                                </div>
                                                
                                                <a class="add-to-cart" href=""><i
                                                        class="nss-shopping-cart1"></i>Add To Cart</a>
                                            </div>
                                            <div class="product-details">
                                                <h5><a
                                                        href="{{ url('product/' . ($product->slug ?? '#')) }}">{{ $product->name }}</a>
                                                </h5>
                                                <div class="product_price clearfix">
                                                    @if ($product->has_variants == 0)
                                                        @php
                                                        // Determine the effective price (offer price or sale price)
                                                        $effectivePrice = $product->offer_price ?: $product->sale_price;

                                                        // Check for user roles and adjust price accordingly
                                                        if (auth()->check()) {
                                                        $effectivePrice = match (auth()->user()->role) {
                                                        'user' => $product->offer_price ?: $product->sale_price,
                                                        'ws' => $product->offer_price ?: $product->wholesale_price,
                                                        'dr' => $product->offer_price ?: $product->distributor_price,
                                                        default => $product->offer_price ?: $product->sale_price,
                                                        };
                                                        }

                                                        // Calculate the percentage discount if offer_price exists
                                                        $percentageOff = $product->offer_price
                                                        ? round((($product->sale_price - $product->offer_price) /
                                                        $product->sale_price) * 100)
                                                        : null;
                                                    @endphp

                                                    <div class="product-pricing">
                                                        @if($product->offer_price)
                                                            <span class="price">
                                                                <span>₹{{ number_format($effectivePrice, 2) }}</span>
                                                                <span
                                                                    style="text-decoration: line-through; font-size: 0.9em;"
                                                                    class="text-muted">
                                                                    ₹{{ number_format($product->sale_price, 2) }}
                                                                </span>
                                                                @if($percentageOff)
                                                                    <span style="font-size: 0.8em;"
                                                                        class="discount text-success">
                                                                        ({{ $percentageOff }}% off)
                                                                    </span>
                                                                @endif
                                                            </span>
                                                        @else
                                                            <span class="price">
                                                                <span>₹{{ number_format($effectivePrice, 2) }}</span>
                                                            </span>
                                                        @endif
                                                    </div>
                                                    @else
                                                        <!-- @php
                                                            $price = $product->sale_price; // Default to sale price
                                                            if (auth()->check()) {
                                                                $price = match (auth()->user()->role) {
                                                                    'user' => $product?->variant_sale_price ?? $product->sale_price,
                                                                    'ws' => $product?->variant_wholesale_price ?? $product->wholesale_price,
                                                                    'dr' => $product?->variant_distributor_price ?? $product->distributor_price,
                                                                    default => $product?->variant_sale_price ?? $product->sale_price,
                                                                };
                                                            }
                                                        @endphp
                                                        <span class="price"><span><span>₹</span>{{ number_format($price, 2) }}</span></span> -->
                                                        @php
                                                            // Default price for products without variants
                                                            $price = $product->sale_price; 

                                                            // Check if product has variants and pick the variant with the least sale price
                                                            $leastPriceVariant = $product->variants->sortBy('sale_price')->first();

                                                            // Determine the effective price (offer price or sale price)
                                                            $effectivePrice = $leastPriceVariant
                                                                ? ($leastPriceVariant->offer_price ?: $leastPriceVariant->sale_price)
                                                                : $product->sale_price;

                                                            // Adjust the price based on the user's role
                                                            if (auth()->check()) {
                                                                $effectivePrice = match (auth()->user()->role) {
                                                                    'user' => $leastPriceVariant?->offer_price ?: $leastPriceVariant?->sale_price ?: $product->sale_price,
                                                                    'ws' => $leastPriceVariant?->offer_price ?: $leastPriceVariant?->wholesale_price ?: $product->wholesale_price,
                                                                    'dr' => $leastPriceVariant?->offer_price ?: $leastPriceVariant?->distributor_price ?: $product->distributor_price,
                                                                    default => $leastPriceVariant?->offer_price ?: $leastPriceVariant?->sale_price ?: $product->sale_price,
                                                                };
                                                            }

                                                            // Calculate discount percentage if offer price exists
                                                            $percentageOff = $leastPriceVariant && $leastPriceVariant->offer_price
                                                                ? round((($leastPriceVariant->sale_price - $leastPriceVariant->offer_price) / $leastPriceVariant->sale_price) * 100)
                                                                : null;
                                                        @endphp

                                                        <div class="product-pricing">
                                                            @if ($leastPriceVariant && $leastPriceVariant->offer_price)
                                                                <span class="price">
                                                                    <span>₹{{ number_format($effectivePrice, 2) }}</span>
                                                                    <span style="text-decoration: line-through;" class="text-muted">₹{{ number_format($leastPriceVariant->sale_price, 2) }}</span>
                                                                    @if ($percentageOff)
                                                                        <span class="discount text-success">({{ $percentageOff }}% off)</span>
                                                                    @endif
                                                                </span>
                                                            @else
                                                                <span class="price">
                                                                    <span>₹{{ number_format($effectivePrice, 2) }}</span>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    @endif
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
                                                        <img src="{{ $product->images->isNotEmpty() ? asset($product->images->first()->image_path) : asset('default-image.jpg') }}"
                                                            alt="{{ $product->name }}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-8 col-md-7">
                                                    <div class="product-details">
                                                        <h5><a
                                                                href="{{ url('product/' . ($product->slug ?? '#')) }}">{{ $product->name }}</a>
                                                        </h5>
                                                        <div class="product_price clearfix">
                                                            @if ($product->has_variants == 0)
                                                                @php
                                                                    // Handle price for products without variants
                                                                    $price = $product->sale_price; // Default to sale price
                                                                    if (auth()->check()) {
                                                                        $price = match (auth()->user()->role) {
                                                                            'user' => $product->sale_price,
                                                                            'ws' => $product->wholesale_price,
                                                                            'dr' => $product->distributor_price,
                                                                            default => $product->sale_price,
                                                                        };
                                                                    }
                                                                @endphp
                                                                <span class="price"><span><span>₹</span>{{ number_format($price, 2) }}</span></span>
                                                            @else
                                                                @php
                                                                    $price = $product->sale_price; // Default to sale price
                                                                    if (auth()->check()) {
                                                                        $price = match (auth()->user()->role) {
                                                                            'user' => $product?->variant_sale_price ?? $product->sale_price,
                                                                            'ws' => $product?->variant_wholesale_price ?? $product->wholesale_price,
                                                                            'dr' => $product?->variant_distributor_price ?? $product->distributor_price,
                                                                            default => $product?->variant_sale_price ?? $product->sale_price,
                                                                        };
                                                                    }
                                                                @endphp
                                                                <span class="price"><span><span>₹</span>{{ number_format($price, 2) }}</span></span>
                                                            @endif
                                                        </div>
                                                        <div class="listing-meta">
                                                            <a class="add-to-cart" href=""><i
                                                                    class="nss-shopping-cart1"></i>Add To Cart</a>
                                                            <a href="{{ url('product/' . ($product->slug ?? '#')) }}" class="view"><i class="nss-eye1" ></i></a>
                                                            <a href="javascript:;" class="whishlist" onclick="addToWishlist('{{ $product->id }}')"><i
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
                </div>
            </div>
        </div>
    </section>
@endsection
@push('styles')
<style>
    .filter-content {
  display: none; /* Hide by default */
}

.filter-toggle {
  display: none; /* Hide the button by default */
}

/* Show button on small devices */
@media (max-width: 768px) {
  .filter-toggle {
    display: block; /* Show the button */
    margin-bottom: 10px;
  }
  .filter-content.active {
    display: block; /* Show the content when active */
  }
}

.filter-content {
  display: none; /* Hide by default */
}

.filter-toggle {
  display: none; /* Hide the button by default */
}

/* Show button on small devices */
@media (max-width: 768px) {
  .filter-toggle {
    display: block; /* Show the button */
    margin-bottom: 10px;
  }
  .filter-content.active {
    display: block; /* Show the content when active */
  }
}

/* Display filters continuously on larger devices */
@media (min-width: 769px) {
  .filter-content {
    display: block; /* Show the filters continuously */
  }
  .filter-toggle {
    display: none; /* Hide the button on larger devices */
  }
}

.filter-content {
  display: none; /* Hide by default */
  transition: max-height 0.5s ease, opacity 0.5s ease; /* Transition for dropdown */
  max-height: 0; /* Start with a max-height of 0 */
  opacity: 0; /* Start with opacity 0 */
  overflow: hidden; /* Hide overflow */
}

.filter-content.active {
  display: block; /* Change display to block when active */
  max-height: 500px; /* Set a max-height for transition effect */
  opacity: 1; /* Fade in */
}

/* Button styles */
.filter-toggle {
  display: none; /* Hide the button by default */
  background-color: #545454; /* Orange background */
  color: white; /* White text */
  border: none; /* No border */
  padding: 10px 15px; /* Padding for the button */
  cursor: pointer; /* Pointer cursor */
  font-size: 16px; /* Font size */
}

/* Show button on small devices */
@media (max-width: 768px) {
  .filter-toggle {
    display: block; /* Show the button */
    margin-bottom: 10px;
  }
}

/* Display filters continuously on larger devices */
@media (min-width: 769px) {
  .filter-content {
    display: block; /* Show the filters continuously */
    max-height: none; /* Remove max-height on larger devices */
    opacity: 1; /* Ensure full opacity */
  }
  .filter-toggle {
    display: none; /* Hide the button on larger devices */
  }
}

@media (max-width: 480px) {
  .product-thumb img {
    height: 160px; /* Set height for mobile devices */
    object-fit: cover; /* Maintain aspect ratio */
    margin-top: 10px; /* Adjust the margin as needed */
  }
}
</style>
@endpush

@push('scripts')
<script>
    document.querySelector('.orderby').addEventListener('change', function () {
    const selectedOption = this.value;

    // Reload the page with the selected sorting
    const url = new URL(window.location.href);
    url.searchParams.set('orderby', selectedOption);
    window.location.href = url.toString();
    });
    document.querySelector('.filter-toggle').addEventListener('click', function () {
        const filterContent = document.querySelector('.filter-content');
        filterContent.classList.toggle('active');

        // Adjust display property for smooth transitions
        if (filterContent.classList.contains('active')) {
            filterContent.style.display = 'block'; // Show the content
            setTimeout(() => {
                filterContent.style.maxHeight = filterContent.scrollHeight +
                'px'; // Set max-height for transition
            }, 10); // Small delay to allow the display change to take effect
        } else {
            filterContent.style.maxHeight = '0'; // Collapse the content
            setTimeout(() => {
                filterContent.style.display = 'none'; // Hide the content after collapsing
            }, 500); // Match this to the transition duration
        }
    });
</script>
@endpush