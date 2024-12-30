<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PostController;
use App\Http\Controllers\Frontend\SearchController;
use App\Http\Controllers\Auth\SocialLoginController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\CategoryController;
use App\Http\Controllers\Frontend\NewsSubscriberController;
use App\Http\Controllers\Frontend\Dashboard\ProfileController;
use App\Http\Controllers\Frontend\Dashboard\SettingController;
use App\Http\Controllers\Frontend\Dashboard\NotificationController;

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


Route::group([
    'as' => 'frontend.',
], function () {
    Route::fallback(function () {
        return abort(404);
    });

    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::post('news-subscribe', [NewsSubscriberController::class, 'store'])->name('news.subscribe');
    Route::get('category/{slug}', [CategoryController::class, 'getPosts'])->name('category.posts');

    Route::controller(PostController::class)->name('post.')->prefix('posts')->group(function () {
        Route::get('/{slug}', 'showSinglePost')->name('show');
        Route::get('/comments/{slug}', 'getAllComments')->name('getAllComments');
        Route::post('/comments/store', 'saveComment')->name('comment.store');
    });

    Route::controller(ContactController::class)->name('contact.')->prefix('contact-us')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
    });
    Route::match(['post', 'get'], 'search', [SearchController::class, 'index'])->name('search.index');

    Route::prefix('account/')->name('dashboard.')->middleware(['auth:web', 'verified', 'CheckUserStatus', 'CheckUserData'])->group(function () {
        Route::controller(ProfileController::class)->group(function () {
            Route::get('profile', 'index')->name('profile');
            Route::post('post/store', 'storePost')->name('post.store');
            Route::delete('post/delete', 'deletePost')->name('post.delete');

            Route::get('post/{slug}/edit', 'editPost')->name('post.edit');
            Route::put('post/update', 'updatePost')->name('post.update');

            Route::get('post/get-comments/{id}', 'getComments')->name('post.getComments');
            Route::post('post/image/delete/{image_id}', 'deletePostImage')->name('post.image.delete');
        });

        Route::prefix('setting/')->controller(SettingController::class)->group(function () {
            Route::get('', 'index')->name('setting');
            Route::post('update', 'update')->name('setting.update');
            Route::post('change-password', 'changePassword')->name('setting.changePassword');
        });

        Route::prefix('notifications/')->controller(NotificationController::class)->group(function () {
            Route::get('', 'index')->name('notifications');
            Route::post('delete', 'delete')->name('notifications.delete');
            Route::post('delete-all', 'deleteAll')->name('notifications.deleteAll');
            Route::get('read-all', 'readAll')->name('notifications.readAll');
        });
    });

    Route::get('wait', function () {
        return view('frontend.wait');
    })->name('wait');
});


// Route::get('test', function () {
//     return 'aaaaa';
// })->middleware('throttle:test');

Auth::routes();

Route::get('auth/{provider}/redirect', [SocialLoginController::class, 'redirect'])->name('auth.socilate.redirect');
Route::get('auth/{provider}/callback', [SocialLoginController::class, 'callback'])->name('auth.socilate.callback');
