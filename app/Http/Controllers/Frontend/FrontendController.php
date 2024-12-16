<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BannerSlider;
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
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Mail;

class FrontendController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():View
    {
        $bannerSliders = BannerSlider::where('status', 1)->orderBy('position', 'asc')->get();
        $homeInfo=HomeInfo::first();
        $counter=Counter::first();
        $footerInfo=FooterInfo::first();
        $mainCategory = MainCategory::where('status', 1)
        ->orderBy('position', 'asc')
        ->get();

       // Fetch categories and their related subcategories
    
        return view('frontend.home.index', compact('bannerSliders','homeInfo','counter','footerInfo','mainCategory'));
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
        'categories.name as category_name',
        'categories.slug as category_slug',
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
    // dd($categories);
        return view('frontend.home.category.index', compact('mainCategory', 'categories'));
    }

/*     public function productPage($slug)
{
    $product = Product::where('slug', $slug)->firstOrFail();
    $mainCatId = $product->main_category_id;
    $mainCategory = MainCategory::where('id', $mainCatId)->firstOrFail();
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
        'categories.name as category_name',
        'categories.slug as category_slug',
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
    return view('frontend.home.category.cat-product-details', compact('product', 'mainCategory', 'categories'));
} */

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
            'categories.name as category_name',
            'categories.slug as category_slug',
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

    return view('frontend.home.category.cat-product-details', compact('product', 'mainCategory', 'categories', 'relatedProducts', 'variants', 'images'));
}

public function categoryPage($slug)
{
    // Fetch the category by slug
    $category = Category::where('slug', $slug)->firstOrFail();
    // Fetch subcategories for the category
    $subcategories = SubCategory::where('category_id', $category->id)
        ->where('status', 1)
        ->orderBy('position', 'asc')
        ->get();
    // Fetch products if there are no subcategories
    $products = $subcategories->isEmpty()
        ? Product::where('category_id', $category->id)
            ->where('status', 1)
            ->orderBy('position', 'asc')
            ->get()
        : collect(); // Empty collection if subcategories exist

    return view('frontend.home.category.index', compact('category', 'subcategories', 'products'));
}


public function subCategoryPage($mainCategorySlug, $categorySlug, $subCategorySlug)
{
    // Fetch main category
    $mainCategory = MainCategory::where('slug', $mainCategorySlug)->firstOrFail();

    // Fetch category
    $category = Category::where('slug', $categorySlug)->where('main_category_id', $mainCategory->id)->firstOrFail();

    // Fetch subcategory
    $subCategory = SubCategory::where('slug', $subCategorySlug)->where('category_id', $category->id)->firstOrFail();

    // Fetch products under the subcategory
    $products = DB::table('products')
        ->leftJoin('product_images', 'products.id', '=', 'product_images.product_id')
        ->select(
            'products.id',
            'products.name',
            'products.slug',
            'products.sale_price',
            'products.offer_price',
            'products.qty',
            'products.status',
            DB::raw('MIN(product_images.image_path) as product_image') // Fetch the first image
        )
        ->where('products.sub_category_id', '=', $subCategory->id)
        ->where('products.status', '=', 1) // Only active products
        ->groupBy('products.id', 'products.name', 'products.slug', 'products.sale_price', 'products.offer_price', 'products.qty', 'products.status')
        ->orderBy('products.priority', 'asc') // Order by priority
        ->get();
        
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
            'categories.name as category_name',
            'categories.slug as category_slug',
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

    return view('frontend.home.subcategory.index', compact('mainCategory', 'category', 'subCategory', 'products', 'categories'));
}







    function subscribeNewsletter(Request $request) : Response
{
    $request->validate([
        'email' => ['required', 'email', 'max:255', 'unique:subscribers,email']
    ], ['email.unique' => 'Email is already subscribed!']);

    $subscriber = new Subscriber();
    $subscriber->email = $request->email;
    $subscriber->save();

    return response(['status' => 'success', 'message' => 'Subscribed Successfully!']);
}
}
