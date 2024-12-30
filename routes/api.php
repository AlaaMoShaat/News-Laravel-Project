<?php

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\GeneralController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Account\PostController;
use App\Http\Controllers\Api\RelatedSitesController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\PublicSettingController;
use App\Http\Controllers\Api\Account\SettingController;
use App\Http\Controllers\Api\Auth\VerifyEmailController;
use App\Http\Controllers\Api\Account\NotificationController;
use App\Http\Controllers\Api\Auth\Password\ResetPasswordController;
use App\Http\Controllers\Api\Auth\Password\ForogtPasswordController;

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


// **************************** Auth Register *********************************
Route::middleware('throttle:register')->post('auth/register', [RegisterController::class, 'register']);

// ***************************** Forogt Password  ***********************************
Route::controller(ForogtPasswordController::class)->group(function () {
    Route::post('password/email', 'sendCode');
});
// ***************************** Reset Password  ***********************************
Route::controller(ResetPasswordController::class)->group(function () {
    Route::post('password/reset', 'resetPassword');
});

// ***************************** Auth Login ***********************************
Route::controller(LoginController::class)->group(function () {
    Route::post('auth/login', 'login');
    Route::delete('auth/logout', 'logout')->middleware('auth:sanctum');
});


// ***************************** Verify Email **********************************
Route::middleware('auth:sanctum')->controller(VerifyEmailController::class)->group(function () {
    Route::post('auth/email/verify', 'verifyEmail');
    Route::get('auth/email/verify', 'sendCodeAgain');
});

//********************* User Account Page Routes **********************************
Route::middleware(['auth:sanctum', 'CheckEmailVerifyApi', 'CheckUserStatus', 'CheckUserData'])->prefix('account')->group(function () {
    Route::get('user', function () {
        return UserResource::make(auth()->user());
    });

    Route::put('setting/{user_id}', [SettingController::class, 'updateSetting']);
    Route::put('password/{user_id}', [SettingController::class, 'updatePassword']);

    Route::controller(PostController::class)->prefix('user-posts')->group(function () {
        Route::get('/',                      'getUserPosts');
        Route::post('/store',                'storeUserPost');
        Route::delete('/destroy/{post_id}',  'destroyUserPost');
        Route::put('/update/{post_id}',      'updateUserPost');

        Route::get('/comments/{post_id}',    'getPostComments');
        Route::post('/comments/store',       'StoreComment')->middleware('throttle:comments');
    });

    Route::get('notifications', [NotificationController::class, 'getNotifications']);
    Route::get('notifications/read/{id}', [NotificationController::class, 'readNotifications']);
});



//********************* Home Page Routes **********************************
Route::controller(GeneralController::class)->group(function () {
    Route::get('posts',                      'getPosts');
    Route::get('posts/search/{keyword?}',    'getPosts');
    Route::get('posts/show/{slug}',          'showPost');
    Route::get('posts/comments/{slug}',      'getPostComments');
});

// *************************** Categories Routes  **********************************
Route::controller(CategoryController::class)->group(function () {
    Route::get('categories',              'getCategories');
    Route::get('categories/{slug}/posts', 'getCategoryPosts');
});

// ***************************** Contact Routes **********************************
Route::post('contacts/store',          [ContactController::class, 'storeContact'])->middleware('throttle:contact');

// ***************************** RelatedSites Routes **********************************
Route::get('related-sites',             RelatedSitesController::class);

// *****************************  Settings Routes  **********************************
Route::get('settings',                  [PublicSettingController::class, 'getSettings']);
