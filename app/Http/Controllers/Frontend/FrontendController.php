<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\ContactMail;
use App\Models\BannerSlider;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Counter;
use App\Models\FooterInfo;
use App\Models\HomeInfo;
use App\Models\MainCategory;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\SubCategory;
use App\Models\Subscriber;
use App\Models\About;
use App\Models\Contact;
use App\Models\PrivacyPolicy;
use App\Models\ReturnPolicy;
use App\Models\ShippingPolicy;
use App\Models\TermsAndCondition;
use App\Models\VariantMaster;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Mail;

// class FrontendController extends Controller
class FrontendController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $bannerSliders = BannerSlider::where('status', 1)->orderBy('position', 'asc')->get();
        $homeInfo = HomeInfo::first();
        $counter = Counter::first();
        // Fetch categories and their related subcategories
        return view('frontend.home.index', compact('bannerSliders', 'homeInfo', 'counter'));
    }
    public function mainCategoryPage($slug)
    {
        $mainCategory = MainCategory::where('slug', $slug)->firstOrFail();
        $categories = DB::table('categories')
            ->leftJoin('sub_categories', function ($join) {
                $join->on('categories.id', '=', 'sub_categories.category_id')
                    ->where('sub_categories.status', '=', '1'); // Filter active subcategories
            })
            ->leftJoin('products', function ($join) {
                $join->on('categories.id', '=', 'products.category_id')
                    ->where('products.status', '=', '1'); // Filter active products
            })
            ->leftJoin('product_images', function ($join) {
                $join->on('products.id', '=', 'product_images.product_id');
            })
            ->select(
                'categories.id as category_id',
                'categories.name as name',
                'categories.slug as slug',
                DB::raw('GROUP_CONCAT(DISTINCT sub_categories.id ORDER BY sub_categories.position ASC) as sub_category_ids'), // Order subcategories by position
                DB::raw('GROUP_CONCAT(DISTINCT sub_categories.name ORDER BY sub_categories.position ASC) as sub_category_names'),
                DB::raw('GROUP_CONCAT(DISTINCT sub_categories.image ORDER BY sub_categories.position ASC) as sub_category_images'),
                DB::raw('GROUP_CONCAT(DISTINCT sub_categories.slug ORDER BY sub_categories.position ASC) as sub_category_slugs'),
                DB::raw('GROUP_CONCAT(DISTINCT products.id ORDER BY products.priority ASC) as product_ids'), // Order products by priority
                DB::raw('GROUP_CONCAT(DISTINCT products.name ORDER BY products.priority ASC) as product_names'),
                DB::raw('GROUP_CONCAT(DISTINCT products.slug ORDER BY products.priority ASC) as product_slugs'),
                DB::raw('GROUP_CONCAT(DISTINCT (
            SELECT image_path
            FROM product_images pi
            WHERE pi.product_id = products.id
            ORDER BY pi.order ASC LIMIT 1
        )) as product_images') // Fetch one product image per product ordered by position
            )
            ->where('categories.main_category_id', '=', $mainCategory->id) // Filter by main category ID
            ->groupBy('categories.id', 'categories.name', 'categories.slug') // Group by unique category fields
            ->get();
        return view('frontend.home.category.index', compact('mainCategory', 'categories'));
    }

    public function productPage($slug)
    {
        // Fetch the product based on the slug
        $product = Product::where('slug', $slug)->with(['images'])->firstOrFail();

        // Fetch the main category associated with the product
        $mainCategory = MainCategory::where('id', $product->main_category_id)->firstOrFail();

        // Fetch related categories, subcategories, and products
        $categories = DB::table('categories')
            ->leftJoin('sub_categories', function ($join) {
                $join->on('categories.id', '=', 'sub_categories.category_id')
                    ->where('sub_categories.status', '=', '1'); // Filter active subcategories
            })
            ->leftJoin('products', function ($join) {
                $join->on('categories.id', '=', 'products.category_id')
                    ->where('products.status', '=', '1'); // Filter active products
            })
            ->leftJoin('product_images', function ($join) {
                $join->on('products.id', '=', 'product_images.product_id');
            })
        
            ->select(
                'categories.id as category_id',
                'categories.name as name',
                'categories.slug as slug',
                DB::raw('GROUP_CONCAT(DISTINCT sub_categories.id ORDER BY sub_categories.position ASC) as sub_category_ids'),
                DB::raw('GROUP_CONCAT(DISTINCT sub_categories.name ORDER BY sub_categories.position ASC) as sub_category_names'),
                DB::raw('GROUP_CONCAT(DISTINCT sub_categories.slug ORDER BY sub_categories.position ASC) as sub_category_slugs'),
                DB::raw('GROUP_CONCAT(DISTINCT products.id ORDER BY products.priority ASC) as product_ids'),
                DB::raw('GROUP_CONCAT(DISTINCT products.name ORDER BY products.priority ASC) as product_names'),
                DB::raw('GROUP_CONCAT(DISTINCT products.slug ORDER BY products.priority ASC) as product_slugs'),

                DB::raw('GROUP_CONCAT(DISTINCT (
                SELECT image_path
                FROM product_images pi
                WHERE pi.product_id = products.id
                ORDER BY pi.order ASC LIMIT 1
            )) as product_images')
            )
            ->where('categories.main_category_id', '=', $mainCategory->id) // Filter by main category ID
            ->groupBy('categories.id', 'categories.name', 'categories.slug')
            ->get();

        // Fetch related products for the "Related Products" section
        $relatedProducts = Product::where('main_category_id', $mainCategory->id)
            ->where('id', '!=', $product->id) // Exclude current product
            ->where('status', 1)
            ->orderBy('priority', 'asc')
            ->limit(10)
            ->with('images') // Eager load images
            ->get();
        $variants = ProductVariant::where('product_id', $product->id)->get();

        // Fetch images for the variants
        $images = ProductImage::where('product_id', $product->id)
            ->orderBy('order', 'asc')
            ->get();

        // dd($images);

        return view('frontend.home.category.cat-product-details', compact('product', 'mainCategory', 'categories', 'relatedProducts', 'variants', 'images'));
    }

    public function categoryPage($maninCategorySlug, $slug, Request $request)
    {        
        $mainCategory = MainCategory::where('slug', $maninCategorySlug)->firstOrFail();
        $category = Category::where('slug', $slug)->where('main_category_id', $mainCategory->id)->firstOrFail();
        // check whether sub categories available for the category
        $subcategories = SubCategory::where('category_id', $category->id)->where('status', 1)->orderBy('position', 'asc')->get();

        $categories = Category::with('subCategories')->where('main_category_id', $mainCategory->id)->get();
        // if subcategories available then fetch subcategories
        if ($subcategories->isNotEmpty()) {
            // display view for sub categorirs
            return view('frontend.home.category.subcategories', compact('mainCategory', 'category', 'subcategories', 'categories'));
        }
        else
        {
            // display view for products
            $productQuery = Product::with(['variants', 'images'])
            ->where('category_id', $category->id)
            ->where('status', 1);

                // Fetch all products
                $products = $productQuery->get();

                // Fetch min and max prices dynamically based on user role and variants
                $userType = auth()->check() ? auth()->user()->role : 'user';

                $minPrice = $products->map(function ($product) use ($userType) {
                    return $this->getEffectivePriceWithVariants($product, $userType, 'min');
                })->filter()->min();

                $maxPrice = $products->map(function ($product) use ($userType) {
                    return $this->getEffectivePriceWithVariants($product, $userType, 'max');
                })->filter()->max();

                if ($request->has('orderby')) {
                    $userType = auth()->check() ? auth()->user()->role : 'user';

                    switch ($request->orderby) {
                        case 'new': // Newest products
                            $productQuery->orderBy('created_at', 'desc');
                            $products = $productQuery->get();
                            break;

                        case 'price-asc': // Price: Low to High
                            $products = $productQuery->get()->map(function ($product) use ($userType) {
                                $product->effective_price = $this->getEffectivePriceWithVariants($product, $userType);
                                return $product;
                            })->sortBy('effective_price')->values(); // Reindex the sorted collection
                            break;

                        case 'price-desc': // Price: High to Low
                            $products = $productQuery->get()->map(function ($product) use ($userType) {
                                $product->effective_price = $this->getEffectivePriceWithVariants($product, $userType);
                                return $product;
                            })->sortByDesc('effective_price')->values(); // Reindex the sorted collection
                            break;

                        default: // Default sorting
                            $productQuery->orderBy('priority', 'asc');
                            $products = $productQuery->get();
                            break;
                    }
                } else {
                    $productQuery->orderBy('priority', 'asc'); // Default sorting
                    $products = $productQuery->get();
                }

                // Fetch categories and brands
                $categories = Category::with('subCategories')->where('main_category_id', $mainCategory->id)->get();
                $brands = Brand::where('status', 1)
                    ->orderBy('position', 'asc')
                    ->get();

                $variants = VariantMaster::with(['details' => function ($query) {
                    $query->where('status', 1) // Filter only active variants
                        ->orderBy('name', 'asc'); // Sort variants by name
                }])
                ->where('status', 1) // Filter only active variant masters
                ->orderBy('position', 'asc') // Sort variant masters by position
                ->get();
            // return view('frontend.home.category.products', compact('mainCategory', 'category'));
            return view('frontend.home.subcategory.index', compact(
                'mainCategory',
                'category',
                'products',
                'categories',
                'brands',
                'minPrice',
                'maxPrice',
                'variants'
            ));
        }
    }

    public function subCategoryPage($mainCategorySlug, $categorySlug, $subCategorySlug, Request $request)
    {
        $mainCategory = MainCategory::where('slug', $mainCategorySlug)->firstOrFail();
        $category = Category::where('slug', $categorySlug)->where('main_category_id', $mainCategory->id)->firstOrFail();
        $subCategory = SubCategory::where('slug', $subCategorySlug)->where('category_id', $category->id)->firstOrFail();

        // Query for products
        $productQuery = Product::with([
            'variants',
            'images' => function ($query) {
                $query->orderBy('order', 'asc'); // Order images by the 'order' field in ascending order
            }
        ])
        ->where('sub_category_id', $subCategory->id)
        ->where('status', 1);

        // Fetch all products
        $products = $productQuery->get();

        // Fetch min and max prices dynamically based on user role and variants
        $userType = auth()->check() ? auth()->user()->role : 'user';

        $minPrice = $products->map(function ($product) use ($userType) {
            return $this->getEffectivePriceWithVariants($product, $userType, 'min');
        })->filter()->min();

        $maxPrice = $products->map(function ($product) use ($userType) {
            return $this->getEffectivePriceWithVariants($product, $userType, 'max');
        })->filter()->max();

        if ($request->has('orderby')) {
            $userType = auth()->check() ? auth()->user()->role : 'user';

            switch ($request->orderby) {
                case 'new': // Newest products
                    $productQuery->orderBy('created_at', 'desc');
                    $products = $productQuery->get();
                    break;

                case 'price-asc': // Price: Low to High
                    $products = $productQuery->get()->map(function ($product) use ($userType) {
                        $product->effective_price = $this->getEffectivePriceWithVariants($product, $userType);
                        return $product;
                    })->sortBy('effective_price')->values(); // Reindex the sorted collection
                    break;

                case 'price-desc': // Price: High to Low
                    $products = $productQuery->get()->map(function ($product) use ($userType) {
                        $product->effective_price = $this->getEffectivePriceWithVariants($product, $userType);
                        return $product;
                    })->sortByDesc('effective_price')->values(); // Reindex the sorted collection
                    break;

                default: // Default sorting
                    $productQuery->orderBy('priority', 'asc');
                    $products = $productQuery->get();
                    break;
            }
        } else {
            $productQuery->orderBy('priority', 'asc'); // Default sorting
            $products = $productQuery->get();
        }

        // Fetch categories and brands
        $categories = Category::with('subCategories')->where('main_category_id', $mainCategory->id)->get();
        $brands = Brand::where('status', 1)
            ->orderBy('position', 'asc')
            ->get();

        $variants = VariantMaster::with(['details' => function ($query) {
            $query->where('status', 1) // Filter only active variants
                ->orderBy('name', 'asc'); // Sort variants by name
        }])
        ->where('status', 1) // Filter only active variant masters
        ->orderBy('position', 'asc') // Sort variant masters by position
        ->get();

        return view('frontend.home.subcategory.index', compact(
            'mainCategory',
            'category',
            'subCategory',
            'products',
            'categories',
            'brands',
            'minPrice',
            'maxPrice',
            'variants'
        ));
    }

    // Helper method to get effective price based on user type and variants
    private function getEffectivePriceWithVariants($product, $userType)
    {
        // If product has variants
        if ($product->has_variants && $product->variants->isNotEmpty()) {
            // Fetch the lowest price among variants
            return $product->variants->map(function ($variant) use ($userType) {
                return $this->getEffectivePrice($variant, $userType);
            })->min(); // Get the lowest price
        }

        // If no variants, use product's base price
        return $this->getEffectivePrice($product, $userType);
    }

    // Helper method to calculate effective price for a product or variant
    private function getEffectivePrice($item, $userType)
    {
        // Determine the effective price based on user type and availability
        if ($userType === 'ws') {
            return $item->wholesale_price;
        } elseif ($userType === 'dr') {
            return $item->distributor_price;
        } elseif ($userType === 'user') {
            return $item->offer_price ?: $item->sale_price;
        } else {
            return $item->sale_price;
        }
    }

    public function getVariantPrices(Request $request)
    {
        $request->validate([
            'variant_ids' => 'required|array', // Validate that variant_ids is an array
            'variant_ids.*' => 'integer', // Each ID in the array should be an integer
            'productId' => 'required|integer', // Validate that productId is an integer
        ]);

        $variantIds = $request->variant_ids; // Selected variant IDs
        $productId = $request->productId; // Product ID

        // Fetch all active variants for the given product
        $variants = ProductVariant::where('product_id', $productId)
            ->where('status', 1)
            ->get();

        // Find the matched variant
        $matchedVariant = $variants->first(function ($variant) use ($variantIds) {
            // Decode the JSON variation_ids field into an array
            $variantVariationIds = json_decode($variant->variation_ids, true);

            // Check if $variantIds matches $variantVariationIds irrespective of order
            return !array_diff($variantIds, $variantVariationIds) && !array_diff($variantVariationIds, $variantIds);
        });

        if (!$matchedVariant) {
            return response()->json([
                'success' => false,
                'message' => 'No matching variant found.',
            ], 404);
        }

        // Determine user type
        $userType = auth()->check() ? auth()->user()->role : 'user';

        // Calculate prices for the matched variant
        $effectivePrice = match ($userType) {
            'ws' => $matchedVariant->wholesale_price,
            'dr' => $matchedVariant->distributor_price,
            'user' => $matchedVariant->offer_price ?? $matchedVariant->sale_price,
            default => $matchedVariant->sale_price,
        };

        $isDiscounted = $matchedVariant->offer_price && $matchedVariant->offer_price < $matchedVariant->sale_price;

        $responseData = [
            'id' => $matchedVariant->id,
            'effective_price' => $effectivePrice,
            'original_price' => $matchedVariant->sale_price,
            'is_discounted' => $isDiscounted,
            'offer_price' => $matchedVariant->offer_price,
            'discount_percentage' => $isDiscounted
                ? round((($matchedVariant->sale_price - $matchedVariant->offer_price) / $matchedVariant->sale_price) * 100)
                : null,
            'min_order_qty' => $matchedVariant->min_order_qty,
            'available_qty' => $matchedVariant->qty,
        ];

        return response()->json([
            'success' => true,
            'data' => $responseData,
        ]);
    }

    public function getVariantImage(Request $request)
    {
        $request->validate([
            'variant_id' => 'required|integer',
            'productId' => 'required|integer',
        ]);
        $variantId = $request->variant_id;
        $productId = $request->productId;
        $variantImage = ProductImage::where('variant_id', $variantId)->where('product_id', $productId)->pluck('image_path')->first();
        if (!$variantImage) {
            return response()->json([
                'success' => false,
                'message' => 'Variant image not found.',
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $variantImage
        ]);
    }

    public function filterProducts(Request $request)
    {
        $request->validate([
            'min_price' => 'required|numeric',
            'max_price' => 'required|numeric',
        ]);

        $minPrice = $request->min_price;
        $maxPrice = $request->max_price;
        $userType = auth()->check() ? auth()->user()->role : 'user';

        $productQuery = Product::with([
            'variants',
            'images' => function ($query) {
            $query->orderBy('order', 'asc'); // Order images by the 'order' field in ascending order
            }
        ])->where('status', 1);

        if ($request->filled('brands')) {
            // Filter products by brand ID
            $brands = is_array($request->brands) ? $request->brands : explode(',', $request->brands);
            $productQuery->whereIn('brand', $brands);
        }

        if ($request->filled('details')) {
            $details = is_array($request->details) ? $request->details : explode(',', $request->details);

            $productQuery->where(function ($query) use ($details) {
                foreach ($details as $detail) {
                    // Determine the type of the detail (e.g., material, units, weight type)
                    $masterType = VariantMaster::whereHas('details', function ($q) use ($detail) {
                        $q->where('id', $detail);
                    })->value('name');

                    if ($masterType) {
                        switch (strtolower($masterType)) {
                            case 'material':
                                $query->orWhereRaw("FIND_IN_SET(?, material)", [$detail]);
                                break;
                            case 'units':
                                $query->orWhereRaw("FIND_IN_SET(?, units)", [$detail]);
                                break;
                            case 'weight type':
                                $query->orWhereRaw("FIND_IN_SET(?, weight_type)", [$detail]);
                                break;
                            default:
                                $query->orWhereRaw("JSON_CONTAINS(JSON_EXTRACT(variation_ids, '$.*.details[*].id'), JSON_QUOTE(?))", [$detail]);
                                break;
                        }
                    }
                }
            });
        }

        $products = $productQuery->get()->map(function ($product) use ($userType) {
            if ($product->has_variants && $product->variants->isNotEmpty()) {
                $variant = $product->variants->sortBy('sale_price')->first();
                $product->effective_price = match ($userType) {
                    'user' => $variant->offer_price ?? $variant->sale_price,
                    'ws' => $variant->wholesale_price,
                    'dr' => $variant->distributor_price,
                    default => $variant->sale_price,
                };
            } else {
                $product->effective_price = match ($userType) {
                    'user' => $product->offer_price ?? $product->sale_price,
                    'ws' => $product->wholesale_price,
                    'dr' => $product->distributor_price,
                    default => $product->sale_price,
                };
            }
            return $product;
        });

        $products = $products->filter(function ($product) use ($minPrice, $maxPrice) {
            return $product->effective_price >= $minPrice && $product->effective_price <= $maxPrice;
        });

        $gridHtml = view('frontend.home.subcategory.filter-products-grid', ['products' => $products])->render();
        $listHtml = view('frontend.home.subcategory.filter-products-list', ['products' => $products])->render();

        return response()->json([
            'gridHtml' => $gridHtml,
            'listHtml' => $listHtml,
            'calculatedMinPrice' => $products->min('effective_price'),
            'calculatedMaxPrice' => $products->max('effective_price'),
        ]);
    }

    function subscribeNewsletter(Request $request): Response
    {
        $request->validate([
            'email' => ['required', 'email', 'max:255', 'unique:subscribers,email']
        ], ['email.unique' => 'Email is already subscribed!']);

        $subscriber = new Subscriber();
        $subscriber->email = $request->email;
        $subscriber->save();

        return response(['status' => 'success', 'message' => 'Subscribed Successfully!']);
    }
    public function about(): View
    {
        $about = About::first();
        return view('frontend.pages.about', compact('about'));
    }

    public function testimonials(): View
    {
        return view('frontend.pages.testimonial');
    }

    public function privacyPolicy(): View
    {
        $privacyPolicy = PrivacyPolicy::first();
        return view('frontend.pages.privacy-policy', compact('privacyPolicy'));
    }

    public function returnPolicy(): View
    {
        $returnPolicy = ReturnPolicy::first();
        return view('frontend.pages.return-policy', compact('returnPolicy'));
    }

    public function shippingPolicy(): View
    {
        $shippingPolicy = ShippingPolicy::first();
        return view('frontend.pages.shipping-policy', compact('shippingPolicy'));
    }

    public function termsAndConditions(): View
    {
        $termsAndConditions = TermsAndCondition::first();
        return view('frontend.pages.terms-and-conditions', compact('termsAndConditions'));
    }

    public function contact(): View
    {
        $contact = Contact::first();
        return view('frontend.pages.contact', compact('contact'));
    }
    function sendContactMessage(Request $request) {
        $request->validate([
            'name' => ['required', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['required', 'max:255'],
            'message' => ['required', 'max: 1000']
        ]);

        Mail::send(new ContactMail($request->name, $request->email, $request->subject, $request->message));

        return response(['status' => 'success', 'message' => 'Message Sent Successfully!']);
    }
}
