<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Frontend\DashboardController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});
Route::group(['middleware' => 'guest'], function () {

    Route::get('admin/login', [AdminAuthController::class, 'index'])->name('admin.login');
    Route::get('admin/forgot-password', [AdminAuthController::class, 'forgotPassword'])->name('admin.forgot-password');
  });

  Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
  Route::get('address', [DashboardController::class, 'address'])->name('address.index');
  Route::post('address', [DashboardController::class, 'createAddress'])->name('address.store');
  Route::put('address/{id}/edit', [DashboardController::class, 'updateAddress'])->name('address.update');
  Route::delete('address/{id}', [DashboardController::class, 'destroyAddress'])->name('address.destroy');


require __DIR__.'/auth.php';
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

Route::get('/privacy-policy', [FrontendController::class, 'privacyPolicy'])->name('privacy-policy.index');
// testimonials
Route::get('/testimonials', [FrontendController::class, 'testimonials'])->name('testimonials.index');


/** Wishlist Route */
Route::get('wishlist/{productId}', [WishlistController::class, 'store'])->name('wishlist.store');
// Category Page (MainCategory -> Category -> SubCategory)
Route::get('/{slug}', [FrontendController::class, 'mainCategoryPage'])->name('maincategory.show');

// SubCategory Page
Route::get('/{mainCategorySlug}/{categorySlug}/{slug}', [FrontendController::class, 'subCategoryPage'])->name('subcategory.show');

// // Product details Page
Route::get('/product/{slug}', [FrontendController::class, 'productPage'])->name('product.show');

/** Newsletter Routes */
Route::post('/subscribe-newsletter', [FrontendController::class, 'subscribeNewsletter'])->name('subscribe-newsletter');





