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
                                    <input value="'. $gift->id .'" id="product_id" type="hidden">
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
                                    <input value="'. $gift->id .'" id="product_id" type="hidden">
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
                                    <input value="'. $gift->id .'" id="product_id" type="hidden">
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
                                    <input value="'. $gift->id .'" id="product_id" type="hidden">
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
                                    <input value="'. $gift->id .'" id="product_id" type="hidden">
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
                                    <input value="'. $gift->id .'" id="product_id" type="hidden">
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
                            ->where([
                                ['category_name', '=', 'greeting cards'],
                                ['gifts.id', '!=', $id]
                            ])
                            ->orderBy('usd_price', 'asc')
                            ->get();
        $wrappers = DB::table('gifts')
                        ->join('categories', 'categories.id', '=', 'gifts.category_id')
                        ->where([
                            ['category_name', '=', 'wrappers'],
                            ['gifts.id', '!=', $id]
                        ])
                        ->orderBy('usd_price', 'asc')
                        ->get();
        $accesories = DB::table('gifts')
                        ->join('categories', 'categories.id', '=', 'gifts.category_id')
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
        $reviews = DB::table('gift_ratings')
                     ->join('users', 'users.id', '=', 'gift_ratings.user_id')
                     ->join('gifts', 'gifts.id', '=', 'gift_ratings.gift_id')
                     ->where('gifts.id', $id)
                     ->orderBy('gift_ratings.created_at', 'desc')
                     ->get();
        $title = DB::table('gifts')
                    ->where('id', $id)
                    ->value('gift_name');
        $category_name = categoryName($id);
        $app_reviews = DB::table('app_ratings')
                     ->join('users', 'users.id', '=', 'app_ratings.user_id')
                     ->orderBy('app_ratings.created_at', 'desc')
                     ->distinct()
                     ->get();
        $data = [
            'title' => $title,
            'category_name' => $category_name,
            'gift' => $gift,
            'id' => $id,
            'greeting_cards' => $greeting_cards,
            'wrappers' => $wrappers,
            'accesories' => $accesories,
            'reviews' => $reviews,
            'app_reviews' => $app_reviews
        ];
        return view('details.show')->with($data);
    }

    // Show the user's gift item wishlist button
    public function wishlist_btn(Request $request)
    {
        if($request->ajax()){
            if($request->action == 'wishlist-btn'){
                $wishlist_btn = wishlistBtn($request->gift_id, Auth::user()->id);
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
                $progress_rating = progressBarRating($request->gift_id);
                $star_rating = dpStarRating($request->gift_id);
                $gift_rating = number_format(giftRating($request->gift_id), 1);
                $count_ratings = countRatings($request->gift_id);
                return response()->json([
                    'progress_rating' => $progress_rating,
                    'star_rating'     => $star_rating,
                    'gift_rating'     => $gift_rating,
                    'count_ratings'   => $count_ratings
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
