<?php

use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\BannerSliderController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\CounterController;
use App\Http\Controllers\Admin\FooterInfoController;
use App\Http\Controllers\Admin\HomeInfoController;
use App\Http\Controllers\Admin\MainCategoryBannerController;
use App\Http\Controllers\Admin\MainCategoryController;
use App\Http\Controllers\Admin\NewsLetterController;
use App\Http\Controllers\Admin\PrivacyPolicyController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ReturnPolicyController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ShippingPolicyController;
use App\Http\Controllers\Admin\SocialLinkController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\TermsAndCoditionController;
use App\Http\Controllers\Admin\VariantDetailController;
use App\Http\Controllers\Admin\VariantMasterController;
use App\Http\Controllers\Auth\RegisteredUserController;

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
  Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');


  /** Profile Routes **/
  Route::get('profile', [ProfileController::class, 'index'])->name('profile');
  Route::put('profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
  Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    /** user Routes */
    Route::get('users', [RegisteredUserController::class, 'userDetails'])->name('user.status');
    Route::post('/update-status', [RegisteredUserController::class, 'updateStatus'])->name('user.updateStatus');

  /** maincategory Routes */
  Route::resource('main-category', MainCategoryController::class);

  /**Product maincategory banners Routes */
  Route::get('main-category-banner/{product}', [MainCategoryBannerController::class, 'index'])->name('main-category-banner.show.index');
  Route::resource('main-category-banner', MainCategoryBannerController::class);

  /** Category Routes */
  Route::resource('category', CategoryController::class);
  /** subcategory Routes */
  Route::get('get-category/{mainCategoryId}', [SubCategoryController::class, 'getCategoriesByMainCategory'])->name('get-category.getCategoriesByMainCategory');
  Route::resource('sub-category', SubCategoryController::class);

  /** Brand Routes */
  Route::resource('brand', BrandController::class);
  
  /** varient Routes */
  Route::resource('variant-master', VariantMasterController::class);
  Route::post('variant-master/update-order', [VariantMasterController::class, 'updateOrder'])->name('variant-master.updateOrder');

  /** varient details Routes */
  Route::resource('variant-details', VariantDetailController::class);

 /** Product Routes */
 Route::get('/products/generate-excel-template', [ProductController::class, 'generateExcelTemplate'])->name('products.generateExcelTemplate');
  Route::resource('products', ProductController::class);
  Route::post('/products/update-image-order', [ProductController::class,
  'updateImageOrder'])->name('products.updateImageOrder');
  Route::post('/products/delete-image', [ProductController::class, 'deleteImage'])->name('products.deleteImage');


  /** Banner Slider Routes */
  Route::resource('banner-slider', BannerSliderController::class);

  /** Counter Routes */
  Route::get('counter', [CounterController::class, 'index'])->name('counter.index');
  Route::put('counter', [CounterController::class, 'update'])->name('counter.update');

  /** About Routes */
  Route::get('about', [AboutController::class, 'index'])->name('about.index');
  Route::put('about', [AboutController::class, 'update'])->name('about.update');

  /** HomeInfo Routes */
  Route::get('home-info', [HomeInfoController::class, 'index'])->name('home-info.index');
  Route::put('home-info', [HomeInfoController::class, 'update'])->name('home-info.update');

  /** Privacy policy Routes */
  Route::get('privacy-policy', [PrivacyPolicyController::class, 'index'])->name('privacy-policy.index');
  Route::put('privacy-policy', [PrivacyPolicyController::class, 'update'])->name('privacy-policy.update');

  /** Terms and Conditions Routes */
  Route::get('terms-and-conditions', [TermsAndCoditionController::class, 'index'])->name('terms-and-conditions.index');
  Route::put('terms-and-conditions', [TermsAndCoditionController::class, 'update'])->name('terms-and-conditions.update');

  /** Return policy Routes */
  Route::get('return-policy', [ReturnPolicyController::class, 'index'])->name('return-policy.index');
  Route::put('return-policy', [ReturnPolicyController::class, 'update'])->name('return-policy.update');

  /** Shipping policy Routes */
  Route::get('shipping-policy', [ShippingPolicyController::class, 'index'])->name('shipping-policy.index');
  Route::put('shipping-policy', [ShippingPolicyController::class, 'update'])->name('shipping-policy.update');

  /** Contact Routes */
  Route::get('contact', [ContactController::class, 'index'])->name('contact.index');
  Route::put('contact', [ContactController::class, 'update'])->name('contact.update');

  /** Social Links Routes */
  Route::resource('social-link', SocialLinkController::class);

  /** Footer Routes */
  Route::get('footer-info', [FooterInfoController::class, 'index'])->name('footer-info.index');
  Route::put('footer-info', [FooterInfoController::class, 'update'])->name('footer-info.update');

  /** News letter Routes */
  Route::get('news-letter', [NewsLetterController::class, 'index'])->name('news-letter.index');
  Route::post('news-letter', [NewsLetterController::class, 'sendNewsLetter'])->name('news-letter.send');

  /** Setting Routes */
  Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
  Route::put('/general-setting', [SettingController::class, 'UpdateGeneralSetting'])->name('general-setting.update');
  Route::put('/pusher-setting', [SettingController::class, 'UpdatePusherSetting'])->name('pusher-setting.update');
  Route::put('/mail-setting', [SettingController::class, 'UpdateMailSetting'])->name('mail-setting.update');
  Route::put('/logo-setting', [SettingController::class, 'UpdateLogoSetting'])->name('logo-setting.update');
  Route::put('/appearance-setting', [SettingController::class, 'UpdateAppearanceSetting'])->name('appearance-setting.update');
  Route::put('/seo-setting', [SettingController::class, 'UpdateSeoSetting'])->name('seo-setting.update');

});
