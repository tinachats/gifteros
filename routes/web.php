<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AppRatings;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Categories;
use App\Http\Controllers\Developers;
use App\Http\Controllers\Gifts;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MailingList;
use App\Http\Controllers\Occasions;
use App\Http\Controllers\Orders;
use App\Http\Controllers\Search;
use App\Http\Controllers\SubCategories;
use App\Http\Controllers\UI;
use App\Http\Controllers\Users;
use App\Http\Controllers\Wishlist;

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

// App Functionality
Route::post('/keep-token-alive', function(){
    return 'Token must have been valid, and the session expiration has been extended.';
});
Route::post('/app_rating', [AppRatings::class, 'store'])->name('app_rating');

// UI Test Designs
Route::get('/category_ui', [UI::class, 'category_ui'])->name('category_ui');

// Gift Routes
Route::get('/', [Gifts::class, 'index'])->name('index');
Route::get('/showcase', [Gifts::class, 'showcase'])->name('showcase');
Route::get('/details/{slug}/{id}', [Gifts::class, 'show'])->name('details.show');
Route::post('/details/wishlist_btn', [Gifts::class, 'wishlist_btn'])->name('wishlist_btn');
Route::post('/details/gift_ratings', [Gifts::class, 'gift_ratings'])->name('gift_ratings');
Route::get('/search', [Search::class, 'fetch'])->name('search.fetch');

// Gift Comparisons
Route::post('/remove_comparison', [Gifts::class, 'remove_comparison'])->name('remove_comparison');
Route::post('/add_comparison', [Gifts::class, 'add_comparison'])->name('add_comparison');
Route::get('/clear_comparisons', [Gifts::class, 'clear_comparisons'])->name('clear_comparisons');
Route::get('/compare_page', [Gifts::class, 'compare_page'])->name('compare_page');

// Category Gifts
Route::get('/category/{category_id}/{category}', [Categories::class, 'index'])->name('gifts_category');
Route::get('/category/{occasion}', [Occasions::class, 'occasion'])->name('occasion');
Route::post('/category/gifts', [Categories::class, 'gifts'])->name('category_gifts');
Route::post('/category/filter_ratings', [Categories::class, 'filter_ratings'])->name('filter_ratings');
Route::post('/occasional_gifts', [Occasions::class, 'occasional_gifts'])->name('occasional_gifts');

// Sub-category Gifts
Route::get('/subcategory/{sub_category_id}/{subcategory}', [SubCategories::class, 'index'])->name('gifts_subcategory');
Route::post('/sub_category/gifts', [SubCategories::class, 'gifts'])->name('subcategory_gifts');

// Cart Routes
Route::get('/add_to_cart/{gift_id}', [CartController::class, 'addToCart'])->name('add_to_cart');
Route::get('/subtract_item/{gift_id}', [CartController::class, 'decreaseQty'])->name('subract-item');
Route::get('/remove_item/{gift_id}', [CartController::class, 'removeItem'])->name('remove-item');
Route::get('/shopping_cart', [CartController::class, 'shoppingCart'])->name('shopping_cart');
Route::get('/clear_cart', [CartController::class, 'clearCart'])->name('clear_cart');
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');

// Wishlist Routes
Route::get('/wishlist', [Wishlist::class, 'index'])->name('wishlist');
Route::get('/wishlist/display', [Wishlist::class, 'display'])->name('wishlist.display');

// Login Routes
Auth::routes();
Route::get('login/facebook', [LoginController::class, 'redirectToProvider']);
Route::get('login/facebook/callback', [LoginController::class, 'handleProviderCallback']);

// User Actions
Route::get('/user_info', [Users::class, 'user_info'])->name('user_info');
Route::post('/profile_pic', [Users::class, 'profile_pic'])->name('profile_pic');
Route::post('/cover_page', [Users::class, 'cover_page'])->name('cover_page');
Route::post('/account/update', [Users::class, 'update_profile'])->name('update_profile');
Route::post('/account/check_password', [Users::class, 'check_password'])->name('check_password');
Route::post('/account/change_password', [Users::class, 'change_password'])->name('change_password');
Route::post('/wish', [Users::class, 'wish'])->name('wish');
Route::post('/unwish', [Users::class, 'unwish'])->name('unwish');
Route::post('/gift_review', [Users::class, 'gift_review'])->name('gift_review');
Route::post('/helpful', [Users::class, 'helpful'])->name('helpful');
Route::post('/unhelpful', [Users::class, 'unhelpful'])->name('unhelpful');
Route::post('/like', [Users::class, 'like'])->name('like');
Route::post('/unlike', [Users::class, 'unlike'])->name('unlike');
Route::post('/review_comments', [Users::class, 'review_comments'])->name('review_comments');
Route::post('/submit_comment', [Users::class, 'submit_comment'])->name('submit_comment');
Route::get('/notifications', [Users::class, 'notifications'])->name('notifications');

// Account Routes
Route::get('/account/{name}', [AccountController::class, 'index'])->name('account');
Route::post('/account/data', [AccountController::class, 'profile'])->name('profile');

// Orders Page
Route::get('/orders', [Orders::class, 'index'])->name('orders');

// Mailing list
Route::post('/maiing_list', [MailingList::class, 'index'])->name('mailing_list');
Route::post('/subscribe', [MailingList::class, 'subscribe'])->name('subscribe');
Route::post('/unsubscribe', [MailingList::class, 'unsubscribe'])->name('unsubscribe');

// Blog Routes
Route::resource('blog', 'App\Http\Controllers\BlogPostController');

// Developer Page
Route::get('/developer/{name}', [Developers::class, 'index'])->name('developer');
