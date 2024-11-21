<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
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

// admin panel
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/authentication', [AuthController::class, 'authentication']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('posts/published', [PostController::class, 'published']);
    Route::get('posts/draft', [PostController::class, 'draft']);
    Route::apiResource('posts', PostController::class);
    Route::apiResource('categories', CategoryController::class);
});

