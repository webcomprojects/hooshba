<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommitteeController;
use App\Http\Controllers\ProvinceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::middleware('throttle:100,1')->group(function () {
    // اینجا درخواست‌ها محدود به 100 درخواست در دقیقه می‌شوند
});


Route::post('/resend-verification-code', [AuthController::class, 'resendVerificationCode']);
Route::post('/send-verification-code', [AuthController::class, 'sendVerificationCode']);
Route::post('/verify-code', [AuthController::class, 'verifyCode']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// front side
Route::get('posts/front-all-posts', [PostController::class, 'frontAllPosts']);
Route::get('posts/front-single-post', [PostController::class, 'frontSinglePost']);

Route::get('committees/front-all-committees', [CommitteeController::class, 'frontAllCommittees']);
Route::get('committees/front-single-committee', [CommitteeController::class, 'frontSingleCommittee']);

Route::get('categories/front-all-categories', [CategoryController::class, 'frontAllCategories']);
Route::get('categories/front-single-category', [CategoryController::class, 'frontSingleCategory']);

Route::get('province/front-all-provinces', [ProvinceController::class, 'frontAllProvinces']);
Route::get('province/front-single-province', [ProvinceController::class, 'frontSingleProvince']);

// admin panel
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/authentication', [AuthController::class, 'authentication']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('posts/published', [PostController::class, 'published']);
    Route::get('posts/draft', [PostController::class, 'draft']);
    Route::apiResource('posts', PostController::class);

    Route::get('committees/published', [CommitteeController::class, 'published']);
    Route::get('committees/draft', [CommitteeController::class, 'draft']);
    Route::apiResource('committees', CommitteeController::class);

    Route::get('provinces/published', [ProvinceController::class, 'published']);
    Route::get('provinces/draft', [ProvinceController::class, 'draft']);
    Route::apiResource('provinces', ProvinceController::class);

    Route::apiResource('categories', CategoryController::class);


});





