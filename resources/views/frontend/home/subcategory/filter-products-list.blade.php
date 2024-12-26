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
                                    // Determine the role (default to "user" for unauthenticated users)
                                    $role = auth()->check() ? auth()->user()->role : 'user';

                                    // Calculate the effective price
                                    $effectivePrice = match ($role) {
                                        'user' => $product->offer_price ?: $product->sale_price, // Only users or unauthenticated users can access offer_price
                                        'ws' => $product->wholesale_price,
                                        'dr' => $product->distributor_price,
                                        default => $product->sale_price,
                                    };

                                    // Calculate the percentage discount
                                    $percentageOff = ($role === 'user' && $product->offer_price)
                                        ? round((($product->sale_price - $product->offer_price) / $product->sale_price) * 100)
                                        : null;
                                @endphp

                                <div class="product-pricing">
                                    @if ($role === 'user' && $product->offer_price)
                                        <span class="price">
                                            <span>₹{{ number_format($effectivePrice, 2) }}</span>
                                            <span style="text-decoration: line-through; font-size: 0.9em;" class="text-muted">
                                                ₹{{ number_format($product->sale_price, 2) }}
                                            </span>
                                            @if ($percentageOff)
                                                <span style="font-size: 0.8em;" class="discount text-success">
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
                                @php
                                    // Get the least price variant
                                    $leastPriceVariant = $product->variants->sortBy('sale_price')->first();

                                    // Determine the role (default to "user" for unauthenticated users)
                                    $role = auth()->check() ? auth()->user()->role : 'user';

                                    // Calculate the effective price
                                    $effectivePrice = $leastPriceVariant
                                        ? match ($role) {
                                            'user' => $leastPriceVariant->offer_price ?: $leastPriceVariant->sale_price,
                                            'ws' => $leastPriceVariant->wholesale_price ?: $leastPriceVariant->sale_price,
                                            'dr' => $leastPriceVariant->distributor_price ?: $leastPriceVariant->sale_price,
                                            default => $leastPriceVariant->sale_price,
                                        }
                                        : match ($role) {
                                            'user' => $product->offer_price ?: $product->sale_price,
                                            'ws' => $product->wholesale_price ?: $product->sale_price,
                                            'dr' => $product->distributor_price ?: $product->sale_price,
                                            default => $product->sale_price,
                                        };

                                    // Calculate the percentage discount
                                    $percentageOff = ($role === 'user' && $leastPriceVariant && $leastPriceVariant->offer_price)
                                        ? round((($leastPriceVariant->sale_price - $leastPriceVariant->offer_price) / $leastPriceVariant->sale_price) * 100)
                                        : null;
                                @endphp

                                <div class="product-pricing">
                                    @if ($role === 'user' && $leastPriceVariant && $leastPriceVariant->offer_price)
                                        <span class="price">
                                            <span>₹{{ number_format($effectivePrice, 2) }}</span>
                                            <span
                                                style="text-decoration: line-through; font-size: 0.9em;"
                                                class="text-muted">₹{{ number_format($leastPriceVariant->sale_price, 2) }}</span>
                                            @if ($percentageOff)
                                                <span style="font-size: 0.8em;"
                                                    class="discount text-success">({{ $percentageOff }}%
                                                    off)</span>
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
