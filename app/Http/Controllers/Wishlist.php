<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Wishlist extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $count = DB::table('wishlist')
                    ->join('gifts', 'gifts.id', '=', 'wishlist.gift_id')
                    ->join('users', 'users.id', '=', 'wishlist.user_id')
                    ->where('users.id', Auth::user()->id)
                    ->count();
        $title = 'Gifteros | My Wishlist ('.$count.')';
        $data = [
            'title'             => $title,
            'count_wishlist'    => $count
        ];
        return view('wishlist.index')->with($data);
    }

    /**
     * Display the user's wishlisted gifts.
     */
    public function display(Request $request)
    {
        if($request->ajax()){
            if($request->action){
                $saved_gifts = $output = '';
                $wishlist = DB::table('wishlist')
                        ->join('gifts', 'gifts.id', '=', 'wishlist.gift_id')
                        ->join('categories', 'categories.id', '=', 'gifts.category_id')
                        ->join('users', 'users.id', '=', 'wishlist.user_id')
                        ->where('users.id', Auth::user()->id)
                        ->orderBy('usd_price', 'asc')
                        ->get();
                $count = $wishlist->count();
                if($count > 0){
                    if($count == 1){
                        $saved_gifts = '
                            <i class="material-icons text-warning">favorite</i>
                            <div class="text-sm font-500 ml-1">
                                1 gift saved
                            </div>
                        ';
                    } else {
                        $saved_gifts = '
                            <i class="material-icons text-warning">favorite</i>
                            <div class="text-sm font-500 ml-1">
                                '.$count.' gifts saved
                            </div>
                        ';
                    }
                    $output .= '
                        <div class="d-grid grid-view grid-p-1 products-shelf mt-3">
                    ';
                    foreach($wishlist as $gift){
                        // Gift star rating
                        $star_rating = giftStarRating($gift->gift_id);
                        $usd_before = number_format(($gift->usd_price + ($gift->usd_price * 0.275)), 2); 
                        $zar_before = number_format(($gift->zar_price + ($gift->zar_price * 0.275)), 2);
                        $zwl_before = number_format(($gift->zwl_price + ($gift->zwl_price * 0.275)), 2);
                        $short_name = mb_strimwidth($gift->gift_name, 0, 15, '...');

                        if(isset(Auth::user()->id)){
                            $wishlist_icon = wishlistIcon($gift->gift_id, Auth::user()->id);
                        } else {
                            $wishlist_icon = '
                                <span role="button" class="material-icons text-warning guest-wishes" id="'. $gift->gift_id .'" data-name="'. $gift->gift_name .'">favorite_border</span>
                            ';
                        }
                        $output .= '
                            <!-- Product Card -->
                            <div class="card product-card border-0 rounded-0 box-shadow-sm">
                                <div class="product-img-wrapper">
                                    '. giftLabel($gift->gift_id) .'
                                    <a href="details/'. $gift->slug .'/'. $gift->gift_id .'" title="View product">
                                        <img src="/storage/gifts/'. $gift->gift_image .'" alt="'. $gift->gift_name .'" height="200" class="card-img-top rounded-0">
                                    </a>
                                    <div class="overlay py-1 px-2">
                                        <div class="d-flex align-items-center">
                                            <a href="/details/'. $gift->slug .'/'. $gift->gift_id .'" class="d-flex align-items-center">
                                                <img role="button" src="/storage/gifts/'. $gift->gift_image .'" height="30" width="30" alt="'. $gift->gift_name .'" class="rounded-circle">
                                            </a>
                                            <div class="d-flex align-items-center ml-auto mr-2" title="'. giftsSold($gift->gift_id) .' gift(s) sold">
                                                <span role="button" class="material-icons overlay-icon">add_shopping_cart</span>
                                                <small class="text-light d-list-grid">'. giftsSold($gift->gift_id) .'</small>
                                            </div>
                                            <div class="d-flex align-items-center" title="Add to Wishlist">
                                                '. $wishlist_icon .'
                                                <small class="text-light d-list-grid">'. totalWishes($gift->gift_id) .'</small>
                                            </div>
                                            <a href="/details/'. $gift->slug .'/'. $gift->gift_id .'" class="d-flex align-items-center ml-2" title="See Reviews">
                                                <span role="button" class="material-icons overlay-icon">forum</span>
                                                <small class="text-light d-list-grid">'. countRatings($gift->gift_id) .'</small>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <div class="card-body my-0 py-0">
                                        <div class="lh-100">
                                            <a href="/details/'. $gift->slug .'/'. $gift->gift_id .'">
                                                <p class="font-600 text-capitalize mt-1 mb-0 py-0 product-name popover-info" id="'. $gift->gift_id .'">
                                                    '. mb_strimwidth($gift->gift_name, 0, 25, '...') .'
                                                </p>
                                            </a>
                                            <a href="/category/'. $gift->category_name .'" class="text-sm font-500 text-capitalize my-0 py-0">
                                                '. $gift->category_name .'
                                            </a>
                                            '. $star_rating .'
                                        </div>
                                        <p class="product-description text-sm font-500 text-faded text-justify my-0 py-0">
                                            '. mb_strimwidth($gift->description, 0, 70, '...') .'
                                        </p>
                                        <input value="'. $gift->gift_id .'" id="product_id" type="hidden">
                                        <input value="'. $gift->gift_name .'" id="name'. $gift->gift_id .'" type="hidden">
                                        <input value="'. $gift->label .'" id="label'. $gift->gift_id .'" type="hidden">
                                        <input value="'. $gift->gift_image .'" id="image'. $gift->gift_id .'" type="hidden">
                                        <input value="'. $gift->usd_price .'" id="usd-price'. $gift->gift_id .'" type="hidden">
                                        <input value="'. $gift->zar_price .'" id="zar-price'. $gift->gift_id .'" type="hidden">
                                        <input value="'. $gift->zwl_price .'" id="zwl-price'. $gift->gift_id .'" type="hidden">
                                        <input value="'. $gift->sale_usd_price .'" id="sale-usd-price'. $gift->gift_id .'" type="hidden">
                                        <input value="'. $gift->sale_zar_price .'" id="sale-zar-price'. $gift->gift_id .'" type="hidden">
                                        <input value="'. $gift->sale_zwl_price .'" id="sale-zwl-price'. $gift->gift_id .'" type="hidden">
                                        <input value="'. $gift->custom_usd_price .'" id="customizing-usd-cost'. $gift->gift_id .'" type="hidden">
                                        <input value="'. $gift->custom_zar_price .'" id="customizing-zar-cost'. $gift->gift_id .'" type="hidden">
                                        <input value="'. $gift->custom_zwl_price .'" id="customizing-zwl-cost'. $gift->gift_id .'" type="hidden">
                                        <input value="'. $gift->ends_on .'" id="end-time'. $gift->gift_id .'" type="hidden">
                                        <input value="'. $gift->category_name .'" id="category-name'. $gift->gift_id .'" type="hidden">
                                        <input value="'. $gift->units .'" id="product-units'. $gift->gift_id .'" type="hidden">
                                        <input value="1" id="quantity'. $gift->gift_id .'" type="hidden">
                                        <input type="hidden" id="sale-end-date" value="'. date('y, m, d, h, m, s', strtotime($gift->ends_on)) .'">
                                        <input value="'. $gift->description .'" id="description'. $gift->gift_id .'" type="hidden">
                                        
                                        <div class="usd-price">
                                            <div class="d-flex align-items-center justify-content-between mt-1">
                                                <span class="font-600">US$<span class="product-price">'. number_format($gift->usd_price, 2) .'</span></span>
                                                <div class="d-flex align-items-center before-prices">
                                                    <span class="font-600 text-muted strikethrough ml-1">US$'. $usd_before .'</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="zar-price d-none">
                                            <div class="d-flex align-items-center justify-content-between mt-1">
                                                <span class="font-600">R<span class="product-price">'. number_format($gift->zar_price, 2) .'</span></span>
                                                <div class="d-flex align-items-center before-prices">
                                                    <span class="font-600 text-muted strikethrough ml-1">R'. $zar_before .'</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="zwl-price d-none">
                                            <div class="d-flex align-items-center justify-content-between mt-1">
                                                <span class="font-600">ZW$<span class="product-price">'. number_format($gift->zwl_price, 2) .'</span></span>
                                                <div class="d-flex align-items-center before-prices">
                                                    <span class="font-600 text-muted strikethrough ml-1">$'. $zwl_before .'</span>
                                                </div>
                                            </div>
                                        </div>
            
                                        <div class="text-center w-100 mx-0 px-0 mb-1">
                                            <div class="btn-group btn-group-sm mt-0 pt-0 product-card-btns pulse">
                                                <button class="btn btn-primary btn-sm d-flex align-items-center justify-content-center add-to-cart-btn font-600 rounded-left" data-id="'. $gift->gift_id .'">
                                                    <i class="material-icons text-white mr-1">add_shopping_cart</i>
                                                    Buy <span class="text-white text-white ml-1">gift</span>
                                                </button>
                                                <button class="btn border-primary btn-sm text-primary compare-btn d-flex align-items-center justify-content-center font-600 rounded-right" id="compare-btn'. $gift->gift_id .'" data-name="'. $short_name .'" data-id="'. $gift->gift_id .'">
                                                    <i class="material-icons text-primary mr-1">compare_arrows</i>
                                                    Compare
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.Product Card -->
                        ';
                    }
                    $output .= '</div>';
                } else {
                    $saved_gifts = '
                        <i class="material-icons text-faded">favorite_border</i>
                        <div class="text-sm font-500 ml-1">
                            0 gifts saved
                        </div>
                    ';
                    $output = '
                        <div class="container my-5">
                            <div class="row justify-content-center">
                                <div class="col-10 col-md-7 text-center no-content">
                                    <i class="icon-lg material-icons text-muted">assignment</i>
                                    <h6 class="lead text-muted font-600">There are no gifts in your wishlist at the moment.</h6>
                                    <p class="text-justify text-muted">
                                        Your wishlist serves for a purpose. This is the list of gifts you wish to buy later, it 
                                        might be <a href="/category/27/flowers">flowers</a>, <a href="/category/8/appliances">appliances</a>, 
                                        <a href="/category/9/kitchenware">kitchenware</a> and more...
                                    </p>
                                </div>
                            </div>
                        </div>
                    ';
                }
                return response()->json([
                    'saved_gifts' => $saved_gifts,
                    'wishlist'    => $output
                ]);
            }
        }
    }
}
