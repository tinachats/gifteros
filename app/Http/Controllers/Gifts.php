<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Gift;

class Gifts extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Gifteros | Find your perfect gift';
        $categories = DB::table('categories')
                        ->join('gifts', 'gifts.category_id', '=', 'categories.id')
                        ->select(
                            'categories.id', 'category_name', 
                            'image', 'category_slug'
                        )
                        ->orderBy('category_name', 'asc')
                        ->distinct()
                        ->get();
        $data = [
            'categories' => $categories,
            'title'      => $title
        ];
        return view('index')->with($data);
    }

    /**
     * Fetch all homepage gift categories in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function showcase(Request $request)
    {
        if($request->ajax()){
            if($request->action){
                $customized_gifts = $wishlist_icon = $kitchenware_gifts = '';
                $care_gifts = $plasticware_gifts = $combos = $appliance_gifts = '';
                $customizables = DB::table('gifts')
                                    ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                    ->select('gifts.*', 'categories.category_name')
                                    ->where('label', 'customizable')
                                    ->inRandomOrder()
                                    ->take(4)
                                    ->get();
                foreach($customizables as $gift){
                    // Gift star rating
                    $star_rating = giftStarRating($gift->id);
                    $usd_before = number_format(($gift->usd_price + ($gift->usd_price * 0.275)), 2); 
                    $zar_before = number_format(($gift->zar_price + ($gift->zar_price * 0.275)), 2);
                    $zwl_before = number_format(($gift->zwl_price + ($gift->zwl_price * 0.275)), 2);
                    $short_name = mb_strimwidth($gift->gift_name, 0, 15, '...');

                    if(isset(Auth::user()->id)){
                        $wishlist_icon = wishlistIcon($gift->id, Auth::user()->id);
                    } else {
                        $wishlist_icon = '
                            <span role="button" class="material-icons text-warning guest-wishes" id="'. $gift->id .'" data-name="'. $gift->gift_name .'">favorite_border</span>
                        ';
                    }

                    $customized_gifts .= '
                        <!-- Product Card -->
                        <div class="card product-card border-0 rounded-0 box-shadow-sm">
                            <div class="product-img-wrapper">
                                '. giftLabel($gift->id) .'
                                <a href="details/'. $gift->slug .'/'. $gift->id .'" title="View product">
                                    <img src="/storage/gifts/'. $gift->gift_image .'" alt="'. $gift->gift_name .'" height="200" class="card-img-top rounded-0">
                                </a>
                                <div class="overlay py-1 px-2">
                                    <div class="d-flex align-items-center">
                                        <a href="details/'. $gift->slug .'/'. $gift->id .'" class="d-flex align-items-center">
                                            <img role="button" src="/storage/gifts/'. $gift->gift_image .'" height="30" width="30" alt="'. $gift->gift_name .'" class="rounded-circle">
                                        </a>
                                        <div class="d-flex align-items-center ml-auto mr-2" title="'. giftsSold($gift->id) .' gift(s) sold">
                                            <span role="button" class="material-icons overlay-icon">add_shopping_cart</span>
                                            <small class="text-light d-list-grid">'. giftsSold($gift->id) .'</small>
                                        </div>
                                        <div class="d-flex align-items-center" title="Add to Wishlist">
                                            '. $wishlist_icon .'
                                            <small class="text-light d-list-grid">'. totalWishes($gift->id) .'</small>
                                        </div>
                                        <a href="details/'. $gift->slug .'/'. $gift->id .'" class="d-flex align-items-center ml-2" title="See Reviews">
                                            <span role="button" class="material-icons overlay-icon">forum</span>
                                            <small class="text-light d-list-grid">'. countRatings($gift->id) .'</small>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="card-body my-0 py-0">
                                    <div class="lh-100">
                                        <a href="details/'. $gift->slug .'/'. $gift->id .'">
                                            <p class="font-600 text-capitalize mt-1 mb-0 py-0 product-name popover-info" id="'. $gift->id .'">
                                                '. mb_strimwidth($gift->gift_name, 0, 25, '...') .'
                                            </p>
                                        </a>
                                        <a href="/category/'. $gift->category_name .'" class="text-sm font-500 text-capitalize my-0 py-0">
                                            '. $gift->category_name .'
                                        </a>
                                        '. $star_rating .'
                                    </div>
                                    <p class="product-description text-sm font-500 text-faded text-justify my-0 py-0">
                                        '. mb_strimwidth($gift->description, 0, 60, '...') .'
                                    </p>
                                    <input value="'. $gift->id .'" id="gift_id" type="hidden">
                                    <input value="'. $gift->gift_name .'" id="name'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->label .'" id="label'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->gift_image .'" id="image'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->usd_price .'" id="usd-price'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->zar_price .'" id="zar-price'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->zwl_price .'" id="zwl-price'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->sale_usd_price .'" id="sale-usd-price'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->sale_zar_price .'" id="sale-zar-price'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->sale_zwl_price .'" id="sale-zwl-price'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->custom_usd_price .'" id="customizing-usd-cost'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->custom_zar_price .'" id="customizing-zar-cost'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->custom_zwl_price .'" id="customizing-zwl-cost'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->ends_on .'" id="end-time'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->category_name .'" id="category-name'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->units .'" id="product-units'. $gift->id .'" type="hidden">
                                    <input value="1" id="quantity'. $gift->id .'" type="hidden">
                                    <input type="hidden" id="sale-end-date" value="'. date('y, m, d, h, m, s', strtotime($gift->ends_on)) .'">
                                    <input value="'. $gift->description .'" id="description'. $gift->id .'" type="hidden">
                                    
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
                                            <button class="btn btn-primary btn-sm d-flex align-items-center justify-content-center add-to-cart-btn font-600 rounded-left" data-id="'. $gift->id .'">
                                                <i class="material-icons text-white mr-1">add_shopping_cart</i>
                                                Buy <span class="text-white text-white ml-1">gift</span>
                                            </button>
                                            <button class="btn border-primary btn-sm text-primary compare-btn d-flex align-items-center justify-content-center font-600 rounded-right" id="compare-btn'. $gift->id .'" data-name="'. $short_name .'" data-id="'. $gift->id .'">
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
                $kitchenware = DB::table('gifts')
                                ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                ->select('gifts.*', 'categories.category_name')
                                ->where('category_id', 9)
                                ->inRandomOrder()
                                ->take(4)
                                ->get();
                foreach($kitchenware as $gift){
                    // Gift star rating
                    $star_rating = giftStarRating($gift->id);
                    $usd_before = number_format(($gift->usd_price + ($gift->usd_price * 0.275)), 2); 
                    $zar_before = number_format(($gift->zar_price + ($gift->zar_price * 0.275)), 2);
                    $zwl_before = number_format(($gift->zwl_price + ($gift->zwl_price * 0.275)), 2);
                    $short_name = mb_strimwidth($gift->gift_name, 0, 15, '...');

                    if(isset(Auth::user()->id)){
                        $wishlist_icon = wishlistIcon($gift->id, Auth::user()->id);
                    } else {
                        $wishlist_icon = '
                            <span role="button" class="material-icons text-warning guest-wishes" id="'. $gift->id .'" data-name="'. $gift->gift_name .'">favorite_border</span>
                        ';
                    }

                    $kitchenware_gifts .= '
                        <!-- Product Card -->
                        <div class="card product-card border-0 rounded-0 box-shadow-sm">
                            <div class="product-img-wrapper">
                                '. giftLabel($gift->id) .'
                                <a href="details/'. $gift->slug .'/'. $gift->id .'" title="View product">
                                    <img src="/storage/gifts/'. $gift->gift_image .'" alt="'. $gift->gift_name .'" height="200" class="card-img-top rounded-0">
                                </a>
                                 <div class="overlay py-1 px-2">
                                    <div class="d-flex align-items-center">
                                        <a href="details/'. $gift->slug .'/'. $gift->id .'" class="d-flex align-items-center">
                                            <img role="button" src="/storage/gifts/'. $gift->gift_image .'" height="30" width="30" alt="'. $gift->gift_name .'" class="rounded-circle">
                                        </a>
                                        <div class="d-flex align-items-center ml-auto mr-2" title="'. giftsSold($gift->id) .' gift(s) sold">
                                            <span role="button" class="material-icons overlay-icon">add_shopping_cart</span>
                                            <small class="text-light d-list-grid">'. giftsSold($gift->id) .'</small>
                                        </div>
                                        <div class="d-flex align-items-center" title="Add to Wishlist">
                                            '. $wishlist_icon .'
                                            <small class="text-light d-list-grid">'. totalWishes($gift->id) .'</small>
                                        </div>
                                        <a href="details/'. $gift->slug .'/'. $gift->id .'" class="d-flex align-items-center ml-2" title="See Reviews">
                                            <span role="button" class="material-icons overlay-icon">forum</span>
                                            <small class="text-light d-list-grid">'. countRatings($gift->id) .'</small>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="card-body my-0 py-0">
                                    <div class="lh-100">
                                        <a href="details/'. $gift->slug .'/'. $gift->id .'">
                                            <p class="font-600 text-capitalize mt-1 mb-0 py-0 product-name popover-info" id="'. $gift->id .'">
                                                '. mb_strimwidth($gift->gift_name, 0, 25, '...') .'
                                            </p>
                                        </a>
                                        <a href="/category/'. $gift->category_name .'" class="text-sm font-500 text-capitalize my-0 py-0">
                                            '. $gift->category_name .'
                                        </a>
                                        '. $star_rating .'
                                    </div>
                                    <p class="product-description text-sm font-500 text-faded text-justify my-0 py-0">
                                        '. mb_strimwidth($gift->description, 0, 60, '...') .'
                                    </p>
                                    <input value="'. $gift->id .'" id="gift_id" type="hidden">
                                    <input value="'. $gift->gift_name .'" id="name'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->label .'" id="label'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->gift_image .'" id="image'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->usd_price .'" id="usd-price'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->zar_price .'" id="zar-price'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->zwl_price .'" id="zwl-price'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->sale_usd_price .'" id="sale-usd-price'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->sale_zar_price .'" id="sale-zar-price'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->sale_zwl_price .'" id="sale-zwl-price'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->custom_usd_price .'" id="customizing-usd-cost'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->custom_zar_price .'" id="customizing-zar-cost'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->custom_zwl_price .'" id="customizing-zwl-cost'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->ends_on .'" id="end-time'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->category_name .'" id="category-name'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->units .'" id="product-units'. $gift->id .'" type="hidden">
                                    <input value="1" id="quantity'. $gift->id .'" type="hidden">
                                    <input type="hidden" id="sale-end-date" value="'. date('y, m, d, h, m, s', strtotime($gift->ends_on)) .'">
                                    <input value="'. $gift->description .'" id="description'. $gift->id .'" type="hidden">
                                    
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
                                            <button class="btn btn-primary btn-sm d-flex align-items-center justify-content-center add-to-cart-btn font-600 rounded-left" data-id="'. $gift->id .'">
                                                <i class="material-icons text-white mr-1">add_shopping_cart</i>
                                                Buy <span class="text-white text-white ml-1">gift</span>
                                            </button>
                                            <button class="btn border-primary btn-sm text-primary compare-btn d-flex align-items-center justify-content-center font-600 rounded-right" id="compare-btn'. $gift->id .'" data-name="'. $short_name .'" data-id="'. $gift->id .'">
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
                $personal_care = DB::table('gifts')
                                    ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                    ->select('gifts.*', 'categories.category_name')
                                    ->where('category_id', 12)
                                    ->inRandomOrder()
                                    ->take(4)
                                    ->get();
                foreach($personal_care as $gift){
                    // Gift star rating
                    $star_rating = giftStarRating($gift->id);
                    $usd_before = number_format(($gift->usd_price + ($gift->usd_price * 0.275)), 2); 
                    $zar_before = number_format(($gift->zar_price + ($gift->zar_price * 0.275)), 2);
                    $zwl_before = number_format(($gift->zwl_price + ($gift->zwl_price * 0.275)), 2);
                    $short_name = mb_strimwidth($gift->gift_name, 0, 15, '...');

                    if(isset(Auth::user()->id)){
                        $wishlist_icon = wishlistIcon($gift->id, Auth::user()->id);
                    } else {
                        $wishlist_icon = '
                            <span role="button" class="material-icons text-warning guest-wishes" id="'. $gift->id .'" data-name="'. $gift->gift_name .'">favorite_border</span>
                        ';
                    }

                    $care_gifts .= '
                        <!-- Product Card -->
                        <div class="card product-card border-0 rounded-0 box-shadow-sm">
                            <div class="product-img-wrapper">
                                '. giftLabel($gift->id) .'
                                <a href="details/'. $gift->slug .'/'. $gift->id .'" title="View product">
                                    <img src="/storage/gifts/'. $gift->gift_image .'" alt="'. $gift->gift_name .'" height="200" class="card-img-top rounded-0">
                                </a>
                                 <div class="overlay py-1 px-2">
                                    <div class="d-flex align-items-center">
                                        <a href="details/'. $gift->slug .'/'. $gift->id .'" class="d-flex align-items-center">
                                            <img role="button" src="/storage/gifts/'. $gift->gift_image .'" height="30" width="30" alt="'. $gift->gift_name .'" class="rounded-circle">
                                        </a>
                                        <div class="d-flex align-items-center ml-auto mr-2" title="'. giftsSold($gift->id) .' gift(s) sold">
                                            <span role="button" class="material-icons overlay-icon">add_shopping_cart</span>
                                            <small class="text-light d-list-grid">'. giftsSold($gift->id) .'</small>
                                        </div>
                                        <div class="d-flex align-items-center" title="Add to Wishlist">
                                            '. $wishlist_icon .'
                                            <small class="text-light d-list-grid">'. totalWishes($gift->id) .'</small>
                                        </div>
                                        <a href="details/'. $gift->slug .'/'. $gift->id .'" class="d-flex align-items-center ml-2" title="See Reviews">
                                            <span role="button" class="material-icons overlay-icon">forum</span>
                                            <small class="text-light d-list-grid">'. countRatings($gift->id) .'</small>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="card-body my-0 py-0">
                                    <div class="lh-100">
                                        <a href="details/'. $gift->slug .'/'. $gift->id .'">
                                            <p class="font-600 text-capitalize mt-1 mb-0 py-0 product-name popover-info" id="'. $gift->id .'">
                                                '. mb_strimwidth($gift->gift_name, 0, 25, '...') .'
                                            </p>
                                        </a>
                                        <a href="/category/'. $gift->category_name .'" class="text-sm font-500 text-capitalize my-0 py-0">
                                            '. $gift->category_name .'
                                        </a>
                                        '. $star_rating .'
                                    </div>
                                    <p class="product-description text-sm font-500 text-faded text-justify my-0 py-0">
                                        '. mb_strimwidth($gift->description, 0, 60, '...') .'
                                    </p>
                                    <input value="'. $gift->id .'" id="gift_id" type="hidden">
                                    <input value="'. $gift->gift_name .'" id="name'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->label .'" id="label'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->gift_image .'" id="image'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->usd_price .'" id="usd-price'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->zar_price .'" id="zar-price'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->zwl_price .'" id="zwl-price'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->sale_usd_price .'" id="sale-usd-price'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->sale_zar_price .'" id="sale-zar-price'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->sale_zwl_price .'" id="sale-zwl-price'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->custom_usd_price .'" id="customizing-usd-cost'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->custom_zar_price .'" id="customizing-zar-cost'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->custom_zwl_price .'" id="customizing-zwl-cost'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->ends_on .'" id="end-time'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->category_name .'" id="category-name'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->units .'" id="product-units'. $gift->id .'" type="hidden">
                                    <input value="1" id="quantity'. $gift->id .'" type="hidden">
                                    <input type="hidden" id="sale-end-date" value="'. date('y, m, d, h, m, s', strtotime($gift->ends_on)) .'">
                                    <input value="'. $gift->description .'" id="description'. $gift->id .'" type="hidden">
                                    
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
                                            <button class="btn btn-primary btn-sm d-flex align-items-center justify-content-center add-to-cart-btn font-600 rounded-left" data-id="'. $gift->id .'">
                                                <i class="material-icons text-white mr-1">add_shopping_cart</i>
                                                Buy <span class="text-white text-white ml-1">gift</span>
                                            </button>
                                            <button class="btn border-primary btn-sm text-primary compare-btn d-flex align-items-center justify-content-center font-600 rounded-right" id="compare-btn'. $gift->id .'" data-name="'. $short_name .'" data-id="'. $gift->id .'">
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
                $plasticware = DB::table('gifts')
                                ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                ->select('gifts.*', 'categories.category_name')
                                ->where('category_id', 21)
                                ->inRandomOrder()
                                ->take(4)
                                ->get();
                foreach($plasticware as $gift){
                    // Gift star rating
                    $star_rating = giftStarRating($gift->id);
                    $usd_before = number_format(($gift->usd_price + ($gift->usd_price * 0.275)), 2); 
                    $zar_before = number_format(($gift->zar_price + ($gift->zar_price * 0.275)), 2);
                    $zwl_before = number_format(($gift->zwl_price + ($gift->zwl_price * 0.275)), 2);
                    $short_name = mb_strimwidth($gift->gift_name, 0, 15, '...');

                    if(isset(Auth::user()->id)){
                        $wishlist_icon = wishlistIcon($gift->id, Auth::user()->id);
                    } else {
                        $wishlist_icon = '
                            <span role="button" class="material-icons text-warning guest-wishes" id="'. $gift->id .'" data-name="'. $gift->gift_name .'">favorite_border</span>
                        ';
                    }

                    $plasticware_gifts .= '
                        <!-- Product Card -->
                        <div class="card product-card border-0 rounded-0 box-shadow-sm">
                            <div class="product-img-wrapper">
                                '. giftLabel($gift->id) .'
                                <a href="details/'. $gift->slug .'/'. $gift->id .'" title="View product">
                                    <img src="/storage/gifts/'. $gift->gift_image .'" alt="'. $gift->gift_name .'" height="200" class="card-img-top rounded-0">
                                </a>
                                 <div class="overlay py-1 px-2">
                                    <div class="d-flex align-items-center">
                                        <a href="details/'. $gift->slug .'/'. $gift->id .'" class="d-flex align-items-center">
                                            <img role="button" src="/storage/gifts/'. $gift->gift_image .'" height="30" width="30" alt="'. $gift->gift_name .'" class="rounded-circle">
                                        </a>
                                        <div class="d-flex align-items-center ml-auto mr-2" title="'. giftsSold($gift->id) .' gift(s) sold">
                                            <span role="button" class="material-icons overlay-icon">add_shopping_cart</span>
                                            <small class="text-light d-list-grid">'. giftsSold($gift->id) .'</small>
                                        </div>
                                        <div class="d-flex align-items-center" title="Add to Wishlist">
                                            '. $wishlist_icon .'
                                            <small class="text-light d-list-grid">'. totalWishes($gift->id) .'</small>
                                        </div>
                                        <a href="details/'. $gift->slug .'/'. $gift->id .'" class="d-flex align-items-center ml-2" title="See Reviews">
                                            <span role="button" class="material-icons overlay-icon">forum</span>
                                            <small class="text-light d-list-grid">'. countRatings($gift->id) .'</small>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="card-body my-0 py-0">
                                    <div class="lh-100">
                                        <a href="details/'. $gift->slug .'/'. $gift->id .'">
                                            <p class="font-600 text-capitalize mt-1 mb-0 py-0 product-name popover-info" id="'. $gift->id .'">
                                                '. mb_strimwidth($gift->gift_name, 0, 25, '...') .'
                                            </p>
                                        </a>
                                        <a href="/category/'. $gift->category_name .'" class="text-sm font-500 text-capitalize my-0 py-0">
                                            '. $gift->category_name .'
                                        </a>
                                        '. $star_rating .'
                                    </div>
                                    <p class="product-description text-sm font-500 text-faded text-justify my-0 py-0">
                                        '. mb_strimwidth($gift->description, 0, 60, '...') .'
                                    </p>
                                    <input value="'. $gift->id .'" id="gift_id" type="hidden">
                                    <input value="'. $gift->gift_name .'" id="name'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->label .'" id="label'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->gift_image .'" id="image'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->usd_price .'" id="usd-price'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->zar_price .'" id="zar-price'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->zwl_price .'" id="zwl-price'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->sale_usd_price .'" id="sale-usd-price'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->sale_zar_price .'" id="sale-zar-price'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->sale_zwl_price .'" id="sale-zwl-price'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->custom_usd_price .'" id="customizing-usd-cost'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->custom_zar_price .'" id="customizing-zar-cost'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->custom_zwl_price .'" id="customizing-zwl-cost'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->ends_on .'" id="end-time'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->category_name .'" id="category-name'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->units .'" id="product-units'. $gift->id .'" type="hidden">
                                    <input value="1" id="quantity'. $gift->id .'" type="hidden">
                                    <input type="hidden" id="sale-end-date" value="'. date('y, m, d, h, m, s', strtotime($gift->ends_on)) .'">
                                    <input value="'. $gift->description .'" id="description'. $gift->id .'" type="hidden">
                                    
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
                                            <button class="btn btn-primary btn-sm d-flex align-items-center justify-content-center add-to-cart-btn font-600 rounded-left" data-id="'. $gift->id .'">
                                                <i class="material-icons text-white mr-1">add_shopping_cart</i>
                                                Buy <span class="text-white text-white ml-1">gift</span>
                                            </button>
                                            <button class="btn border-primary btn-sm text-primary compare-btn d-flex align-items-center justify-content-center font-600 rounded-right" id="compare-btn'. $gift->id .'" data-name="'. $short_name .'" data-id="'. $gift->id .'">
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
                $combo_gifts = DB::table('gifts')
                                ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                ->select('gifts.*', 'categories.category_name')
                                ->where('category_id', 34)
                                ->inRandomOrder()
                                ->take(4)
                                ->get();
                foreach($combo_gifts as $gift){
                    // Gift star rating
                    $star_rating = giftStarRating($gift->id);
                    $usd_before = number_format(($gift->usd_price + ($gift->usd_price * 0.275)), 2); 
                    $zar_before = number_format(($gift->zar_price + ($gift->zar_price * 0.275)), 2);
                    $zwl_before = number_format(($gift->zwl_price + ($gift->zwl_price * 0.275)), 2);
                    $short_name = mb_strimwidth($gift->gift_name, 0, 15, '...');

                    if(isset(Auth::user()->id)){
                        $wishlist_icon = wishlistIcon($gift->id, Auth::user()->id);
                    } else {
                        $wishlist_icon = '
                            <span role="button" class="material-icons text-warning guest-wishes" id="'. $gift->id .'" data-name="'. $gift->gift_name .'">favorite_border</span>
                        ';
                    }

                    $combos .= '
                        <!-- Product Card -->
                        <div class="card product-card border-0 rounded-0 box-shadow-sm">
                            <div class="product-img-wrapper">
                                '. giftLabel($gift->id) .'
                                <a href="details/'. $gift->slug .'/'. $gift->id .'" title="View product">
                                    <img src="/storage/gifts/'. $gift->gift_image .'" alt="'. $gift->gift_name .'" height="200" class="card-img-top rounded-0">
                                </a>
                                 <div class="overlay py-1 px-2">
                                    <div class="d-flex align-items-center">
                                        <a href="details/'. $gift->slug .'/'. $gift->id .'" class="d-flex align-items-center">
                                            <img role="button" src="/storage/gifts/'. $gift->gift_image .'" height="30" width="30" alt="'. $gift->gift_name .'" class="rounded-circle">
                                        </a>
                                        <div class="d-flex align-items-center ml-auto mr-2" title="'. giftsSold($gift->id) .' gift(s) sold">
                                            <span role="button" class="material-icons overlay-icon">add_shopping_cart</span>
                                            <small class="text-light d-list-grid">'. giftsSold($gift->id) .'</small>
                                        </div>
                                        <div class="d-flex align-items-center" title="Add to Wishlist">
                                            '. $wishlist_icon .'
                                            <small class="text-light d-list-grid">'. totalWishes($gift->id) .'</small>
                                        </div>
                                        <a href="details/'. $gift->slug .'/'. $gift->id .'" class="d-flex align-items-center ml-2" title="See Reviews">
                                            <span role="button" class="material-icons overlay-icon">forum</span>
                                            <small class="text-light d-list-grid">'. countRatings($gift->id) .'</small>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="card-body my-0 py-0">
                                    <div class="lh-100">
                                        <a href="details/'. $gift->slug .'/'. $gift->id .'">
                                            <p class="font-600 text-capitalize mt-1 mb-0 py-0 product-name popover-info" id="'. $gift->id .'">
                                                '. mb_strimwidth($gift->gift_name, 0, 25, '...') .'
                                            </p>
                                        </a>
                                        <a href="/category/'. $gift->category_name .'" class="text-sm font-500 text-capitalize my-0 py-0">
                                            '. $gift->category_name .'
                                        </a>
                                        '. $star_rating .'
                                    </div>
                                    <p class="product-description text-sm font-500 text-faded text-justify my-0 py-0">
                                        '. mb_strimwidth($gift->description, 0, 60, '...') .'
                                    </p>
                                    <input value="'. $gift->id .'" id="gift_id" type="hidden">
                                    <input value="'. $gift->gift_name .'" id="name'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->label .'" id="label'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->gift_image .'" id="image'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->usd_price .'" id="usd-price'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->zar_price .'" id="zar-price'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->zwl_price .'" id="zwl-price'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->sale_usd_price .'" id="sale-usd-price'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->sale_zar_price .'" id="sale-zar-price'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->sale_zwl_price .'" id="sale-zwl-price'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->custom_usd_price .'" id="customizing-usd-cost'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->custom_zar_price .'" id="customizing-zar-cost'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->custom_zwl_price .'" id="customizing-zwl-cost'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->ends_on .'" id="end-time'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->category_name .'" id="category-name'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->units .'" id="product-units'. $gift->id .'" type="hidden">
                                    <input value="1" id="quantity'. $gift->id .'" type="hidden">
                                    <input type="hidden" id="sale-end-date" value="'. date('y, m, d, h, m, s', strtotime($gift->ends_on)) .'">
                                    <input value="'. $gift->description .'" id="description'. $gift->id .'" type="hidden">
                                    
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
                                            <button class="btn btn-primary btn-sm d-flex align-items-center justify-content-center add-to-cart-btn font-600 rounded-left" data-id="'. $gift->id .'">
                                                <i class="material-icons text-white mr-1">add_shopping_cart</i>
                                                Buy <span class="text-white text-white ml-1">gift</span>
                                            </button>
                                            <button class="btn border-primary btn-sm text-primary compare-btn d-flex align-items-center justify-content-center font-600 rounded-right" id="compare-btn'. $gift->id .'" data-name="'. $short_name .'" data-id="'. $gift->id .'">
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
                $appliances = DB::table('gifts')
                                ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                ->select('gifts.*', 'categories.category_name')
                                ->where('category_id', 8)
                                ->inRandomOrder()
                                ->take(4)
                                ->get();
                foreach($appliances as $gift){
                    // Gift star rating
                    $star_rating = giftStarRating($gift->id);
                    $usd_before = number_format(($gift->usd_price + ($gift->usd_price * 0.275)), 2); 
                    $zar_before = number_format(($gift->zar_price + ($gift->zar_price * 0.275)), 2);
                    $zwl_before = number_format(($gift->zwl_price + ($gift->zwl_price * 0.275)), 2);
                    $short_name = mb_strimwidth($gift->gift_name, 0, 15, '...');

                    if(isset(Auth::user()->id)){
                        $wishlist_icon = wishlistIcon($gift->id, Auth::user()->id);
                    } else {
                        $wishlist_icon = '
                            <span role="button" class="material-icons text-warning guest-wishes" id="'. $gift->id .'" data-name="'. $gift->gift_name .'">favorite_border</span>
                        ';
                    }

                    $appliance_gifts .= '
                        <!-- Product Card -->
                        <div class="card product-card border-0 rounded-0 box-shadow-sm">
                            <div class="product-img-wrapper">
                                '. giftLabel($gift->id) .'
                                <a href="details/'. $gift->slug .'/'. $gift->id .'" title="View product">
                                    <img src="/storage/gifts/'. $gift->gift_image .'" alt="'. $gift->gift_name .'" height="200" class="card-img-top rounded-0">
                                </a>
                                 <div class="overlay py-1 px-2">
                                    <div class="d-flex align-items-center">
                                        <a href="details/'. $gift->slug .'/'. $gift->id .'" class="d-flex align-items-center">
                                            <img role="button" src="/storage/gifts/'. $gift->gift_image .'" height="30" width="30" alt="'. $gift->gift_name .'" class="rounded-circle">
                                        </a>
                                        <div class="d-flex align-items-center ml-auto mr-2" title="'. giftsSold($gift->id) .' gift(s) sold">
                                            <span role="button" class="material-icons overlay-icon">add_shopping_cart</span>
                                            <small class="text-light d-list-grid">'. giftsSold($gift->id) .'</small>
                                        </div>
                                        <div class="d-flex align-items-center" title="Add to Wishlist">
                                            '. $wishlist_icon .'
                                            <small class="text-light d-list-grid">'. totalWishes($gift->id) .'</small>
                                        </div>
                                        <a href="details/'. $gift->slug .'/'. $gift->id .'" class="d-flex align-items-center ml-2" title="See Reviews">
                                            <span role="button" class="material-icons overlay-icon">forum</span>
                                            <small class="text-light d-list-grid">'. countRatings($gift->id) .'</small>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="card-body my-0 py-0">
                                    <div class="lh-100">
                                        <a href="details/'. $gift->slug .'/'. $gift->id .'">
                                            <p class="font-600 text-capitalize mt-1 mb-0 py-0 product-name popover-info" id="'. $gift->id .'">
                                                '. mb_strimwidth($gift->gift_name, 0, 25, '...') .'
                                            </p>
                                        </a>
                                        <a href="/category/'. $gift->category_name .'" class="text-sm font-500 text-capitalize my-0 py-0">
                                            '. $gift->category_name .'
                                        </a>
                                        '. $star_rating .'
                                    </div>
                                    <p class="product-description text-sm font-500 text-faded text-justify my-0 py-0">
                                        '. mb_strimwidth($gift->description, 0, 60, '...') .'
                                    </p>
                                    <input value="'. $gift->id .'" id="gift_id" type="hidden">
                                    <input value="'. $gift->gift_name .'" id="name'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->label .'" id="label'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->gift_image .'" id="image'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->usd_price .'" id="usd-price'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->zar_price .'" id="zar-price'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->zwl_price .'" id="zwl-price'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->sale_usd_price .'" id="sale-usd-price'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->sale_zar_price .'" id="sale-zar-price'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->sale_zwl_price .'" id="sale-zwl-price'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->custom_usd_price .'" id="customizing-usd-cost'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->custom_zar_price .'" id="customizing-zar-cost'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->custom_zwl_price .'" id="customizing-zwl-cost'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->ends_on .'" id="end-time'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->category_name .'" id="category-name'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->units .'" id="product-units'. $gift->id .'" type="hidden">
                                    <input value="1" id="quantity'. $gift->id .'" type="hidden">
                                    <input type="hidden" id="sale-end-date" value="'. date('y, m, d, h, m, s', strtotime($gift->ends_on)) .'">
                                    <input value="'. $gift->description .'" id="description'. $gift->id .'" type="hidden">
                                    
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
                                            <button class="btn btn-primary btn-sm d-flex align-items-center justify-content-center add-to-cart-btn font-600 rounded-left" data-id="'. $gift->id .'">
                                                <i class="material-icons text-white mr-1">add_shopping_cart</i>
                                                Buy <span class="text-white text-white ml-1">gift</span>
                                            </button>
                                            <button class="btn border-primary btn-sm text-primary compare-btn d-flex align-items-center justify-content-center font-600 rounded-right" id="compare-btn'. $gift->id .'" data-name="'. $short_name .'" data-id="'. $gift->id .'">
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
                $data = [
                    'customized_gifts' => $customized_gifts, 
                    'kitchenware'      => $kitchenware_gifts,
                    'personal_care'    => $care_gifts,
                    'plasticware'      => $plasticware_gifts,
                    'combo_gifts'      => $combos, 
                    'appliances'       => $appliance_gifts,
                ];
                return response()->json($data);
            }
        }
    }

    // Add gift comparison
    public function add_comparison(Request $request)
    {
        if($request->ajax()){
            if($request->action == 'add-comparison'){
                // store data in the session
                $comparison = [
                    'gift_id'          => $request->gift_id,
                    'gift_name'        => $request->gift_name,
                    'gift_image'       => $request->gift_img,
                    'usd_price'        => $request->usd_price,
                    'zar_price'        => $request->zar_price,
                    'zwl_price'        => $request->zwl_price,
                    'gift_description' => $request->gift_description,
                    'category_name'    => $request->gift_category,
                    'gift_quantity'    => $request->gift_quantity,
                    'gift_units'       => $request->gift_units
                ];
                session($comparison);
                if(!empty(session())){
                    return response()->json([
                        'message' => 'success'
                    ]);
                } else {
                    return response()->json([
                        'message' => 'error'
                    ]);
                }
            }
        }
    }

    // Remove a gift from the comparison session
    public function remove_comparison(Request $request)
    {
        if($request->ajax()){
            if($request->action == 'remove-comparison'){
                // determine if the gift item is present in the session
                if($request->session()->has($request->gift_id)){
                    // retrieve and delete the gift item from the session
                    $request->session()->pull($request->gift_id);
                }
            }
        }
    }

    // Clear the comparisons session
    public function clear_comparisons(Request $request)
    {
        if($request->ajax()){
            if($request->action == 'clear-comparisons'){
                $request->session()->flush();
                return response()->json([
                    'message' => 'session-cleared'
                ]);
            }
        }
    }

    // Compare gifts comparisons page
    public function compare_page()
    {
        return view('compare_page');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug, $id)
    {
        $gift = Gift::where(['slug' => $slug, 'id' => $id])->firstOrFail();
        $greeting_cards = DB::table('gifts')
                            ->join('categories', 'categories.id', '=', 'gifts.category_id')
                            ->select('gifts.*', 'categories.*', 'gifts.id as gift_id')
                            ->where([
                                ['category_name', '=', 'greeting cards'],
                                ['gifts.id', '!=', $id]
                            ])
                            ->orderBy('usd_price', 'asc')
                            ->get();
        $wrappers = DB::table('gifts')
                        ->join('categories', 'categories.id', '=', 'gifts.category_id')
                        ->select('gifts.*', 'categories.*', 'gifts.id as gift_id')
                        ->where([
                            ['category_name', '=', 'wrappers'],
                            ['gifts.id', '!=', $id]
                        ])
                        ->orderBy('usd_price', 'asc')
                        ->get();
        $accesories = DB::table('gifts')
                        ->join('categories', 'categories.id', '=', 'gifts.category_id')
                        ->select('gifts.*', 'categories.*', 'gifts.id as gift_id')
                        ->where([
                            ['category_name', '=', 'flowers'],
                            ['gifts.id', '!=', $id]
                        ])
                        ->orWhere([
                            ['category_name', '=', 'pastries'],
                            ['category_name', '=', 'confectionery']
                        ])
                        ->orderBy('usd_price', 'asc')
                        ->get();
        $title = DB::table('gifts')
                    ->where('id', $id)
                    ->value('gift_name');
        $category_name = categoryName($id);
        $review_count = DB::table('gift_ratings')
                            ->join('users', 'users.id', '=', 'gift_ratings.user_id')
                            ->join('gifts', 'gifts.id', '=', 'gift_ratings.gift_id')
                            ->where('gifts.id', $id)
                            ->count();
        $app_reviews = DB::table('app_ratings')
                     ->join('users', 'users.id', '=', 'app_ratings.user_id')
                     ->orderBy('app_ratings.created_at', 'desc')
                     ->distinct()
                     ->get();
        $data = [
            'title' => $title,
            'category_name'  => $category_name,
            'gift'           => $gift,
            'id'             => $id,
            'greeting_cards' => $greeting_cards,
            'wrappers'       => $wrappers,
            'accesories'     => $accesories,
            'review_count'   => $review_count,
            'app_reviews'    => $app_reviews
        ];
        return view('details.show')->with($data);
    }

    // Show the user's gift item wishlist button
    public function wishlist_btn(Request $request)
    {
        if($request->ajax()){
            if($request->action == 'wishlist-btn'){
                $wishlist_btn = '';
                if(isset(Auth::user()->id)){
                    $wishlist_btn = wishlistBtn($request->gift_id, Auth::user()->id);
                } else {
                    $wishlist_btn = '
                        <button class="btn btn-sm btn-block rounded-pill font-600 d-flex align-items-center justify-content-center mr-1 guest-wishes">
                            <i class="material-icons text-primary mr-1">favorite_border</i>
                            <span class="text-primary">Wishlist</span>
                        </button>
                    ';
                }
                return response()->json([
                    'wishlist_btn' => $wishlist_btn
                ]);
            }
        }
    }

    /**
     * Fetch all gift ratings
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function gift_ratings(Request $request)
    {
        if($request->ajax()){
            if($request->action == 'gift-ratings'){
                $output = $user_msg = $helpful_btn = $unhelpful_btn = $comment_form = '';
                $progress_rating = progressBarRating($request->gift_id);
                $star_rating = dpStarRating($request->gift_id);
                $gift_rating = number_format(giftRating($request->gift_id), 1);
                $count_ratings = countRatings($request->gift_id);
                $reviews = DB::table('gift_ratings')
                            ->join('users', 'users.id', '=', 'gift_ratings.user_id')
                            ->join('gifts', 'gifts.id', '=', 'gift_ratings.gift_id')
                            ->select('gift_ratings.*', 'gift_ratings.created_at as posted_on', 'gifts.*', 'users.*')
                            ->where('gifts.id', $request->gift_id)
                            ->orderBy('gift_ratings.created_at', 'desc')
                            ->get();
                $count = $reviews->count();
                if($count > 0){
                    foreach ($reviews as $review){
                        if(Auth::user()->id){
                            $helpful_btn = helpful_btn($review->rating_id, $review->gift_id, Auth::user()->id);
                            $unhelpful_btn = unhelpful_btn($review->rating_id, $review->gift_id, Auth::user()->id);
                            $comment_form = '
                                <!-- Comment form -->
                                <div class="d-flex align-items-center">
                                    <img src="/storage/users/'. Auth::user()->profile_pic .'" height="30" width="30" alt="" class="rounded-circle mr-1">
                                    <input type="text" class="form-control form-control-sm comment-input rounded-pill" placeholder="Press enter to submit comment" name="add-comment" id="add-comment'. $review->rating_id .'" data-post_id="'. $review->rating_id .'" data-user_id="'. $review->user_id .'" required>
                                    <div class="send-btn d-sm-inline-block d-md-none" id="send-btn'. $review->rating_id .'">
                                        <button type="button" class="btn btn-primary btn-sm rounded-circle ml-1 comment-btn d-grid" id="send-btn'. $review->rating_id .'" data-post_id="'. $review->rating_id .'" data-user_id="'. $review->user_id .'">
                                            <i class="material-icons text-white m-auto">send</i>
                                        </button>
                                    </div>
                                </div>
                                <!-- /.comment form -->
                            ';
                        } else {
                            $helpful_btn = '
                                <div class="d-flex d-cursor align-items-center text-sm mx-md-4 text-faded review-action" data-url="" data-toggle="modal" href="#write-review">
                                    <i class="tiny material-icons mr-1">thumb_up</i>
                                    <span class="d-none d-md-inline">helpful</span>
                                </div>
                            ';
                            $unhelpful_btn = '
                                <div class="d-flex d-cursor align-items-center text-sm mx-md-4 text-faded review-action" data-url="" data-toggle="modal" href="#write-review">
                                    <i class="tiny material-icons mr-1">thumb_down</i>
                                    <span class="d-none d-md-inline">unhelpful</span>
                                </div>
                            ';
                        }
                        $output .= '
                            <!-- Product Review -->
                            <div class="media review-post">
                                <img src="/storage/users/'. $review->profile_pic .'" alt="'. $review->name .'" height="40" width="40" class="rounded-circle align-self-start mt-2 mr-2">
                                <div class="media-body">
                                    <div class="d-block user-details">
                                        <p class="font-500 text-capitalize my-0 py-0">'. $review->name .'</p>
                                        '. verifiedPurchase($review->gift_id, $review->user_id)  .'
                                        <div class="d-flex align-items-center lh-100">
                                            <span class="mr-2 my-0 py-0">
                                                '. customerRating($review->rating_id, $review->gift_id, $review->user_id) .'
                                            </span>
                                            <span class="text-sm text-faded">
                                                '. timestamp($review->posted_on) .'
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- User\'s Post -->
                            <div class="customer-post">
                                <p class="text-justify text-faded">
                                    '. $review->customer_review .'
                                </p>
                                <p class="text-sm text-faded">
                                    '. reviewLikes($review->rating_id, $review->gift_id) .'
                                </p>
                                <div class="mt-2 post-actions border-top border-bottom w-100 py-2">
                                    <span>
                                        '.$helpful_btn.'
                                    </span>
                                    <span class="mx-md-4">
                                        '.$unhelpful_btn.'
                                    </span>
                                    <div class="d-flex d-cursor align-items-center text-sm text-faded review-action toggle-comments" data-post_id="'. $review->rating_id .'" data-user_id="'. $review->user_id .'">
                                        <i class="tiny material-icons mr-1">sms</i> comment
                                    </div>
                                    <div class="d-flex d-cursor align-items-center text-sm text-faded ml-md-auto toggle-comments" data-post_id="'. $review->rating_id .'" data-user_id="'. $review->user_id .'">
                                        <i class="tiny material-icons mr-1">forum</i> <span class="d-none d-md-inline mr-1">Comments</span> ('. countReviewComments($review->rating_id) .')
                                    </div>
                                </div>
                                <!-- Commend section -->
                                <div class="comment-section my-2" id="comment-box'. $review->rating_id .'">
                                    <div id="old-comments'. $review->rating_id .'">
                                        <!-- Review comments will show up here -->
                                    </div>
                                    '.$comment_form.'
                                </div>
                                <!-- /.Commend section -->
                            </div>
                            <!-- /.User\'s Post -->
                            <!-- /.Product review -->
                        ';
                    }
                } else {
                    if(isset(Auth::user()->id)){
                        $user_msg = '
                            <p class="text-sm">
                                Post your review about this gift. It helps others in deciding 
                                to purchase this gift
                            </p>
                        ';
                    } else {
                        $user_msg = '
                            <p class="text-sm">
                                Sign in to post your review about this gift. It helps others in deciding 
                                to purchase this gift
                            </p> 
                        ';
                    }
                    $output = '
                        <div class="row justify-content-center my-5">
                            <div class="col-10 col-md-12 text-center no-content">
                                <i class="material-icons text-muted lead">forum</i>
                                <h5 class="font-600">There are no gift reviews to show at the moment.</h5>
                                '.$user_msg.'
                                <a href="#write-review" class="btn btn-primary btn-sm px-3" data-toggle="modal">Post a review</a>
                            </div>
                        </div>
                    ';
                }
                return response()->json([
                    'progress_rating' => $progress_rating,
                    'star_rating'     => $star_rating,
                    'gift_rating'     => $gift_rating,
                    'count_ratings'   => $count_ratings,
                    'reviews'         =>  $output
                ]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $category
     * @param int $category_id
     * @return \Illuminate\Http\Response
     */
    public function category($category_id, $category)
    {
        $gifts = DB::table('gifts')
                    ->join('categories', 'categories.id', '=', 'gifts.category_id')
                    ->select('gifts.*', 'gifts.id as gift_id', 'categories.*')
                    ->where('category_name', $category)
                    ->orderBy('usd_price', 'asc')
                    ->get();
        $sub_categories = DB::table('sub_categories')
                            ->where('category_id', $category_id)
                            ->distinct()
                            ->get();
        $data = [
            'title' => ucfirst($category .' Gifts'),
            'gifts' => $gifts,
            'sub_categories' => $sub_categories
        ];
        return view('category.index')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
