<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\Back\AdminCategoriesController;
use App\Http\Controllers\Back\AdminCommitteeController;
use App\Http\Controllers\Back\AdminDashboardController;
use App\Http\Controllers\Back\AdminFooterLinksController;
use App\Http\Controllers\Back\AdminGoalsController;
use App\Http\Controllers\Back\AdminIntroductionController;
use App\Http\Controllers\Back\AdminMemberController;
use App\Http\Controllers\Back\AdminOrganizationChartController;
use App\Http\Controllers\Back\AdminPlansController;
use App\Http\Controllers\Back\AdminPostController;
use App\Http\Controllers\Back\AdminProvinceController;
use App\Http\Controllers\Back\AdminRegionController;
use App\Http\Controllers\Back\AdminRoleController;
use App\Http\Controllers\Back\AdminSettingsController;
use App\Http\Controllers\Back\AdminUserController;
use App\Http\Controllers\Back\UserController;
use App\Http\Controllers\Front\CommitteeController;
use App\Http\Controllers\Front\CouncilMembersController;
use App\Http\Controllers\Front\GoalsController;
use App\Http\Controllers\Front\IntroductionController;
use App\Http\Controllers\Front\MainController;
use App\Http\Controllers\Front\MembershipController;
use App\Http\Controllers\Front\OrganizationChartController;
use App\Http\Controllers\Front\PlansController;
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

    Route::resource('membership', MembershipController::class)->only('index', 'store');
    Route::resource('blog', PostController::class);
    Route::resource('committees', CommitteeController::class);

    Route::resource('council-members', CouncilMembersController::class);

    Route::group(['as' => 'about-us.', 'prefix' => 'about-us/'], function () {
        Route::resource('organization-chart', OrganizationChartController::class);
        Route::resource('introduction', IntroductionController::class);
        Route::resource('goals', GoalsController::class);
        Route::resource('plans', PlansController::class);
    });
});

Route::group(['as' => 'back.', 'prefix' => 'admin/', 'middleware' => ['auth']], function () {
    // ------------------ MainController

    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', AdminUserController::class);
    Route::post('users/multipleDestroy', [AdminUserController::class, 'multipleDestroy'])->name('users.multipleDestroy');

    Route::resource('roles', AdminRoleController::class);
    Route::post('roles/multipleDestroy', [AdminRoleController::class, 'multipleDestroy'])->name('roles.multipleDestroy');

    Route::resource('posts', AdminPostController::class);
    Route::get('post/categories', [AdminPostController::class, 'categories'])->name('posts.categories');
    Route::post('posts/multipleDestroy', [AdminPostController::class, 'multipleDestroy'])->name('posts.multipleDestroy');

    Route::resource('committees', AdminCommitteeController::class);
    Route::get('committee/categories', [AdminCommitteeController::class, 'categories'])->name('committees.categories');
    Route::post('committees/multipleDestroy', [AdminCommitteeController::class, 'multipleDestroy'])->name('committees.multipleDestroy');

    Route::resource('regions', AdminRegionController::class);
    Route::post('regions/multipleDestroy', [AdminRegionController::class, 'multipleDestroy'])->name('regions.multipleDestroy');

    Route::resource('provinces', AdminProvinceController::class);
    Route::post('provinces/multipleDestroy', [AdminProvinceController::class, 'multipleDestroy'])->name('provinces.multipleDestroy');


    Route::resource('members', AdminMemberController::class);
    Route::get('member/categories', [AdminMemberController::class, 'categories'])->name('members.categories');
    Route::post('members/multipleDestroy', [AdminMemberController::class, 'multipleDestroy'])->name('members.multipleDestroy');

    Route::resource('categories', AdminCategoriesController::class);
    Route::post('categories/update-ordering', [AdminCategoriesController::class, 'updateOrdering']);

    Route::group(['as' => 'settings.', 'prefix' => 'settings/'], function () {

        Route::get('information', [AdminSettingsController::class, 'information'])->name('information.index');
        Route::post('information', [AdminSettingsController::class, 'information_store'])->name('information.store');

        Route::get('socials', [AdminSettingsController::class, 'socials'])->name('socials.index');
        Route::post('socials', [AdminSettingsController::class, 'socials_store'])->name('socials.store');

        Route::resource('footerlinks', AdminFooterLinksController::class);

        Route::get('footerlink/groups', [AdminFooterLinksController::class, 'footerLinks_groups'])->name('footerlinks.groups.index');
        Route::post('footerlink/groups', [AdminFooterLinksController::class, 'footerLinks_groups_store'])->name('footerlinks.groups.store');
    });


    Route::group(['as' => 'about-us.', 'prefix' => 'about-us/'], function () {
        Route::resource('organization-chart', AdminOrganizationChartController::class);
        Route::post('organization-chart/update-ordering', [AdminOrganizationChartController::class, 'updateOrdering']);

        Route::resource('introduction', AdminIntroductionController::class);
        Route::resource('goals', AdminGoalsController::class);
        Route::resource('plans', AdminPlansController::class);
    });
    //Route::get('get-tags', [AdminRoleController::class, 'get_tags'])->name('get-tags');

    Route::get('/get-new-captcha', [MainController::class, 'captcha']);

    // Route::resource('/membership', MembershipController::class)->only('index','store');
    // Route::resource('/blog', PostController::class);



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
Route::post('/login', [AuthenticationController::class, 'login'])->name('login');
Route::post('/sendVerificationCode', [AuthenticationController::class, 'sendVerificationCode'])->name('sendVerificationCode');
Route::get('/verifyCode', [AuthenticationController::class, 'verifyCode'])->name('verifyCode');
Route::post('/verifyCode', [AuthenticationController::class, 'verifyCodeCheck'])->name('verifyCodeCheck');
Route::get('/register-userInfo', [AuthenticationController::class, 'registerUserInfo'])->name('registerUserInfo');
Route::post('/register-userInfo', [AuthenticationController::class, 'registerUserInfoStore'])->name('registerUserInfoStore');
Route::get('/logout', [AdminUserController::class, 'logout']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('refresh-csrf', function () {
    return csrf_token();
})->name('csrf');
