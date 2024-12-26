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
            <div class="col-lg-10 col-sm-9">
                <div class="tab-content">
                    <div class="tab-pane fade show in active" id="grid" role="tabpanel">
                        <div class="row" id="grid-view">
                            <!-- repeat this -->
                            @foreach ($subcategories as $subcategory)
                                <div class="col-lg-3 mb-5">
                                    <div class="product-item-1 text-center">
                                        <div class="product-thumb">
                                            <img src="{{ asset($subcategory->image) }}" alt="{{ $subcategory->name }}">
                                            <div class="product-meta">
                                                <a href="{{ url(($mainCategory->slug ?? '#') .  '/' . ($category->slug ?? '#'). '/' . ($subcategory->slug ?? '#')) }}" class="view"><i class="nss-eye1"></i></a>
                                            </div>
                                        </div>
                                        <div class="product-details">
                                            <h5><a href="product-details.html">{{ $subcategory->name }}</a></h5>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')

@endpush
