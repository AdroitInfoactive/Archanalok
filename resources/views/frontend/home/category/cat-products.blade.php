
<div id="category-sections">
    @foreach ($categories as $index => $category)
    {{-- Alternate section classes --}}
    <section class="{{ $index % 2 === 0 ? 'popular-section' : 'popular-section2' }}">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2 class="sec_titles">{{ $category->category_name }}</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="popular-slider owl-carousel">
                        {{-- Check if category has subcategories --}}
                        @if (!empty($category->sub_category_names))
                            @php
                                $subCategoryNames = explode(',', $category->sub_category_names);
                                $subCategoryImages = explode(',', $category->sub_category_images);
                                $subCategorySlugs = explode(',', $category->sub_category_slugs);
                            @endphp
                            @foreach ($subCategoryNames as $subIndex => $subCategoryName)
                            <div class="product-item-2 text-center">
                                <div class="product-thumb">
                                      <a href="{{ url($mainCategory->slug . '/' . $category->category_slug . '/' . $subCategorySlugs[$subIndex] ?? '#') }}">
                                        <img src="{{ asset($subCategoryImages[$subIndex] ?? 'frontend/images/default-placeholder.png') }}" alt="{{ $subCategoryName }}" />
                                    </a>
                                </div>
                                <div class="product-details">
                                    <h5><a href="{{ url($mainCategory->slug . '/' . $category->category_slug . '/' . $subCategorySlugs[$subIndex] ?? '#') }}">{{ $subCategoryName }}</a></h5>
                                </div>
                            </div>
                            @endforeach
                        @else
                            {{-- Display products if no subcategories --}}
                            @php
                                $productNames = explode(',', $category->product_names);
                                $productImages = explode(',', $category->product_images);
                                $productSlugs = explode(',', $category->product_slugs);
                            @endphp
                            @foreach ($productNames as $productIndex => $productName)
                            <div class="product-item-2 text-center">
                                <div class="product-thumb">
                                    <a href="{{ url('product/' . ($productSlugs[$productIndex] ?? '#')) }}">
                                        <img src="{{ asset($productImages[$productIndex] ?? 'frontend/images/default-placeholder.png') }}" alt="{{ $productName }}" />
                                    </a>
                                </div>
                                <div class="product-details">
                                    <h5><a href="{{ url('product/' . ($productSlugs[$productIndex] ?? '#')) }}">{{ $productName }}</a></h5>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
  
    {{-- Insert banner after every two sections --}}
    @if (($index + 1) % 2 === 0)
    <div class="row">
        <div class="col-lg-12">
            <img src="{{ asset('frontend/images/offer-banner-3.png') }}" class="w100" alt="Offer Banner" />
        </div>
    </div>
    @endif
    @endforeach
  </div>