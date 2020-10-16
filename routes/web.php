<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Gifts;
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

Auth::routes();

// Account Routes
Route::get('login/facebook', [LoginController::class, 'redirectToProvider']);
Route::get('login/facebook/callback', [LoginController::class, 'handleProviderCallback']);
Route::get('/account', [AccountController::class, 'index'])->name('account');

// Blog Routes
Route::resource('blog_posts', 'App\Http\Controllers\BlogPostController');
