@extends('frontend.layouts.cat-master')
@section('content')
<link rel="stylesheet" href="{{ asset('frontend/css/product-detail-page.css') }}">
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

    <section class="page_banner" style="background-image: url({{ asset('frontend/images/banner.jpg') }});">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="pb_title">{{ $product->name }}</h3>
                    <div class="page_crumb">
                        <a href="{{ route('home') }}">Home</a> |
                        <a
                            href="{{ url($mainCategory->slug) }}">{{ $mainCategory->name }}</a>
                        |
                        <a
                            href="{{ url($mainCategory->slug . '/' . $product->category->slug) }}">{{ $product->category->name }}</a>
                        |
                        @if($product->sub_category_id != 0 && $product->sub_category_id != null)
                        @php
                            $subCat = \App\Models\SubCategory::where('id', $product->sub_category_id)->first();
                        @endphp
                            <a
                                href="{{ url($mainCategory->slug . '/' . $product->category->slug . '/' . $subCat->slug) }}">{{ $subCat->name }}</a>
                            |
                        @endif
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
                                @foreach ($images as $image)
                                    <div class="thumbnail-image">
                                        <div class="thumbImg">
                                            <img src="{{ asset($image->image_path) }}" 
                                                data-image-path="{{ $image->image_path }}" 
                                                alt="{{ $product->name }}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="slider slider-for">
                                @foreach ($images as $image)
                                    <div class="slider-banner-image">
                                        <img src="{{ asset($image->image_path) }}" 
                                            data-image-path="{{ $image->image_path }}" 
                                            alt="{{ $product->name }}">
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
                        @php
                            // Determine user type
                            $userType = auth()->check() ? auth()->user()->role : 'user';
                        @endphp

                        <div class="product_price clearfix">
                            @if ($product->has_variants == 0)
                                @php
                                    // Handle price for products without variants
                                    $price = match ($userType) {
                                        'ws' => $product->wholesale_price,
                                        'dr' => $product->distributor_price,
                                        'user' => $product->offer_price ?: $product->sale_price,
                                        default => $product->sale_price,
                                    };
                                    $isDiscounted = $userType === 'user' && $product->offer_price && $product->offer_price < $product->sale_price;
                                    $percentageOff = $isDiscounted ? round((($product->sale_price - $product->offer_price) / $product->sale_price) * 100) : null;
                                @endphp
                                <span class="price">
                                    <span><span>₹</span>{{ number_format($price, 2) }}</span>
                                    @if ($isDiscounted)
                                        <span style="text-decoration: line-through; font-size: 0.7em;"
                                            class="original-price text-muted">
                                            ₹{{ number_format($product->sale_price, 2) }}
                                        </span>
                                        <span class="discount text-success" style="font-size: 0.7em;">({{ $percentageOff }}% off)</span>
                                    @endif
                                </span>
                            @else
                                @php
                                    $prices = json_encode(
                                        $product->variants->mapWithKeys(function ($variant) {
                                            return [
                                                $variant->variant_detail_id => [
                                                    'ws' => $variant->wholesale_price,
                                                    'dr' => $variant->distributor_price,
                                                    'user' => $variant->offer_price ?? $variant->sale_price,
                                                    'default' => $variant->sale_price,
                                                ],
                                            ];
                                        })->toArray()
                                    );
                                    // Default to the first variant's price
                                    $defaultVariant = $product->variants->first();
                                    // Determine price for products with variants
                                    $price = match ($userType) {
                                        'ws' => $defaultVariant->wholesale_price ?? $product->wholesale_price,
                                        'dr' => $defaultVariant->distributor_price ?? $product->distributor_price,
                                        'user' => $defaultVariant->offer_price ?? $defaultVariant->sale_price,
                                        default => $defaultVariant->sale_price,
                                    };

                                    $isDiscounted = $userType === 'user' && $defaultVariant->offer_price && $defaultVariant->offer_price < $defaultVariant->sale_price;
                                    $percentageOff = $isDiscounted ? round((($defaultVariant->sale_price - $defaultVariant->offer_price) / $defaultVariant->sale_price) * 100) : null;
                                @endphp
                                <span class="price">
                                    <span><span>₹</span>{{ number_format($price, 2) }}</span>
                                    @if ($isDiscounted)
                                        <span style="text-decoration: line-through; font-size: 0.7em;"
                                            class="original-price text-muted">
                                            ₹{{ number_format($defaultVariant->sale_price, 2) }}
                                        </span>
                                        <span class="discount text-success" style="font-size: 0.7em;">({{ $percentageOff }}% off)</span>
                                    @endif
                                </span>
                            @endif
                        </div>
                        <div class="metatext"><span>Code:</span> #196DB6{{ $product->sku ?? 'N/A' }}</div>
                        <div class="metatext"><span>Material:</span> {{ $product->materialDetail->name ?? 'N/A' }}</div>
                        <div class="metatext"><span>Units:</span> {{ $product->unitDetail->name ?? 'N/A' }}</div>
                        <div class="metatext"><span>weight type:</span> {{ $product->weightTypeDetail->name ?? 'N/A' }}</div>
                        <div class="metatext"><span>Brand:</span> {{ $product->brandName->name ?? 'N/A' }}</div>
                        @if ($product->has_variants == 1)
                            @php
                                $variantData = json_decode($product->variation_ids, true); // Assuming the JSON is stored in the 'variation_ids' field
                                $selectedVariant = $product->variants->first(); // Default selected variant
                            @endphp

                            @if (!empty($variantData))
                                @foreach ($variantData as $key => $variant)
                                    <div class="">
                                        <div class="excerpt">
                                            <h5 class="mb-1">{{ $variant['name'] }}</h5>
                                            @if ($variant['name'] == 'Color')
                                                <div class="color-options d-flex">
                                                    @foreach ($variant['details'] as $detail)
                                                        <div class="color-option" 
                                                            style="background-color: {{ strtolower($detail['name']) }}; width: 30px; height: 30px; margin-right: 10px; cursor: pointer; position: relative;" 
                                                            title="{{ $detail['name'] }}" 
                                                            data-variant-id="{{ $detail['id'] }}">
                                                            
                                                            <!-- Tick mark overlay -->
                                                            <div class="tick-mark" style="
                                                                position: absolute;
                                                                top: 50%;
                                                                left: 50%;
                                                                transform: translate(-50%, -50%);
                                                                font-size: 20px;
                                                                color: white;
                                                                display: none; /* Hidden by default */
                                                            ">
                                                                ✓
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <div class="variant-options">
                                                    <div class="btn-group-toggle" data-toggle="buttons">
                                                        @foreach ($variant['details'] as $detail)
                                                            <label class="btn btn-outline-secondary m-1 {{ $selectedVariant && $selectedVariant->variant_detail_id == $detail['id'] ? 'active' : '' }}">
                                                                <input type="radio" 
                                                                    name="{{ strtolower($variant['name']) }}" 
                                                                    value="{{ $detail['id'] }}" 
                                                                    data-variant-id="{{ $detail['id'] }}" 
                                                                    autocomplete="off" 
                                                                    {{ $selectedVariant && $selectedVariant->variant_detail_id == $detail['id'] ? 'checked' : '' }}> 
                                                                {{ $detail['name'] }}
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        @endif
                        <!-- Quantity Section -->
                        <div class="quantityd clearfix">
                            <button class="qtyBtn btnMinus"><span>-</span></button>
                            <input name="qty" value="1" title="Qty" class="input-text qty text carqty"
                                type="text">
                            <button class="qtyBtn btnPlus">+</button>
                        </div>
                        <div class="listing-meta">
                            <a class="add-to-cart" href="cart.html"><i class="nss-shopping-cart1"></i>Add To Cart</a>
                            <a href="javascript:;" class="whishlist" onclick="addToWishlist('{{ $product->id }}')">
                                <i class="nss-heart1"></i>
                            </a>
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

@push('styles')

@endpush
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const prices = JSON.parse(@json($prices));
            const userType = "{{ $userType }}";
            let isFirstLoad = true;

            // Pre-select the first variant for each group on page load
            function preselectVariants() {
                // Pre-select the first radio button in each variant group
                document.querySelectorAll('.variant-options').forEach(group => {
                    const firstRadio = group.querySelector('input[type="radio"]');
                    if (firstRadio) {
                        firstRadio.checked = true;
                        firstRadio.dispatchEvent(new Event('change')); // Trigger change event
                    }
                });

                // Pre-select the first color option and mark it as selected
                const firstColorOption = document.querySelector('.color-option');
                if (firstColorOption) {
                    firstColorOption.classList.add('selected');
                    const tickMark = firstColorOption.querySelector('.tick-mark');
                    if (tickMark) {
                        tickMark.style.display = 'block'; // Show the tick mark
                    }
                }

                // Gather initial selections and update the price
                updatePrice(getSelectedVariantIds());
            }

            // Gather all selected variant IDs
            function getSelectedVariantIds() {
                const selectedIds = [];

                // Gather the selected color
                const selectedColor = document.querySelector('.color-option.selected');
                if (selectedColor) {
                    selectedIds.push(selectedColor.getAttribute('data-variant-id'));
                }

                // Gather the selected radio buttons
                document.querySelectorAll('.variant-options input[type="radio"]:checked').forEach(radio => {
                    selectedIds.push(radio.value);
                });

                return selectedIds;
            }

            // Update price when a color option is selected
            document.querySelectorAll('.color-option').forEach(option => {
                option.addEventListener('click', function () {
                    // Deselect all color options and hide their tick marks
                    document.querySelectorAll('.color-option').forEach(el => {
                        el.classList.remove('selected');
                        const tickMark = el.querySelector('.tick-mark');
                        if (tickMark) {
                            tickMark.style.display = 'none'; // Hide the tick mark
                        }
                    });

                    // Mark the clicked option as selected and show its tick mark
                    this.classList.add('selected');
                    const tickMark = this.querySelector('.tick-mark');
                    if (tickMark) {
                        tickMark.style.display = 'block'; // Show the tick mark
                    }

                    // Update the price dynamically based on all selected variants
                    updatePrice(getSelectedVariantIds());
                });
            });

            // Update price when a radio button is selected
            document.querySelectorAll('.variant-options input[type="radio"]').forEach(radio => {
                radio.addEventListener('click', function () {
                    // Update the price dynamically based on all selected variants
                    updatePrice(getSelectedVariantIds());
                });
            });

            // Function to update the price display
            function updatePrice(selectedVariantIds) {
                // console.log('Selected Variant IDs:', selectedVariantIds); // Debugging

                // Make an AJAX request to fetch prices based on selected variant IDs
                $.ajax({
                    url: "{{ route('get.variant.prices') }}", // Ensure this route is set in web.php
                    method: 'POST',
                    data: {
                        variant_ids: selectedVariantIds,
                        productId: "{{ $product->id }}",
                        _token: "{{ csrf_token() }}", // Include CSRF token for security
                    },
                    success: function (response) {
                        if (!response.success) {
                            console.error('Error fetching prices:', response.message || 'Unknown error');
                            return;
                        }

                        // console.log('Fetched prices:', response.data);
                        const priceData = response.data;

                        // Update the price display
                        const priceElement = document.querySelector('.product_price .price span');
                        const originalPriceElement = document.querySelector('.product_price .price .original-price');
                        const discountElement = document.querySelector('.product_price .price .discount');

                        if (priceElement) {
                            priceElement.textContent = `₹${parseFloat(priceData.effective_price).toFixed(2)}`;
                        }

                        // Update the original price (strikethrough) if discounted
                        if (originalPriceElement) {
                            if (priceData.is_discounted) {
                                originalPriceElement.textContent = `₹${parseFloat(priceData.original_price).toFixed(2)}`;
                                originalPriceElement.style.display = 'inline';
                            } else {
                                originalPriceElement.style.display = 'none';
                            }
                        }

                        // Update the discount percentage if applicable
                        if (discountElement) {
                            if (priceData.is_discounted && priceData.discount_percentage) {
                                discountElement.textContent = `(${priceData.discount_percentage}% off)`;
                                discountElement.style.display = 'inline';
                            } else {
                                discountElement.style.display = 'none';
                            }
                        }
                        if (!isFirstLoad) {
                            updateImage(priceData.id);
                        } else {
                            isFirstLoad = false; // Reset the flag after the first update
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX error:', error);
                    }
                });
            }

            function updateImage(variantId) {
                // Using AJAX to get the image for the selected variant
                $.ajax({
                    url: "{{ route('get.variant.image') }}", // Ensure this route is defined in web.php
                    method: 'POST',
                    data: {
                        variant_id: variantId,
                        productId: "{{ $product->id }}",
                        _token: "{{ csrf_token() }}", // Include CSRF token for security
                    },
                    success: function (response) {
                        if (!response.success) {
                            console.error('Error fetching image:', response.message || 'Unknown error');
                            return;
                        }

                        const variantImage = response.data; // The fetched image path

                        console.log('Fetched variant image:', variantImage);

                        // Update thumbnail and banner images
                        const thumbSlider = document.querySelector('.slider-nav.thumb-image');
                        const bannerSlider = document.querySelector('.slider-for');

                        if (thumbSlider && bannerSlider) {
                            const thumbImages = [...thumbSlider.querySelectorAll('.thumbImg img')].filter(img => {
                                // Exclude cloned elements
                                return !img.closest('.slick-cloned');
                            });

                            const bannerImages = [...bannerSlider.querySelectorAll('.slider-banner-image img')];

                            let imageFound = false;

                            thumbImages.forEach((img, index) => {
                                // Match the `data-image-path` attribute directly
                                const imagePath = img.getAttribute('data-image-path'); // Custom attribute to store original image paths
                                if (imagePath === variantImage) {
                                    // Highlight the corresponding thumbnail
                                    const parentThumb = img.closest('.thumbnail-image');
                                    if (parentThumb) {
                                        parentThumb.classList.add('selected');
                                    }

                                    // Navigate to the corresponding banner image
                                    $('.slider-for').slick('slickGoTo', index);
                                    imageFound = true;
                                } else {
                                    const parentThumb = img.closest('.thumbnail-image');
                                    if (parentThumb) {
                                        parentThumb.classList.remove('selected');
                                    }
                                }
                            });

                            if (!imageFound) {
                                console.warn('Variant image not found in existing slider.');
                            }
                        } else {
                            console.error('Sliders not found in the DOM.');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX error:', error);
                    }
                });
            }
            // Initialize pre-selected variants
            preselectVariants();
        });

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
