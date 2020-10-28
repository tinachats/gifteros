<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Gifts;
use App\Http\Controllers\Search;
use App\Http\Controllers\Categories;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Wishlist;
use App\Http\Controllers\Users;
use App\Http\Controllers\MailingList;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Gift Routes
Route::get('/', [Gifts::class, 'index'])->name('index');
Route::post('/showcase', [Gifts::class, 'showcase'])->name('showcase');
Route::get('/details/{slug}/{id}', [Gifts::class, 'show'])->name('details.show');
Route::get('/search', [Search::class, 'fetch'])->name('search.fetch');
Route::get('/category/{category_id}/{category}', [Gifts::class, 'category'])->name('category');

// Cart Routes
Route::post('/', [CartController::class, 'store'])->name('purchase');
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');

// Wishlist Routes
Route::get('/wishlist', [Wishlist::class, 'index'])->name('wishlist');
Route::post('/wishlist/display', [Wishlist::class, 'display'])->name('wishlist.display');

// Login Routes
Auth::routes();
Route::get('login/facebook', [LoginController::class, 'redirectToProvider']);
Route::get('login/facebook/callback', [LoginController::class, 'handleProviderCallback']);

// User Actions
Route::post('/user_info', [Users::class, 'user_info'])->name('user_info');
Route::post('/profile_pic', [Users::class, 'profile_pic'])->name('profile_pic');
Route::post('/cover_page', [Users::class, 'cover_page'])->name('cover_page');
Route::post('/account/update', [Users::class, 'update_profile'])->name('update_profile');
Route::post('/account/check_password', [Users::class, 'check_password'])->name('check_password');
Route::post('/account/change_password', [Users::class, 'change_password'])->name('change_password');
Route::post('/wish', [Users::class, 'wish'])->name('wish');
Route::post('/unwish', [Users::class, 'unwish'])->name('unwish');

// Account Routes
Route::get('/account/{name}', [AccountController::class, 'index'])->name('account');
Route::post('/account/data', [AccountController::class, 'profile'])->name('profile');

// Mailing list
Route::post('/maiing_list', [MailingList::class, 'index'])->name('mailing_list');
Route::post('/subscribe', [MailingList::class, 'subscribe'])->name('subscribe');
Route::post('/unsubscribe', [MailingList::class, 'unsubscribe'])->name('unsubscribe');

// Blog Routes
Route::resource('blog', 'App\Http\Controllers\BlogPostController');
