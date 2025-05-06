<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\CommitteeController;
use App\Http\Controllers\Api\ProvinceController;
use App\Http\Controllers\Api\MemberController;
use App\Http\Controllers\Api\MembershipController;
use App\Http\Controllers\Api\RegionController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PageController;
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
Route::post('/register/expert', [AuthController::class, 'register_expert']);
Route::post('/login', [AuthController::class, 'login']);

// front side
Route::get('posts/front-all-posts', [PostController::class, 'frontAllPosts']);
Route::get('posts/front-single-post', [PostController::class, 'frontSinglePost']);

Route::get('pages/front-all-pages', [PageController::class, 'frontAllPages']);
Route::get('pages/front-single-page', [PageController::class, 'frontSinglePage']);

Route::get('committees/front-all-committees', [CommitteeController::class, 'frontAllCommittees']);
Route::get('committees/front-single-committee', [CommitteeController::class, 'frontSingleCommittee']);

Route::get('categories/front-all-categories', [CategoryController::class, 'frontAllCategories']);
Route::get('categories/front-single-category', [CategoryController::class, 'frontSingleCategory']);

Route::get('regions/front-all-regions', [RegionController::class, 'frontAllRegions']);
Route::get('regions/front-single-region', [RegionController::class, 'frontSingleRegion']);

Route::get('province/front-all-provinces', [ProvinceController::class, 'frontAllProvinces']);
Route::get('province/front-single-province', [ProvinceController::class, 'frontSingleProvince']);

Route::get('members/front-all-members', [MemberController::class, 'frontAllMembers']);
Route::get('members/front-single-member', [MemberController::class, 'frontSingleMember']);

Route::post('/membership', [MembershipController::class, 'store']);

// admin panel
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/authentication', [AuthController::class, 'authentication']);

    Route::get('posts/published', [PostController::class, 'published']);
    Route::get('posts/draft', [PostController::class, 'draft']);
    Route::post('posts/{id}/edit', [PostController::class, 'update']);
    Route::apiResource('posts', PostController::class);

    Route::get('pages/published', [PageController::class, 'published']);
    Route::get('pages/draft', [PageController::class, 'draft']);
    Route::post('pages/{id}/edit', [PageController::class, 'update']);
    Route::apiResource('pages', PageController::class);

    Route::get('committees/published', [CommitteeController::class, 'published']);
    Route::get('committees/draft', [CommitteeController::class, 'draft']);
    Route::apiResource('committees', CommitteeController::class);

    Route::get('provinces/published', [ProvinceController::class, 'published']);
    Route::apiResource('provinces', ProvinceController::class);

    Route::get('regions/published', [RegionController::class, 'published']);
    Route::apiResource('regions', RegionController::class);

    Route::apiResource('categories', CategoryController::class);

    Route::get('members/published', [MemberController::class, 'published']);
    Route::apiResource('members', MemberController::class);

    Route::get('all-roles', [MemberController::class, 'getAllRoles']);
    Route::apiResource('roles', RoleController::class);

    Route::get('all-permissions', [PermissionController::class, 'getAllPermissions']);
    Route::apiResource('permissions', PermissionController::class)->only(['index', 'show']);

    Route::apiResource('users', UserController::class);

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/experts/list', [AuthController::class, 'experts_list']);

});





