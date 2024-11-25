<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});
Route::group(['middleware' => 'guest'], function () {

    Route::get('admin/login', [AdminAuthController::class, 'index'])->name('admin.login');
    Route::get('admin/forgot-password', [AdminAuthController::class, 'forgotPassword'])->name('admin.forgot-password');
  });



require __DIR__.'/auth.php';
/** Show Home page */
Route::get('/', [FrontendController::class, 'index'])->name('home');

/** Newsletter Routes */
Route::post('/subscribe-newsletter', [FrontendController::class, 'subscribeNewsletter'])->name('subscribe-newsletter');