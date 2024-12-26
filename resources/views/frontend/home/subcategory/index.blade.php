@extends('frontend.layouts.cat-master')
@section('content')
<link rel="stylesheet" href="{{ asset('frontend/css/products-page.css') }}">
@include('frontend.home.category.header')
<section class="page_banner" style="background-image: url(assets/images/banner.jpg);">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                @php
                    use Illuminate\Support\Str;

                    $segments = request()->segments();
                    $breadcrumbs = [];
                    $url = '';
                    $lastSegmentName = '';

                    // Add 'Home' as the first breadcrumb
                    $breadcrumbs[] = '<a href="' . url('/') . '">Home</a>';

                    foreach ($segments as $key => $segment) {
                        $url .= '/' . $segment;

                        // Determine the name based on the segment position
                        $name = match ($key) {
                            0 => \App\Models\MainCategory::where('slug', $segment)->value('name') ?? ucfirst(Str::replace('-', ' ', $segment)),
                            1 => \App\Models\Category::where('slug', $segment)->value('name') ?? ucfirst(Str::replace('-', ' ', $segment)),
                            2 => \App\Models\SubCategory::where('slug', $segment)->value('name') ?? ucfirst(Str::replace('-', ' ', $segment)),
                            default => ucfirst(Str::replace('-', ' ', $segment)),
                        };

                        if ($key < count($segments) - 1) {
                            $breadcrumbs[] = '<a href="' . url($url) . '">' . $name . '</a>';
                        } else {
                            $lastSegmentName = $name; // Store the name for the last segment
                            $breadcrumbs[] = '<span>' . $name . '</span>';
                        }
                    }
                @endphp

                <h3 class="pb_title">{{ $lastSegmentName }}</h3>
                <div class="page_crumb">
                    {!! implode(' | ', $breadcrumbs) !!}
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
                            <h3 class="widget-title">Price</h3>
                            <div class="price_slider_wrapper">
                                <div id="slider-range"></div>
                                <div>
                                    Price: ₹<span id="min-price">{{ $minPrice }}</span> - ₹<span id="max-price">{{ $maxPrice }}</span>
                                </div>
                            </div>
                        </aside>
                        <aside class="widget">
                            <h3 class="widget-title" data-target="#brand-filters">
                                Brand
                                <span class="toggle-arrow">▼</span>
                            </h3>
                            <div id="brand-filters" class="filters">
                                @foreach ($brands as $brand)
                                    <li>
                                        <label for="brand{{ $brand->id }}CheckBox">{{ $brand->name }}</label>
                                        <input type="checkbox" name="brands[]" value="{{ $brand->id }}" id="brand{{ $brand->id }}CheckBox">
                                    </li>
                                @endforeach
                            </div>
                        </aside>
                        @foreach ($variants as $variant)
                            <aside class="widget">
                                <h3 class="widget-title" data-target="#{{ Str::slug($variant->name) }}-filters">
                                    {{ $variant->name }}
                                    <span class="toggle-arrow">▼</span>
                                </h3>
                                <div id="{{ Str::slug($variant->name) }}-filters" class="filters">
                                    @foreach ($variant->details as $detail)
                                        <li>
                                            <label for="detail{{ $detail->id }}CheckBox">{{ $detail->name }}</label>
                                            <input type="checkbox" name="details[]" value="{{ $detail->id }}" id="detail{{ $detail->id }}CheckBox">
                                        </li>
                                    @endforeach
                                </div>
                            </aside>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-lg-10 col-sm-9">
                <div class="row">
                    <div class="col-md-7">
                        <ul class="toolbar-btn nav nav-tabs">
                            <li><a class="active" href="#grid" data-toggle="tab"><span></span><span></span><span></span><span></span></a></li>
                            <li><a class="list" href="#list" data-toggle="tab"><span></span><span></span><span></span></a></li>
                        </ul>
                        <p class="show-result">Showing all {{ $products->count() }} results</p>
                    </div>
                    <div class="col-md-5">
                        <div class="sorting">
                            <select name="orderby" class="orderby">
                                <option value="sorting" {{ request('orderby') == 'sorting' || !request('orderby') ? 'selected' : '' }}>Default sorting</option>
                                <option value="new" {{ request('orderby') == 'new' ? 'selected' : '' }}>Newest First</option>
                                <option value="price-asc" {{ request('orderby') == 'price-asc' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price-desc" {{ request('orderby') == 'price-desc' ? 'selected' : '' }}>Price: High to Low</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show in active" id="grid" role="tabpanel">
                        <div class="row" id="grid-view">
                                @include('frontend.home.subcategory.filter-products-grid', compact('products'))
                        </div>
                    </div>
                    <div class="tab-pane fade in" id="list" role="tabpanel">
                        <div class="row" id="list-view">
                                @include('frontend.home.subcategory.filter-products-list', compact('products'))
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        // Filter toggle functionality
        $('.widget-title').on('click', function () {
            const target = $(this).data('target');
            $(target).toggleClass('show');
            $(this).find('.toggle-arrow').toggleClass('rotated');
        });

        $('.orderby').on('change', function () {
            const selectedOption = $(this).val();
            const url = new URL(window.location.href);
            url.searchParams.set('orderby', selectedOption);
            window.location.href = url.toString();
        });

        $('.filter-toggle').on('click', function () {
            const filterContent = $('.filter-content');
            filterContent.toggleClass('active');
            filterContent.css('display', filterContent.hasClass('active') ? 'block' : 'none');
        });

        // Initialize price slider
        const minPrice = {{ $minPrice }};
        const maxPrice = {{ $maxPrice }};
        $("#slider-range").slider({
            range: true,
            min: minPrice,
            max: maxPrice,
            values: [minPrice, maxPrice],
            slide: function (event, ui) {
                $("#min-price").text(ui.values[0]);
                $("#max-price").text(ui.values[1]);
            },
            change: function (event, ui) {
                fetchFilteredProducts(ui.values[0], ui.values[1]);
            }
        });

        // Attach event listeners to brand and detail checkboxes
        $('input[name="brands[]"], input[name="details[]"]').on('change', function () {
            const minFilterPrice = $("#slider-range").slider("values", 0);
            const maxFilterPrice = $("#slider-range").slider("values", 1);
            fetchFilteredProducts(minFilterPrice, maxFilterPrice);
        });

        function fetchFilteredProducts(minPrice, maxPrice) {
            const brands = $('input[name="brands[]"]:checked').map(function () {
                return $(this).val();
            }).get();
            const details = $('input[name="details[]"]:checked').map(function () {
                return $(this).val();
            }).get();

            // Manually construct query string for cleaner URLs
            const queryParams = new URLSearchParams();
            queryParams.set('min_price', minPrice);
            queryParams.set('max_price', maxPrice);

            // Join the brands and details into comma-separated strings
            if (brands.length > 0) {
                queryParams.set('brands', brands.join(','));
            }
            if (details.length > 0) {
                queryParams.set('details', details.join(','));
            }

            // Make AJAX request
            $.ajax({
                url: `/filter-products?${queryParams.toString()}`, // Constructed URL
                method: 'GET',
                success: function (response) {
                    $('#grid-view').html(response.gridHtml);
                    $('#list-view').html(response.listHtml);
                },
                error: function () {
                    alert('Error fetching filtered products.');
                }
            });
        }
    });
</script>
@endpush
