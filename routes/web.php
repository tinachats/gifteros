<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Gifts;
use App\Http\Controllers\Search;
use App\Http\Controllers\Categories;
use App\Http\Controllers\AccountController;

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
Route::get('/shop', [Gifts::class, 'shop'])->name('index.shop');
Route::get('/details/{slug}/{id}', [Gifts::class, 'show'])->name('details.show');
Route::get('/search', [Search::class, 'fetch'])->name('search.fetch');
Route::get('/category/{category_id}/{category}', [Gifts::class, 'category'])->name('category');

Auth::routes();

// Account Routes
Route::get('login/facebook', [LoginController::class, 'redirectToProvider']);
Route::get('login/facebook/callback', [LoginController::class, 'handleProviderCallback']);
Route::get('/account', [AccountController::class, 'index'])->name('account');

// Blog Routes
Route::resource('blog', 'App\Http\Controllers\BlogPostController');
