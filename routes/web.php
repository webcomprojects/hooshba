<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\Back\AdminDashboardController;
use App\Http\Controllers\Back\AdminUserController;
use App\Http\Controllers\Back\UserController;
use App\Http\Controllers\Front\AdminPostController;
use App\Http\Controllers\Front\MainController;
use App\Http\Controllers\Front\MembershipController;
use App\Http\Controllers\Front\PostController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::group(['as' => 'front.'], function () {
    // ------------------ MainController
    Route::get('/', [MainController::class, 'index'])->name('index');
    Route::get('/get-new-captcha', [MainController::class, 'captcha']);

    Route::resource('/membership', MembershipController::class)->only('index','store');
    Route::resource('/blog', PostController::class);


});

Route::group(['as' => 'back.','prefix' => 'admin/' ], function () {
    // ------------------ MainController

    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', AdminUserController::class);
    Route::resource('posts', AdminPostController::class);
    Route::get('/get-new-captcha', [MainController::class, 'captcha']);

    Route::resource('/membership', MembershipController::class)->only('index','store');
    Route::resource('/blog', PostController::class);


});

Route::get('/clear-cache', function () {
    // پاک کردن کش‌های Laravel
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('permission:cache-reset');

    return "تمام کش‌ها با موفقیت پاک شدند!";
});


Auth::routes();
Route::post('/login',[AuthenticationController::class,'login'])->name('login');
Route::post('/sendVerificationCode',[AuthenticationController::class,'sendVerificationCode'])->name('sendVerificationCode');
Route::get('/verifyCode',[AuthenticationController::class,'verifyCode'])->name('verifyCode');
Route::post('/verifyCode',[AuthenticationController::class,'verifyCodeCheck'])->name('verifyCodeCheck');
Route::get('/register-userInfo',[AuthenticationController::class,'registerUserInfo'])->name('registerUserInfo');
Route::post('/register-userInfo',[AuthenticationController::class,'registerUserInfoStore'])->name('registerUserInfoStore');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
