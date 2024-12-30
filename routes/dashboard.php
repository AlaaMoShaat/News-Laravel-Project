<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Notifications\ResetPassword;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\Post\PostController;
use App\Http\Controllers\Dashboard\User\UserController;
use App\Http\Controllers\Dashboard\Auth\LoginController;
use App\Http\Controllers\Dashboard\Admin\AdminController;
use App\Http\Controllers\Dashboard\GereralSearchController;
use App\Http\Controllers\Dashboard\Contact\ContactController;
use App\Http\Controllers\Dashboard\Profile\ProfileController;
use App\Http\Controllers\Dashboard\Setting\SettingController;
use App\Http\Controllers\Dashboard\Category\CategoryController;
use App\Http\Controllers\Dashboard\Setting\RelatedSiteController;
use App\Http\Controllers\Dashboard\Notification\NotificationController;
use App\Http\Controllers\Dashboard\Auth\Password\ResetPasswordController;
use App\Http\Controllers\Dashboard\Authorization\AuthorizationController;
use App\Http\Controllers\Dashboard\Auth\Password\ForgetPasswordController;

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

// Auth Admin
Route::group([
    'prefix' => 'dashboard',
    'as' => 'dashboard.',

], function () {
    Route::fallback(function () {
        return abort(404);
    });
    Route::controller(LoginController::class)->group(function () {
        Route::get('login', 'showLoginForm')->name('login.show');
        Route::post('login/check', 'checkAuth')->name('login.check');
        Route::post('logout', 'logout')->name('logout');
    });

    Route::prefix('password')->as('password.')->group(function () {
        Route::controller(ForgetPasswordController::class)->group(function () {
            Route::get('email', 'showEmailForm')->name('email');
            Route::post('email', 'sendCode')->name('sendCode');
            Route::get('verify/{email}', 'showCodeForm')->name('showCodeForm');
            Route::post('verify', 'verifyCode')->name('verifyCode');
        });
        Route::controller(ResetPasswordController::class)->group(function () {
            Route::get('reset/{email}', 'showResetForm')->name('showResetForm');
            Route::post('reset', 'resetPassword')->name('reset');
        });
    });
});


Route::group([
    'prefix' => 'dashboard',
    'as' => 'dashboard.',
    'middleware' => ['auth:admin', 'CheckAdminStatus']
], function () {
    Route::fallback(function () {
        return abort(404);
    });

    Route::get('home', [HomeController::class, 'index'])->name('home');

    //******************** Generl Search Routes **************************
    Route::get('search', [GereralSearchController::class, 'search'])->name('search');

    Route::resource('authorizations', AuthorizationController::class);
    Route::resource('users', UserController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('posts', PostController::class);
    Route::resource('admins', AdminController::class);
    Route::resource('related-site', RelatedSiteController::class);

    Route::post('posts/image/delete/{image_id}', [PostController::class,  'deletePostImage'])->name('posts.image.delete');
    Route::get('users/status/{id}', [UserController::class, 'changeStatus'])->name('users.changeStatus');
    Route::get('categories/status/{id}', [CategoryController::class, 'changeStatus'])->name('categories.changeStatus');
    Route::get('posts/status/{id}', [PostController::class, 'changeStatus'])->name('posts.changeStatus');
    Route::get('admins/status/{id}', [AdminController::class, 'changeStatus'])->name('admins.changeStatus');
    Route::delete('posts/comment/delete/{id}',      [PostController::class, 'deleteComment'])->name('posts.deleteComment');
    Route::patch('posts/comment/status/{id}', [PostController::class, 'changeCommentStatus'])->name('posts.changeCommentStatus');
    //******************** Profile Routes **************************
    Route::controller(ProfileController::class)->prefix('profile')->as('profile.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/update', 'update')->name('update');
    });
    //******************** contact Routes **************************
    Route::controller(ContactController::class)->prefix('contacts')->as('contacts.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show/{id}', 'show')->name('show');
        Route::delete('/destroy/{id}', 'destroy')->name('destroy');
    });
    //******************** Notifications Routes **************************
    Route::controller(NotificationController::class)->prefix('notifications')->as('notifications.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/destroy/{id}', 'destroy')->name('destroy');
        Route::get('/delete-all', 'deleteAll')->name('deleteAll');
    });

    Route::controller(SettingController::class)->prefix('settings')->as('settings.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/update', 'update')->name('update');
    });
});
Route::get('/dashboard/wait', function () {
    return view('dashboard.wait');
})->name('dashboard.wait');