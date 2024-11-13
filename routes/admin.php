<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\MainCategoryController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\VariantDetailController;
use App\Http\Controllers\Admin\VariantMasterController;

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
  Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
  // admin/dashboard and name admin.dashboard


  /** Profile Routes **/
  Route::get('profile', [ProfileController::class, 'index'])->name('profile');
  Route::put('profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
  Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
  /** maincategory Routes */
  Route::resource('main-category', MainCategoryController::class);
  /** Category Routes */
  Route::resource('category', CategoryController::class);
  /** subcategory Routes */
  Route::get('get-category/{mainCategoryId}', [SubCategoryController::class, 'getCategoriesByMainCategory'])->name('get-category.getCategoriesByMainCategory');
  Route::resource('sub-category', SubCategoryController::class);

  /** varient Routes */
  Route::resource('variant-master', VariantMasterController::class);
  Route::post('variant-master/update-order', [VariantMasterController::class, 'updateOrder'])->name('variant-master.updateOrder');

 /** varient details Routes */
 Route::resource('variant-details', VariantDetailController::class);

  /** Setting Routes */
  Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
  Route::put('/general-setting', [SettingController::class, 'UpdateGeneralSetting'])->name('general-setting.update');
  Route::put('/pusher-setting', [SettingController::class, 'UpdatePusherSetting'])->name('pusher-setting.update');
  Route::put('/mail-setting', [SettingController::class, 'UpdateMailSetting'])->name('mail-setting.update');
  Route::put('/logo-setting', [SettingController::class, 'UpdateLogoSetting'])->name('logo-setting.update');
  Route::put('/appearance-setting', [SettingController::class, 'UpdateAppearanceSetting'])->name('appearance-setting.update');
  Route::put('/seo-setting', [SettingController::class, 'UpdateSeoSetting'])->name('seo-setting.update');

  Route::get('/test-event', function () {

  event(new \App\Events\SimpleEvent());

  return 'Event dispatched';
  });

});
