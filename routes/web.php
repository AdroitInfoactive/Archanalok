<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Frontend\DashboardController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\ProfileController;
use App\Http\Controllers\Frontend\WishlistController;
use Illuminate\Support\Facades\Route;

/** Admin Auth Routes */
Route::group(['middleware' => 'guest'], function () {
  Route::get('admin/login', [AdminAuthController::class, 'index'])->name('admin.login');
  Route::get('admin/forget-password', [AdminAuthController::class, 'forgetPassword'])->name('admin.forget-password');
});

Route::group(['middleware' => 'auth'], function () {
  Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
  Route::get('profile', [ProfileController::class, 'profile'])->name('profile.index');
  Route::put('profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
  Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
  Route::post('profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');
  Route::get('address', [DashboardController::class, 'address'])->name('address.index');
  Route::post('address', [DashboardController::class, 'createAddress'])->name('address.store');
  Route::put('address/{id}', [DashboardController::class, 'updateAddress'])->name('address.update'); 
  Route::delete('address/{id}', [DashboardController::class, 'destroyAddress'])->name('address.destroy');
  /** Wishlist Route */
Route::get('wishlist/', [WishlistController::class, 'whishlist'])->name('wishlist.index');
});

require __DIR__ . '/auth.php';
/** Show Home page */
Route::get('/', [FrontendController::class, 'index'])->name('home');
/** About Routes */
Route::get('/about', [FrontendController::class, 'about'])->name('about');
/** Privacy Policy Routes */

/** Trams and Conditions Routes */
Route::get('/terms-and-conditions', [FrontendController::class, 'termsAndConditions'])->name('terms-and-conditions');
// shippingpolicy
Route::get('/shipping-policy', [FrontendController::class, 'shippingPolicy'])->name('shipping-policy.index');
// returnpolicy
Route::get('/return-policy', [FrontendController::class, 'returnPolicy'])->name('return-policy.index');
/** Contact Routes */
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact.index');
Route::post('/contact', [FrontendController::class, 'sendContactMessage'])->name('contact.send-message');

Route::get('/privacy-policy', [FrontendController::class, 'privacyPolicy'])->name('privacy-policy.index');
// testimonials
Route::get('/testimonials', [FrontendController::class, 'testimonials'])->name('testimonials.index');

Route::get('wishlist/{productId}', [WishlistController::class, 'store'])->name('wishlist.store');

Route::get('/filter-products', [FrontendController::class, 'filterProducts'])->name('filter-products');

Route::post('/get-variant-prices', [FrontendController::class, 'getVariantPrices'])->name('get.variant.prices');

// Category Page (MainCategory -> Category -> SubCategory)
Route::get('/{slug}', [FrontendController::class, 'mainCategoryPage'])->name('maincategory.show');

Route::get('/product/{slug}', [FrontendController::class, 'productPage'])->name('product.show');

// Category Page
Route::get('/{mainCategorySlug}/{slug}', [FrontendController::class, 'categoryPage'])->name('category.show');

// SubCategory Page
Route::get('/{mainCategorySlug}/{categorySlug}/{slug}', [FrontendController::class, 'subCategoryPage'])->name('subcategory.show');

// // Product details Page

/** Newsletter Routes */
Route::post('/subscribe-newsletter', [FrontendController::class, 'subscribeNewsletter'])->name('subscribe-newsletter');