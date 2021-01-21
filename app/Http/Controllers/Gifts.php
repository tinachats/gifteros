<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
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
                $gift_label = $browsed_gifts = $timer = $custom_link = '';
                $end_dates = $gift_ids = [];
                $date_diff = 0;

                // Current time
                $now = time() * 1000;

                $customizables = DB::table('gifts')
                                    ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                    ->select('gifts.*', 'categories.category_name')
                                    ->where('label', 'customizable')
                                    ->inRandomOrder()
                                    ->take(5)
                                    ->get();
                foreach($customizables as $gift){
                    // Gift star rating
                    $star_rating = giftStarRating($gift->id);

                    // Gift sale percentage
                    $sale_percentage = $gift->sale_percentage;
                    
                    // Gift's short name to show on comparison pane
                    $short_name = mb_strimwidth($gift->gift_name, 0, 15, '...');

                    // Show if user customized or wishlisted the gift
                    if(isset(Auth::user()->id)){
                        $wishlist_icon = wishlistIcon($gift->id, Auth::user()->id);
                        if(!empty(customizedLabel($gift->id, Auth::user()->id))){
                            $gift_label = customizedLabel($gift->id, Auth::user()->id);
                        } else {
                            $gift_label = giftLabel($gift->id, round(100 * $gift->sale_percentage));
                        }
                    } else {
                        $wishlist_icon = '
                            <i role="button" class="fa fa-heart-o text-light guest-wishes" id="'. $gift->id .'" data-name="'. $gift->gift_name .'"></i>
                        ';
                        $gift_label = giftLabel($gift->id, round(100 * $gift->sale_percentage));
                    }

                    // Fetch sale end-date
                    $end_date = strtotime($gift->ends_on) * 1000;
                    $end_dates[] = $end_date;

                    // Determine if end date is greater than today
                    $date_diff = floor(abs(($end_date - $now) / (1000 * 3600 * 24)));

                    // Fetch all gif-ids
                    $gift_ids[] = $gift->id;

                    // Only show the timer if it's the gift item is on sale or hot-offer
                    if($gift->label == 'sale' || $gift->label == 'hot-offer'){
                        if($date_diff > 0){
                            // Discount the price when on sale
                            $sale_price = number_format($gift->usd_price - ($gift->usd_price * $sale_percentage), 2);

                            // Discounted prices
                            $usd_price = $sale_price;
                            $zar_price = number_format(($sale_price * zaRate()), 2);
                            $zwl_price = number_format(($sale_price * zwRate()), 2);

                            // The slashed price is the original price
                            $discount_price = $gift->usd_price;
                            $usd_before = number_format($discount_price, 2); 
                            $zar_before = number_format(($discount_price * zaRate()), 2);
                            $zwl_before = number_format(($discount_price * zwRate()), 2);

                            // Show countdown timer
                            $timer = '
                                <div class="d-flex align-items-center justify-content-between text-sm">
                                    <span><span class="d-sm-none d-md-inline-block">Sale</span>Ends:</span>
                                    <span class="ml-1 d-flex align-items-center" id="countdown-timer'.$gift->id.'">00d:00h:00m:00s</span>
                                </div>
                            ';
                        } else {
                            // Show that the sale is closed
                            $timer = '
                                <div class="sale-timer d-flex align-items-center justify-content-between text-sm pt-sm-2">
                                    <span><span class="d-sm-none d-md-inline-block">Sale</span>Ends:</span>
                                    <span class="ml-1 d-flex text-danger align-items-center" id="countdown-timer'.$gift->id.'">Sale closed</span>
                                </div>
                            ';

                            // Revert back to the old price without the sale percentage
                            $usd_price = number_format($gift->usd_price, 2);
                            $zar_price = number_format(($gift->usd_price * zaRate()), 2);
                            $zwl_price = number_format(($gift->usd_price * zwRate()), 2);

                            // Slashed prices 
                            $sale_price = number_format($gift->usd_price - ($gift->usd_price * 0.2), 2);
                            $usd_before = $sale_price; 
                            $zar_before = number_format(($sale_price * zaRate()), 2);
                            $zwl_before = number_format(($sale_price * zwRate()), 2);
                        }
                    } else {
                        $timer = '';

                        // Gift prices and currency rates
                        $usd_price = number_format($gift->usd_price, 2);
                        $zar_price = number_format(($gift->usd_price * zaRate()), 2);
                        $zwl_price = number_format(($gift->usd_price * zwRate()), 2);

                        // Slashed prices
                        $usd_before = number_format(($usd_price + ($usd_price * 0.275)), 2); 
                        $zar_before = number_format((($gift->usd_price * zaRate()) + (($gift->usd_price * zaRate()) * 0.275)), 2);
                        $zwl_before = number_format((($gift->usd_price * zwRate()) + (($gift->usd_price * zwRate()) * 0.275)), 2);
                    }

                    // Show the customize link if gift item is customizable
                    if($gift->label == 'customizable'){
                        $custom_link = '
                            <a href="#" class="nav-link icon-link toggle-customization" id="customize'.$gift->id.'" title="Customize gift" data-id="'. $gift->id .'">
                                <i class="material-icons">palette</i>
                            </a>
                        ';
                    }

                    $customized_gifts .= '
                        <!-- Product Card -->
                        <div class="card product-card rounded-2 box-shadow-sm" data-id="'.$gift->id.'">
                            <!-- Cart Actions -->
                            <div class="gift-cart-options bg-whitesmoke box-shadow-sm d-none" id="cart-options'.$gift->id.'">
                                <div class="d-flex align-items-center px-2">
                                    <div class="d-flex align-items-center justify-content-around m-0 p-0">
                                        <span role="button" class="product-actions material-icons text-success subtract-product" data-id="'.$gift->id.'" title="Decrease quantity">remove_circle</span>
                                        <span role="button" class="product-actions item-quantity text-faded" id="item-count'.$gift->id.'">0</span>
                                        <span role="button" class="product-actions material-icons text-success increase-qty" data-id="'.$gift->id.'" title="Increase quantity">add_circle</span>
                                    </div>
                                    <div class="ml-auto d-flex align-items-center">
                                        '.$custom_link.'
                                        <a href="#" class="nav-link icon-link text-danger remove-item ml-2" title="Remove Item" data-id="'.$gift->id.'">
                                            <i class="material-icons notifications">delete</i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- /.Cart Actions -->
                            <div class="product-img-wrapper">
                                '. $gift_label .'
                                <a href="details/'. $gift->slug .'/'. $gift->id .'" title="View product">
                                    <img src="/storage/gifts/'. $gift->gift_image .'" alt="'. $gift->gift_name .'" height="200" class="card-img-top">
                                </a>
                                <div class="overlay d-flex justify-content-around py-1">
                                    <div class="d-flex flex-column text-center" title="'. $gift->units .' In Stock">
                                        <i class="fa fa-home text-light"></i>
                                        <span class="text-light text-sm">'. $gift->units .'</span>
                                    </div>
                                    <div class="d-flex flex-column text-center" title="'. viewCounter($gift->id) .' Total Views">
                                        <i class="fa fa-eye text-light"></i>
                                        <span class="text-light text-sm">'. viewCounter($gift->id) .'</span>
                                    </div>
                                    <div class="d-flex flex-column text-center" title="Wishlisted by '. totalWishes($gift->id) .' customer(s)">
                                        '.$wishlist_icon.'
                                        <span class="text-light text-sm">'. totalWishes($gift->id) .'</span>
                                    </div>
                                    <div class="d-flex flex-column text-center" title="'. giftsSold($gift->id) .' gift(s) sold">
                                        <div class="d-flex align-items-center overlay-metric">
                                            <i class="fa fa-shopping-bag text-light"></i>
                                            <span class="badge badge-danger badge-pill overlay-badge">'. giftsSold($gift->id) .'</span>
                                        </div>
                                        <span class="text-light text-sm">Sold</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="card-body my-0 py-0">
                                    <div class="lh-100 mb-0 pb-0">
                                        <a href="details/'. $gift->slug .'/'. $gift->id .'">
                                            <p class="d-sm-none d-md-block font-600 text-capitalize mt-1 mb-0 py-0 product-name popover-info" id="'. $gift->id .'">
                                                '. Str::words($gift->gift_name, 2, '') .'
                                            </p>
                                            <p class="d-md-none font-600 text-capitalize mt-1 mb-0 py-0 product-name popover-info" id="'. $gift->id .'">
                                                '. Str::words($gift->gift_name, 1, '') .'
                                            </p>
                                        </a>
                                        <a href="/category/'. $gift->category_name .'" class="text-sm font-500 text-capitalize my-0 py-0">
                                            '. $gift->category_name .'
                                        </a>
                                        '. $star_rating .'
                                    </div>
                                    <div class="price-tag pull-up-1">
                                        <div class="usd-price">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="font-600">US$<span class="product-price">'. $usd_price .'</span></span>
                                                <div class="d-flex align-items-center before-prices">
                                                    <span class="font-600 text-muted strikethrough ml-1">US$'. $usd_before .'</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="zar-price d-none">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="font-600">R<span class="product-price">'. $zar_price .'</span></span>
                                                <div class="d-flex align-items-center before-prices">
                                                    <span class="font-600 text-muted strikethrough ml-1">R'. $zar_before .'</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="zwl-price d-none">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="font-600">ZW$<span class="product-price">'. $zwl_price .'</span></span>
                                                <div class="d-flex align-items-center before-prices">
                                                    <span class="font-600 text-muted strikethrough ml-1">$'. $zwl_before .'</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    '. $timer .'
                                    <div class="row justify-content-center w-100">
                                        <div class="btn-group btn-group-sm mt-0 pt-0 pulse">
                                            <button class="btn btn-primary btn-sm d-flex align-items-center add-to-cart-btn rounded-left" data-id="'. $gift->id .'">
                                                <i class="material-icons text-white mr-1 d-sm-none d-md-inline-block">add_shopping_cart</i>
                                                Buy <span class="text-white text-white ml-1">gift</span rounded-right>
                                            </button>
                                            <button class="btn border-primary btn-sm text-primary compare-btn d-flex align-items-center rounded-right" id="compare-btn'. $gift->id .'" data-name="'. $short_name .'" data-id="'. $gift->id .'">
                                                <i class="material-icons text-primary mr-1 d-sm-none d-md-inline-block">compare_arrows</i>
                                                Compare
                                            </button>
                                        </div>
                                    </div>
                                    <input value="'. $gift->id .'" id="gift_id" type="hidden">
                                    <input value="'. $gift->gift_name .'" id="name'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->label .'" id="label'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->gift_image .'" id="image'. $gift->id .'" type="hidden">
                                    <input value="'. $usd_price .'" id="usd-price'. $gift->id .'" type="hidden">
                                    <input value="'. $zar_price .'" id="zar-price'. $gift->id .'" type="hidden">
                                    <input value="'. $zwl_price .'" id="zwl-price'. $gift->id .'" type="hidden">
                                    <input value="'. $end_date .'" id="end-time'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->category_id .'" id="category-id'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->category_name .'" id="category-name'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->units .'" id="product-units'. $gift->id .'" type="hidden">
                                    <input value="1" id="quantity'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->description .'" id="description'. $gift->id .'" type="hidden">
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
                                ->take(5)
                                ->get();
                foreach($kitchenware as $gift){
                    // Gift star rating
                    $star_rating = giftStarRating($gift->id);

                    // Gift sale percentage
                    $sale_percentage = $gift->sale_percentage;
                    
                    // Gift's short name to show on comparison pane
                    $short_name = mb_strimwidth($gift->gift_name, 0, 15, '...');

                    // Show if user customized or wishlisted the gift
                    if(isset(Auth::user()->id)){
                        $wishlist_icon = wishlistIcon($gift->id, Auth::user()->id);
                        if(!empty(customizedLabel($gift->id, Auth::user()->id))){
                            $gift_label = customizedLabel($gift->id, Auth::user()->id);
                        } else {
                            $gift_label = giftLabel($gift->id, round(100 * $gift->sale_percentage));
                        }
                    } else {
                        $wishlist_icon = '
                            <i role="button" class="fa fa-heart-o text-light guest-wishes" id="'. $gift->id .'" data-name="'. $gift->gift_name .'"></i>
                        ';
                        $gift_label = giftLabel($gift->id, round(100 * $gift->sale_percentage));
                    }

                    // Fetch sale end-date
                    $end_date = strtotime($gift->ends_on) * 1000;
                    $end_dates[] = $end_date;

                    // Determine if end date is greater than today
                    $date_diff = floor(abs(($end_date - $now) / (1000 * 3600 * 24)));

                    // Fetch all gif-ids
                    $gift_ids[] = $gift->id;

                    // Only show the timer if it's the gift item is on sale or hot-offer
                    if($gift->label == 'sale' || $gift->label == 'hot-offer'){
                        if($date_diff > 0){
                            // Discount the price when on sale
                            $sale_price = number_format($gift->usd_price - ($gift->usd_price * $sale_percentage), 2);

                            // Discounted prices
                            $usd_price = $sale_price;
                            $zar_price = number_format(($sale_price * zaRate()), 2);
                            $zwl_price = number_format(($sale_price * zwRate()), 2);

                            // The slashed price is the original price
                            $discount_price = $gift->usd_price;
                            $usd_before = number_format($discount_price, 2); 
                            $zar_before = number_format(($discount_price * zaRate()), 2);
                            $zwl_before = number_format(($discount_price * zwRate()), 2);

                            // Show countdown timer
                            $timer = '
                                <div class="d-flex align-items-center justify-content-between text-sm">
                                    <span><span class="d-sm-none d-md-inline-block">Sale</span>Ends:</span>
                                    <span class="ml-1 d-flex align-items-center" id="countdown-timer'.$gift->id.'">00d:00h:00m:00s</span>
                                </div>
                            ';
                        } else {
                            // Show that the sale is closed
                            $timer = '
                                <div class="sale-timer d-flex align-items-center justify-content-between text-sm pt-sm-2">
                                    <span><span class="d-sm-none d-md-inline-block">Sale</span>Ends:</span>
                                    <span class="ml-1 d-flex text-danger align-items-center" id="countdown-timer'.$gift->id.'">Sale closed</span>
                                </div>
                            ';

                            // Revert back to the old price without the sale percentage
                            $usd_price = number_format($gift->usd_price, 2);
                            $zar_price = number_format(($gift->usd_price * zaRate()), 2);
                            $zwl_price = number_format(($gift->usd_price * zwRate()), 2);

                            // Slashed prices 
                            $sale_price = number_format($gift->usd_price - ($gift->usd_price * 0.2), 2);
                            $usd_before = $sale_price; 
                            $zar_before = number_format(($sale_price * zaRate()), 2);
                            $zwl_before = number_format(($sale_price * zwRate()), 2);
                        }
                    } else {
                        $timer = '';

                        // Gift prices and currency rates
                        $usd_price = number_format($gift->usd_price, 2);
                        $zar_price = number_format(($gift->usd_price * zaRate()), 2);
                        $zwl_price = number_format(($gift->usd_price * zwRate()), 2);

                        // Slashed prices
                        $usd_before = number_format(($usd_price + ($usd_price * 0.275)), 2); 
                        $zar_before = number_format((($gift->usd_price * zaRate()) + (($gift->usd_price * zaRate()) * 0.275)), 2);
                        $zwl_before = number_format((($gift->usd_price * zwRate()) + (($gift->usd_price * zwRate()) * 0.275)), 2);
                    }

                    // Show the customize link if gift item is customizable
                    if($gift->label == 'customizable'){
                        $custom_link = '
                            <a href="#" class="nav-link icon-link toggle-customization" id="customize'.$gift->id.'" title="Customize gift" data-id="'. $gift->id .'">
                                <i class="material-icons">palette</i>
                            </a>
                        ';
                    }

                    $kitchenware_gifts .= '
                        <!-- Product Card -->
                        <div class="card product-card rounded-2 box-shadow-sm" data-id="'.$gift->id.'">
                            <!-- Cart Actions -->
                            <div class="gift-cart-options bg-whitesmoke box-shadow-sm d-none" id="cart-options'.$gift->id.'">
                                <div class="d-flex align-items-center px-2">
                                    <div class="d-flex align-items-center justify-content-around m-0 p-0">
                                        <span role="button" class="product-actions material-icons text-success subtract-product" data-id="'.$gift->id.'" title="Decrease quantity">remove_circle</span>
                                        <span role="button" class="product-actions item-quantity text-faded" id="item-count'.$gift->id.'">0</span>
                                        <span role="button" class="product-actions material-icons text-success increase-qty" data-id="'.$gift->id.'" title="Increase quantity">add_circle</span>
                                    </div>
                                    <div class="ml-auto d-flex align-items-center">
                                        '.$custom_link.'
                                        <a href="#" class="nav-link icon-link text-danger remove-item ml-2" title="Remove Item" data-id="'.$gift->id.'">
                                            <i class="material-icons notifications">delete</i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- /.Cart Actions -->
                            <div class="product-img-wrapper">
                                '. $gift_label .'
                                <a href="details/'. $gift->slug .'/'. $gift->id .'" title="View product">
                                    <img src="/storage/gifts/'. $gift->gift_image .'" alt="'. $gift->gift_name .'" height="200" class="card-img-top">
                                </a>
                                <div class="overlay d-flex justify-content-around py-1">
                                    <div class="d-flex flex-column text-center" title="'. $gift->units .' In Stock">
                                        <i class="fa fa-home text-light"></i>
                                        <span class="text-light text-sm">'. $gift->units .'</span>
                                    </div>
                                    <div class="d-flex flex-column text-center" title="'. viewCounter($gift->id) .' Total Views">
                                        <i class="fa fa-eye text-light"></i>
                                        <span class="text-light text-sm">'. viewCounter($gift->id) .'</span>
                                    </div>
                                    <div class="d-flex flex-column text-center" title="Wishlisted by '. totalWishes($gift->id) .' customer(s)">
                                        '.$wishlist_icon.'
                                        <span class="text-light text-sm">'. totalWishes($gift->id) .'</span>
                                    </div>
                                    <div class="d-flex flex-column text-center" title="'. giftsSold($gift->id) .' gift(s) sold">
                                        <div class="d-flex align-items-center overlay-metric">
                                            <i class="fa fa-shopping-bag text-light"></i>
                                            <span class="badge badge-danger badge-pill overlay-badge">'. giftsSold($gift->id) .'</span>
                                        </div>
                                        <span class="text-light text-sm">Sold</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="card-body my-0 py-0">
                                    <div class="lh-100 mb-0 pb-0">
                                        <a href="details/'. $gift->slug .'/'. $gift->id .'">
                                            <p class="d-sm-none d-md-block font-600 text-capitalize mt-1 mb-0 py-0 product-name popover-info" id="'. $gift->id .'">
                                                '. Str::words($gift->gift_name, 2, '') .'
                                            </p>
                                            <p class="d-md-none font-600 text-capitalize mt-1 mb-0 py-0 product-name popover-info" id="'. $gift->id .'">
                                                '. Str::words($gift->gift_name, 1, '') .'
                                            </p>
                                        </a>
                                        <a href="/category/'. $gift->category_name .'" class="text-sm font-500 text-capitalize my-0 py-0">
                                            '. $gift->category_name .'
                                        </a>
                                        '. $star_rating .'
                                    </div>
                                    <div class="price-tag pull-up-1">
                                        <div class="usd-price">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="font-600">US$<span class="product-price">'. $usd_price .'</span></span>
                                                <div class="d-flex align-items-center before-prices">
                                                    <span class="font-600 text-muted strikethrough ml-1">US$'. $usd_before .'</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="zar-price d-none">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="font-600">R<span class="product-price">'. $zar_price .'</span></span>
                                                <div class="d-flex align-items-center before-prices">
                                                    <span class="font-600 text-muted strikethrough ml-1">R'. $zar_before .'</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="zwl-price d-none">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="font-600">ZW$<span class="product-price">'. $zwl_price .'</span></span>
                                                <div class="d-flex align-items-center before-prices">
                                                    <span class="font-600 text-muted strikethrough ml-1">$'. $zwl_before .'</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    '. $timer .'
                                    <div class="row justify-content-center w-100">
                                        <div class="btn-group btn-group-sm mt-0 pt-0 pulse">
                                            <button class="btn btn-primary btn-sm d-flex align-items-center add-to-cart-btn rounded-left" data-id="'. $gift->id .'">
                                                <i class="material-icons text-white mr-1 d-sm-none d-md-inline-block">add_shopping_cart</i>
                                                Buy <span class="text-white text-white ml-1">gift</span rounded-right>
                                            </button>
                                            <button class="btn border-primary btn-sm text-primary compare-btn d-flex align-items-center rounded-right" id="compare-btn'. $gift->id .'" data-name="'. $short_name .'" data-id="'. $gift->id .'">
                                                <i class="material-icons text-primary mr-1 d-sm-none d-md-inline-block">compare_arrows</i>
                                                Compare
                                            </button>
                                        </div>
                                    </div>
                                    <input value="'. $gift->id .'" id="gift_id" type="hidden">
                                    <input value="'. $gift->gift_name .'" id="name'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->label .'" id="label'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->gift_image .'" id="image'. $gift->id .'" type="hidden">
                                    <input value="'. $usd_price .'" id="usd-price'. $gift->id .'" type="hidden">
                                    <input value="'. $zar_price .'" id="zar-price'. $gift->id .'" type="hidden">
                                    <input value="'. $zwl_price .'" id="zwl-price'. $gift->id .'" type="hidden">
                                    <input value="'. $end_date .'" id="end-time'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->category_id .'" id="category-id'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->category_name .'" id="category-name'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->units .'" id="product-units'. $gift->id .'" type="hidden">
                                    <input value="1" id="quantity'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->description .'" id="description'. $gift->id .'" type="hidden">
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
                                    ->take(5)
                                    ->get();
                foreach($personal_care as $gift){
                    // Gift star rating
                    $star_rating = giftStarRating($gift->id);

                    // Gift sale percentage
                    $sale_percentage = $gift->sale_percentage;
                    
                    // Gift's short name to show on comparison pane
                    $short_name = mb_strimwidth($gift->gift_name, 0, 15, '...');

                    // Show if user customized or wishlisted the gift
                    if(isset(Auth::user()->id)){
                        $wishlist_icon = wishlistIcon($gift->id, Auth::user()->id);
                        if(!empty(customizedLabel($gift->id, Auth::user()->id))){
                            $gift_label = customizedLabel($gift->id, Auth::user()->id);
                        } else {
                            $gift_label = giftLabel($gift->id, round(100 * $gift->sale_percentage));
                        }
                    } else {
                        $wishlist_icon = '
                            <i role="button" class="fa fa-heart-o text-light guest-wishes" id="'. $gift->id .'" data-name="'. $gift->gift_name .'"></i>
                        ';
                        $gift_label = giftLabel($gift->id, round(100 * $gift->sale_percentage));
                    }

                    // Fetch sale end-date
                    $end_date = strtotime($gift->ends_on) * 1000;
                    $end_dates[] = $end_date;

                    // Determine if end date is greater than today
                    $date_diff = floor(abs(($end_date - $now) / (1000 * 3600 * 24)));

                    // Fetch all gif-ids
                    $gift_ids[] = $gift->id;

                    // Only show the timer if it's the gift item is on sale or hot-offer
                    if($gift->label == 'sale' || $gift->label == 'hot-offer'){
                        if($date_diff > 0){
                            // Discount the price when on sale
                            $sale_price = number_format($gift->usd_price - ($gift->usd_price * $sale_percentage), 2);

                            // Discounted prices
                            $usd_price = $sale_price;
                            $zar_price = number_format(($sale_price * zaRate()), 2);
                            $zwl_price = number_format(($sale_price * zwRate()), 2);

                            // The slashed price is the original price
                            $discount_price = $gift->usd_price;
                            $usd_before = number_format($discount_price, 2); 
                            $zar_before = number_format(($discount_price * zaRate()), 2);
                            $zwl_before = number_format(($discount_price * zwRate()), 2);

                            // Show countdown timer
                            $timer = '
                                <div class="d-flex align-items-center justify-content-between text-sm">
                                    <span><span class="d-sm-none d-md-inline-block">Sale</span>Ends:</span>
                                    <span class="ml-1 d-flex align-items-center" id="countdown-timer'.$gift->id.'">00d:00h:00m:00s</span>
                                </div>
                            ';
                        } else {
                            // Show that the sale is closed
                            $timer = '
                                <div class="sale-timer d-flex align-items-center justify-content-between text-sm pt-sm-2">
                                    <span><span class="d-sm-none d-md-inline-block">Sale</span>Ends:</span>
                                    <span class="ml-1 d-flex text-danger align-items-center" id="countdown-timer'.$gift->id.'">Sale closed</span>
                                </div>
                            ';

                            // Revert back to the old price without the sale percentage
                            $usd_price = number_format($gift->usd_price, 2);
                            $zar_price = number_format(($gift->usd_price * zaRate()), 2);
                            $zwl_price = number_format(($gift->usd_price * zwRate()), 2);

                            // Slashed prices 
                            $sale_price = number_format($gift->usd_price - ($gift->usd_price * 0.2), 2);
                            $usd_before = $sale_price; 
                            $zar_before = number_format(($sale_price * zaRate()), 2);
                            $zwl_before = number_format(($sale_price * zwRate()), 2);
                        }
                    } else {
                        $timer = '';

                        // Gift prices and currency rates
                        $usd_price = number_format($gift->usd_price, 2);
                        $zar_price = number_format(($gift->usd_price * zaRate()), 2);
                        $zwl_price = number_format(($gift->usd_price * zwRate()), 2);

                        // Slashed prices
                        $usd_before = number_format(($usd_price + ($usd_price * 0.275)), 2); 
                        $zar_before = number_format((($gift->usd_price * zaRate()) + (($gift->usd_price * zaRate()) * 0.275)), 2);
                        $zwl_before = number_format((($gift->usd_price * zwRate()) + (($gift->usd_price * zwRate()) * 0.275)), 2);
                    }

                    // Show the customize link if gift item is customizable
                    if($gift->label == 'customizable'){
                        $custom_link = '
                            <a href="#" class="nav-link icon-link toggle-customization" id="customize'.$gift->id.'" title="Customize gift" data-id="'. $gift->id .'">
                                <i class="material-icons">palette</i>
                            </a>
                        ';
                    }

                    $care_gifts .= '
                        <!-- Product Card -->
                        <div class="card product-card rounded-2 box-shadow-sm" data-id="'.$gift->id.'">
                            <!-- Cart Actions -->
                            <div class="gift-cart-options bg-whitesmoke box-shadow-sm d-none" id="cart-options'.$gift->id.'">
                                <div class="d-flex align-items-center px-2">
                                    <div class="d-flex align-items-center justify-content-around m-0 p-0">
                                        <span role="button" class="product-actions material-icons text-success subtract-product" data-id="'.$gift->id.'" title="Decrease quantity">remove_circle</span>
                                        <span role="button" class="product-actions item-quantity text-faded" id="item-count'.$gift->id.'">0</span>
                                        <span role="button" class="product-actions material-icons text-success increase-qty" data-id="'.$gift->id.'" title="Increase quantity">add_circle</span>
                                    </div>
                                    <div class="ml-auto d-flex align-items-center">
                                        '.$custom_link.'
                                        <a href="#" class="nav-link icon-link text-danger remove-item ml-2" title="Remove Item" data-id="'.$gift->id.'">
                                            <i class="material-icons notifications">delete</i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- /.Cart Actions -->
                            <div class="product-img-wrapper">
                                '. $gift_label .'
                                <a href="details/'. $gift->slug .'/'. $gift->id .'" title="View product">
                                    <img src="/storage/gifts/'. $gift->gift_image .'" alt="'. $gift->gift_name .'" height="200" class="card-img-top">
                                </a>
                                <div class="overlay d-flex justify-content-around py-1">
                                    <div class="d-flex flex-column text-center" title="'. $gift->units .' In Stock">
                                        <i class="fa fa-home text-light"></i>
                                        <span class="text-light text-sm">'. $gift->units .'</span>
                                    </div>
                                    <div class="d-flex flex-column text-center" title="'. viewCounter($gift->id) .' Total Views">
                                        <i class="fa fa-eye text-light"></i>
                                        <span class="text-light text-sm">'. viewCounter($gift->id) .'</span>
                                    </div>
                                    <div class="d-flex flex-column text-center" title="Wishlisted by '. totalWishes($gift->id) .' customer(s)">
                                        '.$wishlist_icon.'
                                        <span class="text-light text-sm">'. totalWishes($gift->id) .'</span>
                                    </div>
                                    <div class="d-flex flex-column text-center" title="'. giftsSold($gift->id) .' gift(s) sold">
                                        <div class="d-flex align-items-center overlay-metric">
                                            <i class="fa fa-shopping-bag text-light"></i>
                                            <span class="badge badge-danger badge-pill overlay-badge">'. giftsSold($gift->id) .'</span>
                                        </div>
                                        <span class="text-light text-sm">Sold</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="card-body my-0 py-0">
                                    <div class="lh-100 mb-0 pb-0">
                                        <a href="details/'. $gift->slug .'/'. $gift->id .'">
                                            <p class="d-sm-none d-md-block font-600 text-capitalize mt-1 mb-0 py-0 product-name popover-info" id="'. $gift->id .'">
                                                '. Str::words($gift->gift_name, 2, '') .'
                                            </p>
                                            <p class="d-md-none font-600 text-capitalize mt-1 mb-0 py-0 product-name popover-info" id="'. $gift->id .'">
                                                '. Str::words($gift->gift_name, 1, '') .'
                                            </p>
                                        </a>
                                        <a href="/category/'. $gift->category_name .'" class="text-sm font-500 text-capitalize my-0 py-0">
                                            '. $gift->category_name .'
                                        </a>
                                        '. $star_rating .'
                                    </div>
                                    <div class="price-tag pull-up-1">
                                        <div class="usd-price">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="font-600">US$<span class="product-price">'. $usd_price .'</span></span>
                                                <div class="d-flex align-items-center before-prices">
                                                    <span class="font-600 text-muted strikethrough ml-1">US$'. $usd_before .'</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="zar-price d-none">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="font-600">R<span class="product-price">'. $zar_price .'</span></span>
                                                <div class="d-flex align-items-center before-prices">
                                                    <span class="font-600 text-muted strikethrough ml-1">R'. $zar_before .'</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="zwl-price d-none">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="font-600">ZW$<span class="product-price">'. $zwl_price .'</span></span>
                                                <div class="d-flex align-items-center before-prices">
                                                    <span class="font-600 text-muted strikethrough ml-1">$'. $zwl_before .'</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    '. $timer .'
                                    <div class="row justify-content-center w-100">
                                        <div class="btn-group btn-group-sm mt-0 pt-0 pulse">
                                            <button class="btn btn-primary btn-sm d-flex align-items-center add-to-cart-btn rounded-left" data-id="'. $gift->id .'">
                                                <i class="material-icons text-white mr-1 d-sm-none d-md-inline-block">add_shopping_cart</i>
                                                Buy <span class="text-white text-white ml-1">gift</span rounded-right>
                                            </button>
                                            <button class="btn border-primary btn-sm text-primary compare-btn d-flex align-items-center rounded-right" id="compare-btn'. $gift->id .'" data-name="'. $short_name .'" data-id="'. $gift->id .'">
                                                <i class="material-icons text-primary mr-1 d-sm-none d-md-inline-block">compare_arrows</i>
                                                Compare
                                            </button>
                                        </div>
                                    </div>
                                    <input value="'. $gift->id .'" id="gift_id" type="hidden">
                                    <input value="'. $gift->gift_name .'" id="name'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->label .'" id="label'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->gift_image .'" id="image'. $gift->id .'" type="hidden">
                                    <input value="'. $usd_price .'" id="usd-price'. $gift->id .'" type="hidden">
                                    <input value="'. $zar_price .'" id="zar-price'. $gift->id .'" type="hidden">
                                    <input value="'. $zwl_price .'" id="zwl-price'. $gift->id .'" type="hidden">
                                    <input value="'. $end_date .'" id="end-time'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->category_id .'" id="category-id'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->category_name .'" id="category-name'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->units .'" id="product-units'. $gift->id .'" type="hidden">
                                    <input value="1" id="quantity'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->description .'" id="description'. $gift->id .'" type="hidden">
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
                                ->take(5)
                                ->get();
                foreach($plasticware as $gift){
                    // Gift star rating
                    $star_rating = giftStarRating($gift->id);

                    // Gift sale percentage
                    $sale_percentage = $gift->sale_percentage;
                    
                    // Gift's short name to show on comparison pane
                    $short_name = mb_strimwidth($gift->gift_name, 0, 15, '...');

                    // Show if user customized or wishlisted the gift
                    if(isset(Auth::user()->id)){
                        $wishlist_icon = wishlistIcon($gift->id, Auth::user()->id);
                        if(!empty(customizedLabel($gift->id, Auth::user()->id))){
                            $gift_label = customizedLabel($gift->id, Auth::user()->id);
                        } else {
                            $gift_label = giftLabel($gift->id, round(100 * $gift->sale_percentage));
                        }
                    } else {
                        $wishlist_icon = '
                            <i role="button" class="fa fa-heart-o text-light guest-wishes" id="'. $gift->id .'" data-name="'. $gift->gift_name .'"></i>
                        ';
                        $gift_label = giftLabel($gift->id, round(100 * $gift->sale_percentage));
                    }

                    // Fetch sale end-date
                    $end_date = strtotime($gift->ends_on) * 1000;
                    $end_dates[] = $end_date;

                    // Determine if end date is greater than today
                    $date_diff = floor(abs(($end_date - $now) / (1000 * 3600 * 24)));

                    // Fetch all gif-ids
                    $gift_ids[] = $gift->id;

                    // Only show the timer if it's the gift item is on sale or hot-offer
                    if($gift->label == 'sale' || $gift->label == 'hot-offer'){
                        if($date_diff > 0){
                            // Discount the price when on sale
                            $sale_price = number_format($gift->usd_price - ($gift->usd_price * $sale_percentage), 2);

                            // Discounted prices
                            $usd_price = $sale_price;
                            $zar_price = number_format(($sale_price * zaRate()), 2);
                            $zwl_price = number_format(($sale_price * zwRate()), 2);

                            // The slashed price is the original price
                            $discount_price = $gift->usd_price;
                            $usd_before = number_format($discount_price, 2); 
                            $zar_before = number_format(($discount_price * zaRate()), 2);
                            $zwl_before = number_format(($discount_price * zwRate()), 2);

                            // Show countdown timer
                            $timer = '
                                <div class="d-flex align-items-center justify-content-between text-sm">
                                    <span><span class="d-sm-none d-md-inline-block">Sale</span>Ends:</span>
                                    <span class="ml-1 d-flex align-items-center" id="countdown-timer'.$gift->id.'">00d:00h:00m:00s</span>
                                </div>
                            ';
                        } else {
                            // Show that the sale is closed
                            $timer = '
                                <div class="sale-timer d-flex align-items-center justify-content-between text-sm pt-sm-2">
                                    <span><span class="d-sm-none d-md-inline-block">Sale</span>Ends:</span>
                                    <span class="ml-1 d-flex text-danger align-items-center" id="countdown-timer'.$gift->id.'">Sale closed</span>
                                </div>
                            ';

                            // Revert back to the old price without the sale percentage
                            $usd_price = number_format($gift->usd_price, 2);
                            $zar_price = number_format(($gift->usd_price * zaRate()), 2);
                            $zwl_price = number_format(($gift->usd_price * zwRate()), 2);

                            // Slashed prices 
                            $sale_price = number_format($gift->usd_price - ($gift->usd_price * 0.2), 2);
                            $usd_before = $sale_price; 
                            $zar_before = number_format(($sale_price * zaRate()), 2);
                            $zwl_before = number_format(($sale_price * zwRate()), 2);
                        }
                    } else {
                        $timer = '';

                        // Gift prices and currency rates
                        $usd_price = number_format($gift->usd_price, 2);
                        $zar_price = number_format(($gift->usd_price * zaRate()), 2);
                        $zwl_price = number_format(($gift->usd_price * zwRate()), 2);

                        // Slashed prices
                        $usd_before = number_format(($usd_price + ($usd_price * 0.275)), 2); 
                        $zar_before = number_format((($gift->usd_price * zaRate()) + (($gift->usd_price * zaRate()) * 0.275)), 2);
                        $zwl_before = number_format((($gift->usd_price * zwRate()) + (($gift->usd_price * zwRate()) * 0.275)), 2);
                    }

                    // Show the customize link if gift item is customizable
                    if($gift->label == 'customizable'){
                        $custom_link = '
                            <a href="#" class="nav-link icon-link toggle-customization" id="customize'.$gift->id.'" title="Customize gift" data-id="'. $gift->id .'">
                                <i class="material-icons">palette</i>
                            </a>
                        ';
                    }

                    $plasticware_gifts .= '
                        <!-- Product Card -->
                        <div class="card product-card rounded-2 box-shadow-sm" data-id="'.$gift->id.'">
                            <!-- Cart Actions -->
                            <div class="gift-cart-options bg-whitesmoke box-shadow-sm d-none" id="cart-options'.$gift->id.'">
                                <div class="d-flex align-items-center px-2">
                                    <div class="d-flex align-items-center justify-content-around m-0 p-0">
                                        <span role="button" class="product-actions material-icons text-success subtract-product" data-id="'.$gift->id.'" title="Decrease quantity">remove_circle</span>
                                        <span role="button" class="product-actions item-quantity text-faded" id="item-count'.$gift->id.'">0</span>
                                        <span role="button" class="product-actions material-icons text-success increase-qty" data-id="'.$gift->id.'" title="Increase quantity">add_circle</span>
                                    </div>
                                    <div class="ml-auto d-flex align-items-center">
                                        '.$custom_link.'
                                        <a href="#" class="nav-link icon-link text-danger remove-item ml-2" title="Remove Item" data-id="'.$gift->id.'">
                                            <i class="material-icons notifications">delete</i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- /.Cart Actions -->
                            <div class="product-img-wrapper">
                                '. $gift_label .'
                                <a href="details/'. $gift->slug .'/'. $gift->id .'" title="View product">
                                    <img src="/storage/gifts/'. $gift->gift_image .'" alt="'. $gift->gift_name .'" height="200" class="card-img-top">
                                </a>
                                <div class="overlay d-flex justify-content-around py-1">
                                    <div class="d-flex flex-column text-center" title="'. $gift->units .' In Stock">
                                        <i class="fa fa-home text-light"></i>
                                        <span class="text-light text-sm">'. $gift->units .'</span>
                                    </div>
                                    <div class="d-flex flex-column text-center" title="'. viewCounter($gift->id) .' Total Views">
                                        <i class="fa fa-eye text-light"></i>
                                        <span class="text-light text-sm">'. viewCounter($gift->id) .'</span>
                                    </div>
                                    <div class="d-flex flex-column text-center" title="Wishlisted by '. totalWishes($gift->id) .' customer(s)">
                                        '.$wishlist_icon.'
                                        <span class="text-light text-sm">'. totalWishes($gift->id) .'</span>
                                    </div>
                                    <div class="d-flex flex-column text-center" title="'. giftsSold($gift->id) .' gift(s) sold">
                                        <div class="d-flex align-items-center overlay-metric">
                                            <i class="fa fa-shopping-bag text-light"></i>
                                            <span class="badge badge-danger badge-pill overlay-badge">'. giftsSold($gift->id) .'</span>
                                        </div>
                                        <span class="text-light text-sm">Sold</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="card-body my-0 py-0">
                                    <div class="lh-100 mb-0 pb-0">
                                        <a href="details/'. $gift->slug .'/'. $gift->id .'">
                                            <p class="d-sm-none d-md-block font-600 text-capitalize mt-1 mb-0 py-0 product-name popover-info" id="'. $gift->id .'">
                                                '. Str::words($gift->gift_name, 2, '') .'
                                            </p>
                                            <p class="d-md-none font-600 text-capitalize mt-1 mb-0 py-0 product-name popover-info" id="'. $gift->id .'">
                                                '. Str::words($gift->gift_name, 1, '') .'
                                            </p>
                                        </a>
                                        <a href="/category/'. $gift->category_name .'" class="text-sm font-500 text-capitalize my-0 py-0">
                                            '. $gift->category_name .'
                                        </a>
                                        '. $star_rating .'
                                    </div>
                                    <div class="price-tag pull-up-1">
                                        <div class="usd-price">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="font-600">US$<span class="product-price">'. $usd_price .'</span></span>
                                                <div class="d-flex align-items-center before-prices">
                                                    <span class="font-600 text-muted strikethrough ml-1">US$'. $usd_before .'</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="zar-price d-none">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="font-600">R<span class="product-price">'. $zar_price .'</span></span>
                                                <div class="d-flex align-items-center before-prices">
                                                    <span class="font-600 text-muted strikethrough ml-1">R'. $zar_before .'</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="zwl-price d-none">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="font-600">ZW$<span class="product-price">'. $zwl_price .'</span></span>
                                                <div class="d-flex align-items-center before-prices">
                                                    <span class="font-600 text-muted strikethrough ml-1">$'. $zwl_before .'</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    '. $timer .'
                                    <div class="row justify-content-center w-100">
                                        <div class="btn-group btn-group-sm mt-0 pt-0 pulse">
                                            <button class="btn btn-primary btn-sm d-flex align-items-center add-to-cart-btn rounded-left" data-id="'. $gift->id .'">
                                                <i class="material-icons text-white mr-1 d-sm-none d-md-inline-block">add_shopping_cart</i>
                                                Buy <span class="text-white text-white ml-1">gift</span rounded-right>
                                            </button>
                                            <button class="btn border-primary btn-sm text-primary compare-btn d-flex align-items-center rounded-right" id="compare-btn'. $gift->id .'" data-name="'. $short_name .'" data-id="'. $gift->id .'">
                                                <i class="material-icons text-primary mr-1 d-sm-none d-md-inline-block">compare_arrows</i>
                                                Compare
                                            </button>
                                        </div>
                                    </div>
                                    <input value="'. $gift->id .'" id="gift_id" type="hidden">
                                    <input value="'. $gift->gift_name .'" id="name'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->label .'" id="label'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->gift_image .'" id="image'. $gift->id .'" type="hidden">
                                    <input value="'. $usd_price .'" id="usd-price'. $gift->id .'" type="hidden">
                                    <input value="'. $zar_price .'" id="zar-price'. $gift->id .'" type="hidden">
                                    <input value="'. $zwl_price .'" id="zwl-price'. $gift->id .'" type="hidden">
                                    <input value="'. $end_date .'" id="end-time'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->category_id .'" id="category-id'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->category_name .'" id="category-name'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->units .'" id="product-units'. $gift->id .'" type="hidden">
                                    <input value="1" id="quantity'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->description .'" id="description'. $gift->id .'" type="hidden">
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
                                ->take(5)
                                ->get();
                foreach($combo_gifts as $gift){
                    // Gift star rating
                    $star_rating = giftStarRating($gift->id);

                    // Gift sale percentage
                    $sale_percentage = $gift->sale_percentage;
                    
                    // Gift's short name to show on comparison pane
                    $short_name = mb_strimwidth($gift->gift_name, 0, 15, '...');

                    // Show if user customized or wishlisted the gift
                    if(isset(Auth::user()->id)){
                        $wishlist_icon = wishlistIcon($gift->id, Auth::user()->id);
                        if(!empty(customizedLabel($gift->id, Auth::user()->id))){
                            $gift_label = customizedLabel($gift->id, Auth::user()->id);
                        } else {
                            $gift_label = giftLabel($gift->id, round(100 * $gift->sale_percentage));
                        }
                    } else {
                        $wishlist_icon = '
                            <i role="button" class="fa fa-heart-o text-light guest-wishes" id="'. $gift->id .'" data-name="'. $gift->gift_name .'"></i>
                        ';
                        $gift_label = giftLabel($gift->id, round(100 * $gift->sale_percentage));
                    }

                    // Fetch sale end-date
                    $end_date = strtotime($gift->ends_on) * 1000;
                    $end_dates[] = $end_date;

                    // Determine if end date is greater than today
                    $date_diff = floor(abs(($end_date - $now) / (1000 * 3600 * 24)));

                    // Fetch all gif-ids
                    $gift_ids[] = $gift->id;

                    // Only show the timer if it's the gift item is on sale or hot-offer
                    if($gift->label == 'sale' || $gift->label == 'hot-offer'){
                        if($date_diff > 0){
                            // Discount the price when on sale
                            $sale_price = number_format($gift->usd_price - ($gift->usd_price * $sale_percentage), 2);

                            // Discounted prices
                            $usd_price = $sale_price;
                            $zar_price = number_format(($sale_price * zaRate()), 2);
                            $zwl_price = number_format(($sale_price * zwRate()), 2);

                            // The slashed price is the original price
                            $discount_price = $gift->usd_price;
                            $usd_before = number_format($discount_price, 2); 
                            $zar_before = number_format(($discount_price * zaRate()), 2);
                            $zwl_before = number_format(($discount_price * zwRate()), 2);

                            // Show countdown timer
                            $timer = '
                                <div class="d-flex align-items-center justify-content-between text-sm">
                                    <span><span class="d-sm-none d-md-inline-block">Sale</span>Ends:</span>
                                    <span class="ml-1 d-flex align-items-center" id="countdown-timer'.$gift->id.'">00d:00h:00m:00s</span>
                                </div>
                            ';
                        } else {
                            // Show that the sale is closed
                            $timer = '
                                <div class="sale-timer d-flex align-items-center justify-content-between text-sm pt-sm-2">
                                    <span><span class="d-sm-none d-md-inline-block">Sale</span>Ends:</span>
                                    <span class="ml-1 d-flex text-danger align-items-center" id="countdown-timer'.$gift->id.'">Sale closed</span>
                                </div>
                            ';

                            // Revert back to the old price without the sale percentage
                            $usd_price = number_format($gift->usd_price, 2);
                            $zar_price = number_format(($gift->usd_price * zaRate()), 2);
                            $zwl_price = number_format(($gift->usd_price * zwRate()), 2);

                            // Slashed prices 
                            $sale_price = number_format($gift->usd_price - ($gift->usd_price * 0.2), 2);
                            $usd_before = $sale_price; 
                            $zar_before = number_format(($sale_price * zaRate()), 2);
                            $zwl_before = number_format(($sale_price * zwRate()), 2);
                        }
                    } else {
                        $timer = '';

                        // Gift prices and currency rates
                        $usd_price = number_format($gift->usd_price, 2);
                        $zar_price = number_format(($gift->usd_price * zaRate()), 2);
                        $zwl_price = number_format(($gift->usd_price * zwRate()), 2);

                        // Slashed prices
                        $usd_before = number_format(($usd_price + ($usd_price * 0.275)), 2); 
                        $zar_before = number_format((($gift->usd_price * zaRate()) + (($gift->usd_price * zaRate()) * 0.275)), 2);
                        $zwl_before = number_format((($gift->usd_price * zwRate()) + (($gift->usd_price * zwRate()) * 0.275)), 2);
                    }

                    // Show the customize link if gift item is customizable
                    if($gift->label == 'customizable'){
                        $custom_link = '
                            <a href="#" class="nav-link icon-link toggle-customization" id="customize'.$gift->id.'" title="Customize gift" data-id="'. $gift->id .'">
                                <i class="material-icons">palette</i>
                            </a>
                        ';
                    }

                    $combos .= '
                        <!-- Product Card -->
                        <div class="card product-card rounded-2 box-shadow-sm" data-id="'.$gift->id.'">
                            <!-- Cart Actions -->
                            <div class="gift-cart-options bg-whitesmoke box-shadow-sm d-none" id="cart-options'.$gift->id.'">
                                <div class="d-flex align-items-center px-2">
                                    <div class="d-flex align-items-center justify-content-around m-0 p-0">
                                        <span role="button" class="product-actions material-icons text-success subtract-product" data-id="'.$gift->id.'" title="Decrease quantity">remove_circle</span>
                                        <span role="button" class="product-actions item-quantity text-faded" id="item-count'.$gift->id.'">0</span>
                                        <span role="button" class="product-actions material-icons text-success increase-qty" data-id="'.$gift->id.'" title="Increase quantity">add_circle</span>
                                    </div>
                                    <div class="ml-auto d-flex align-items-center">
                                        '.$custom_link.'
                                        <a href="#" class="nav-link icon-link text-danger remove-item ml-2" title="Remove Item" data-id="'.$gift->id.'">
                                            <i class="material-icons notifications">delete</i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- /.Cart Actions -->
                            <div class="product-img-wrapper">
                                '. $gift_label .'
                                <a href="details/'. $gift->slug .'/'. $gift->id .'" title="View product">
                                    <img src="/storage/gifts/'. $gift->gift_image .'" alt="'. $gift->gift_name .'" height="200" class="card-img-top">
                                </a>
                                <div class="overlay d-flex justify-content-around py-1">
                                    <div class="d-flex flex-column text-center" title="'. $gift->units .' In Stock">
                                        <i class="fa fa-home text-light"></i>
                                        <span class="text-light text-sm">'. $gift->units .'</span>
                                    </div>
                                    <div class="d-flex flex-column text-center" title="'. viewCounter($gift->id) .' Total Views">
                                        <i class="fa fa-eye text-light"></i>
                                        <span class="text-light text-sm">'. viewCounter($gift->id) .'</span>
                                    </div>
                                    <div class="d-flex flex-column text-center" title="Wishlisted by '. totalWishes($gift->id) .' customer(s)">
                                        '.$wishlist_icon.'
                                        <span class="text-light text-sm">'. totalWishes($gift->id) .'</span>
                                    </div>
                                    <div class="d-flex flex-column text-center" title="'. giftsSold($gift->id) .' gift(s) sold">
                                        <div class="d-flex align-items-center overlay-metric">
                                            <i class="fa fa-shopping-bag text-light"></i>
                                            <span class="badge badge-danger badge-pill overlay-badge">'. giftsSold($gift->id) .'</span>
                                        </div>
                                        <span class="text-light text-sm">Sold</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="card-body my-0 py-0">
                                    <div class="lh-100 mb-0 pb-0">
                                        <a href="details/'. $gift->slug .'/'. $gift->id .'">
                                            <p class="d-sm-none d-md-block font-600 text-capitalize mt-1 mb-0 py-0 product-name popover-info" id="'. $gift->id .'">
                                                '. Str::words($gift->gift_name, 2, '') .'
                                            </p>
                                            <p class="d-md-none font-600 text-capitalize mt-1 mb-0 py-0 product-name popover-info" id="'. $gift->id .'">
                                                '. Str::words($gift->gift_name, 1, '') .'
                                            </p>
                                        </a>
                                        <a href="/category/'. $gift->category_name .'" class="text-sm font-500 text-capitalize my-0 py-0">
                                            '. $gift->category_name .'
                                        </a>
                                        '. $star_rating .'
                                    </div>
                                    <div class="price-tag pull-up-1">
                                        <div class="usd-price">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="font-600">US$<span class="product-price">'. $usd_price .'</span></span>
                                                <div class="d-flex align-items-center before-prices">
                                                    <span class="font-600 text-muted strikethrough ml-1">US$'. $usd_before .'</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="zar-price d-none">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="font-600">R<span class="product-price">'. $zar_price .'</span></span>
                                                <div class="d-flex align-items-center before-prices">
                                                    <span class="font-600 text-muted strikethrough ml-1">R'. $zar_before .'</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="zwl-price d-none">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="font-600">ZW$<span class="product-price">'. $zwl_price .'</span></span>
                                                <div class="d-flex align-items-center before-prices">
                                                    <span class="font-600 text-muted strikethrough ml-1">$'. $zwl_before .'</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    '. $timer .'
                                    <div class="row justify-content-center w-100">
                                        <div class="btn-group btn-group-sm mt-0 pt-0 pulse">
                                            <button class="btn btn-primary btn-sm d-flex align-items-center add-to-cart-btn rounded-left" data-id="'. $gift->id .'">
                                                <i class="material-icons text-white mr-1 d-sm-none d-md-inline-block">add_shopping_cart</i>
                                                Buy <span class="text-white text-white ml-1">gift</span rounded-right>
                                            </button>
                                            <button class="btn border-primary btn-sm text-primary compare-btn d-flex align-items-center rounded-right" id="compare-btn'. $gift->id .'" data-name="'. $short_name .'" data-id="'. $gift->id .'">
                                                <i class="material-icons text-primary mr-1 d-sm-none d-md-inline-block">compare_arrows</i>
                                                Compare
                                            </button>
                                        </div>
                                    </div>
                                    <input value="'. $gift->id .'" id="gift_id" type="hidden">
                                    <input value="'. $gift->gift_name .'" id="name'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->label .'" id="label'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->gift_image .'" id="image'. $gift->id .'" type="hidden">
                                    <input value="'. $usd_price .'" id="usd-price'. $gift->id .'" type="hidden">
                                    <input value="'. $zar_price .'" id="zar-price'. $gift->id .'" type="hidden">
                                    <input value="'. $zwl_price .'" id="zwl-price'. $gift->id .'" type="hidden">
                                    <input value="'. $end_date .'" id="end-time'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->category_id .'" id="category-id'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->category_name .'" id="category-name'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->units .'" id="product-units'. $gift->id .'" type="hidden">
                                    <input value="1" id="quantity'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->description .'" id="description'. $gift->id .'" type="hidden">
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
                                ->take(5)
                                ->get();
                foreach($appliances as $gift){
                    // Gift star rating
                    $star_rating = giftStarRating($gift->id);

                    // Gift sale percentage
                    $sale_percentage = $gift->sale_percentage;
                    
                    // Gift's short name to show on comparison pane
                    $short_name = mb_strimwidth($gift->gift_name, 0, 15, '...');

                    // Show if user customized or wishlisted the gift
                    if(isset(Auth::user()->id)){
                        $wishlist_icon = wishlistIcon($gift->id, Auth::user()->id);
                        if(!empty(customizedLabel($gift->id, Auth::user()->id))){
                            $gift_label = customizedLabel($gift->id, Auth::user()->id);
                        } else {
                            $gift_label = giftLabel($gift->id, round(100 * $gift->sale_percentage));
                        }
                    } else {
                        $wishlist_icon = '
                            <i role="button" class="fa fa-heart-o text-light guest-wishes" id="'. $gift->id .'" data-name="'. $gift->gift_name .'"></i>
                        ';
                        $gift_label = giftLabel($gift->id, round(100 * $gift->sale_percentage));
                    }

                    // Fetch sale end-date
                    $end_date = strtotime($gift->ends_on) * 1000;
                    $end_dates[] = $end_date;

                    // Determine if end date is greater than today
                    $date_diff = floor(abs(($end_date - $now) / (1000 * 3600 * 24)));

                    // Fetch all gif-ids
                    $gift_ids[] = $gift->id;

                    // Only show the timer if it's the gift item is on sale or hot-offer
                    if($gift->label == 'sale' || $gift->label == 'hot-offer'){
                        if($date_diff > 0){
                            // Discount the price when on sale
                            $sale_price = number_format($gift->usd_price - ($gift->usd_price * $sale_percentage), 2);

                            // Discounted prices
                            $usd_price = $sale_price;
                            $zar_price = number_format(($sale_price * zaRate()), 2);
                            $zwl_price = number_format(($sale_price * zwRate()), 2);

                            // The slashed price is the original price
                            $discount_price = $gift->usd_price;
                            $usd_before = number_format($discount_price, 2); 
                            $zar_before = number_format(($discount_price * zaRate()), 2);
                            $zwl_before = number_format(($discount_price * zwRate()), 2);

                            // Show countdown timer
                            $timer = '
                                <div class="d-flex align-items-center justify-content-between text-sm">
                                    <span><span class="d-sm-none d-md-inline-block">Sale</span>Ends:</span>
                                    <span class="ml-1 d-flex align-items-center" id="countdown-timer'.$gift->id.'">00d:00h:00m:00s</span>
                                </div>
                            ';
                        } else {
                            // Show that the sale is closed
                            $timer = '
                                <div class="sale-timer d-flex align-items-center justify-content-between text-sm pt-sm-2">
                                    <span><span class="d-sm-none d-md-inline-block">Sale</span>Ends:</span>
                                    <span class="ml-1 d-flex text-danger align-items-center" id="countdown-timer'.$gift->id.'">Sale closed</span>
                                </div>
                            ';

                            // Revert back to the old price without the sale percentage
                            $usd_price = number_format($gift->usd_price, 2);
                            $zar_price = number_format(($gift->usd_price * zaRate()), 2);
                            $zwl_price = number_format(($gift->usd_price * zwRate()), 2);

                            // Slashed prices 
                            $sale_price = number_format($gift->usd_price - ($gift->usd_price * 0.2), 2);
                            $usd_before = $sale_price; 
                            $zar_before = number_format(($sale_price * zaRate()), 2);
                            $zwl_before = number_format(($sale_price * zwRate()), 2);
                        }
                    } else {
                        $timer = '';

                        // Gift prices and currency rates
                        $usd_price = number_format($gift->usd_price, 2);
                        $zar_price = number_format(($gift->usd_price * zaRate()), 2);
                        $zwl_price = number_format(($gift->usd_price * zwRate()), 2);

                        // Slashed prices
                        $usd_before = number_format(($usd_price + ($usd_price * 0.275)), 2); 
                        $zar_before = number_format((($gift->usd_price * zaRate()) + (($gift->usd_price * zaRate()) * 0.275)), 2);
                        $zwl_before = number_format((($gift->usd_price * zwRate()) + (($gift->usd_price * zwRate()) * 0.275)), 2);
                    }

                    // Show the customize link if gift item is customizable
                    if($gift->label == 'customizable'){
                        $custom_link = '
                            <a href="#" class="nav-link icon-link toggle-customization" id="customize'.$gift->id.'" title="Customize gift" data-id="'. $gift->id .'">
                                <i class="material-icons">palette</i>
                            </a>
                        ';
                    }

                    $appliance_gifts .= '
                        <!-- Product Card -->
                        <div class="card product-card rounded-2 box-shadow-sm" data-id="'.$gift->id.'">
                            <!-- Cart Actions -->
                            <div class="gift-cart-options bg-whitesmoke box-shadow-sm d-none" id="cart-options'.$gift->id.'">
                                <div class="d-flex align-items-center px-2">
                                    <div class="d-flex align-items-center justify-content-around m-0 p-0">
                                        <span role="button" class="product-actions material-icons text-success subtract-product" data-id="'.$gift->id.'" title="Decrease quantity">remove_circle</span>
                                        <span role="button" class="product-actions item-quantity text-faded" id="item-count'.$gift->id.'">0</span>
                                        <span role="button" class="product-actions material-icons text-success increase-qty" data-id="'.$gift->id.'" title="Increase quantity">add_circle</span>
                                    </div>
                                    <div class="ml-auto d-flex align-items-center">
                                        '.$custom_link.'
                                        <a href="#" class="nav-link icon-link text-danger remove-item ml-2" title="Remove Item" data-id="'.$gift->id.'">
                                            <i class="material-icons notifications">delete</i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- /.Cart Actions -->
                            <div class="product-img-wrapper">
                                '. $gift_label .'
                                <a href="details/'. $gift->slug .'/'. $gift->id .'" title="View product">
                                    <img src="/storage/gifts/'. $gift->gift_image .'" alt="'. $gift->gift_name .'" height="200" class="card-img-top">
                                </a>
                                <div class="overlay d-flex justify-content-around py-1">
                                    <div class="d-flex flex-column text-center" title="'. $gift->units .' In Stock">
                                        <i class="fa fa-home text-light"></i>
                                        <span class="text-light text-sm">'. $gift->units .'</span>
                                    </div>
                                    <div class="d-flex flex-column text-center" title="'. viewCounter($gift->id) .' Total Views">
                                        <i class="fa fa-eye text-light"></i>
                                        <span class="text-light text-sm">'. viewCounter($gift->id) .'</span>
                                    </div>
                                    <div class="d-flex flex-column text-center" title="Wishlisted by '. totalWishes($gift->id) .' customer(s)">
                                        '.$wishlist_icon.'
                                        <span class="text-light text-sm">'. totalWishes($gift->id) .'</span>
                                    </div>
                                    <div class="d-flex flex-column text-center" title="'. giftsSold($gift->id) .' gift(s) sold">
                                        <div class="d-flex align-items-center overlay-metric">
                                            <i class="fa fa-shopping-bag text-light"></i>
                                            <span class="badge badge-danger badge-pill overlay-badge">'. giftsSold($gift->id) .'</span>
                                        </div>
                                        <span class="text-light text-sm">Sold</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="card-body my-0 py-0">
                                    <div class="lh-100 mb-0 pb-0">
                                        <a href="details/'. $gift->slug .'/'. $gift->id .'">
                                            <p class="d-sm-none d-md-block font-600 text-capitalize mt-1 mb-0 py-0 product-name popover-info" id="'. $gift->id .'">
                                                '. Str::words($gift->gift_name, 2, '') .'
                                            </p>
                                            <p class="d-md-none font-600 text-capitalize mt-1 mb-0 py-0 product-name popover-info" id="'. $gift->id .'">
                                                '. Str::words($gift->gift_name, 1, '') .'
                                            </p>
                                        </a>
                                        <a href="/category/'. $gift->category_name .'" class="text-sm font-500 text-capitalize my-0 py-0">
                                            '. $gift->category_name .'
                                        </a>
                                        '. $star_rating .'
                                    </div>
                                    <div class="price-tag pull-up-1">
                                        <div class="usd-price">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="font-600">US$<span class="product-price">'. $usd_price .'</span></span>
                                                <div class="d-flex align-items-center before-prices">
                                                    <span class="font-600 text-muted strikethrough ml-1">US$'. $usd_before .'</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="zar-price d-none">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="font-600">R<span class="product-price">'. $zar_price .'</span></span>
                                                <div class="d-flex align-items-center before-prices">
                                                    <span class="font-600 text-muted strikethrough ml-1">R'. $zar_before .'</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="zwl-price d-none">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="font-600">ZW$<span class="product-price">'. $zwl_price .'</span></span>
                                                <div class="d-flex align-items-center before-prices">
                                                    <span class="font-600 text-muted strikethrough ml-1">$'. $zwl_before .'</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    '. $timer .'
                                    <div class="row justify-content-center w-100">
                                        <div class="btn-group btn-group-sm mt-0 pt-0 pulse">
                                            <button class="btn btn-primary btn-sm d-flex align-items-center add-to-cart-btn rounded-left" data-id="'. $gift->id .'">
                                                <i class="material-icons text-white mr-1 d-sm-none d-md-inline-block">add_shopping_cart</i>
                                                Buy <span class="text-white text-white ml-1">gift</span rounded-right>
                                            </button>
                                            <button class="btn border-primary btn-sm text-primary compare-btn d-flex align-items-center rounded-right" id="compare-btn'. $gift->id .'" data-name="'. $short_name .'" data-id="'. $gift->id .'">
                                                <i class="material-icons text-primary mr-1 d-sm-none d-md-inline-block">compare_arrows</i>
                                                Compare
                                            </button>
                                        </div>
                                    </div>
                                    <input value="'. $gift->id .'" id="gift_id" type="hidden">
                                    <input value="'. $gift->gift_name .'" id="name'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->label .'" id="label'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->gift_image .'" id="image'. $gift->id .'" type="hidden">
                                    <input value="'. $usd_price .'" id="usd-price'. $gift->id .'" type="hidden">
                                    <input value="'. $zar_price .'" id="zar-price'. $gift->id .'" type="hidden">
                                    <input value="'. $zwl_price .'" id="zwl-price'. $gift->id .'" type="hidden">
                                    <input value="'. $end_date .'" id="end-time'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->category_id .'" id="category-id'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->category_name .'" id="category-name'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->units .'" id="product-units'. $gift->id .'" type="hidden">
                                    <input value="1" id="quantity'. $gift->id .'" type="hidden">
                                    <input value="'. $gift->description .'" id="description'. $gift->id .'" type="hidden">
                                </div>
                            </div>
                        </div>
                        <!-- /.Product Card -->
                    ';
                }
                // $viewed_gifts = $request->session()->get('viewed-gifts', []);
                // if($request->session()->has('viewed-gifts')){
                //     foreach($viewed_gifts as $key => $value){
                //         // Gift star rating
                //         $star_rating = giftStarRating($viewed_gifts[$key]);
                //         $usd_before = number_format(($value['usd_price'] + ($value['usd_price'] * 0.275)), 2); 
                //         $zar_before = number_format(($value['zar_price'] + ($value['zar_price'] * 0.275)), 2);
                //         $zwl_before = number_format(($value['zwl_price'] + ($value['zwl_price'] * 0.275)), 2);
                //         $short_name = mb_strimwidth($value['gift_name'], 0, 15, '...');

                //         if(isset(Auth::user()->id)){
                //             $wishlist_icon = wishlistIcon($viewed_gifts[$key], Auth::user()->id);
                //             if(!empty(customizedLabel($viewed_gifts[$key], Auth::user()->id))){
                //                 $gift_label = customizedLabel($viewed_gifts[$key], Auth::user()->id);
                //             } else {
                //                 $gift_label = giftLabel($viewed_gifts[$key]);
                //             }
                //         } else {
                //             $wishlist_icon = '
                //                 <i role="button" class="fa fa-heart-o text-light guest-wishes" id="'. $gift->id .'" data-name="'. $gift->gift_name .'"></i>
                //             ';
                //             $gift_label = giftLabel($viewed_gifts[$key]);
                //         }

                //         // Fetch sale end-date
                //         $end_dates[] = strtotime($value['ends_on']) * 1000;
                //         $now = time() * 1000;

                //         // Fetch all gif-ids
                //         $gift_ids[] = $viewed_gifts[$key];

                //         if($value['label'] == 'customizable'){
                //             $custom_link = '
                //                 <a href="#" class="nav-link icon-link toggle-customization" id="customize'.$viewed_gifts[$key].'" title="Customize gift" data-id="'. $viewed_gifts[$key] .'">
                //                     <i class="material-icons notifications">palette</i>
                //                 </a>
                //             ';
                //         }

                //         $browsed_gifts .= '
                //             <!-- Product Card -->
                //             <div class="card product-card rounded-2 box-shadow-sm" data-id="'.$viewed_gifts[$key].'">
                //                 <!-- Cart Actions -->
                //                 <div class="gift-cart-options bg-whitesmoke box-shadow-sm d-none" id="cart-options'.$viewed_gifts[$key].'">
                //                     <div class="d-flex align-items-center px-2">
                //                         <div class="d-flex align-items-center justify-content-around m-0 p-0">
                //                             <span role="button" class="product-actions material-icons text-success subtract-product" data-id="'.$viewed_gifts[$key].'" title="Decrease quantity">remove_circle</span>
                //                             <span role="button" class="product-actions item-quantity text-faded" id="item-count'.$viewed_gifts[$key].'">0</span>
                //                             <span role="button" class="product-actions material-icons text-success increase-qty" data-id="'.$viewed_gifts[$key].'" title="Increase quantity">add_circle</span>
                //                         </div>
                //                         <div class="ml-auto d-flex align-items-center">
                //                             '.$custom_link.'
                //                             <a href="#" class="nav-link icon-link text-danger remove-item ml-2" title="Remove Item" data-id="'.$viewed_gifts[$key].'">
                //                                 <i class="material-icons notifications">delete</i>
                //                             </a>
                //                         </div>
                //                     </div>
                //                 </div>
                //                 <!-- /.Cart Actions -->
                //                 <div class="product-img-wrapper">
                //                     '. $gift_label .'
                //                     <a href="details/'. $value['slug'] .'/'. $viewed_gifts[$key] .'" title="View product">
                //                         <img src="/storage/gifts/'. $value['gift_image'] .'" alt="'. $value['gift_name'] .'" height="200" class="card-img-top">
                //                     </a>
                //                     <div class="overlay d-flex justify-content-around py-1">
                //                         <div class="d-flex flex-column text-center" title="'. viewCounter($viewed_gifts[$key]) .' Total Views">
                //                             <i class="fa fa-eye text-light"></i>
                //                             <span class="text-light text-sm">'. viewCounter($viewed_gifts[$key]) .'</span>
                //                         </div>
                //                         <div class="d-flex flex-column text-center" title="Wishlisted by '. totalWishes($viewed_gifts[$key]) .' customer(s)">
                //                             '.$wishlist_icon.'
                //                             <span class="text-light text-sm">'. totalWishes($viewed_gifts[$key]) .'</span>
                //                         </div>
                //                         <div class="d-flex flex-column text-center" title="'. giftsSold($viewed_gifts[$key]) .' gift(s) sold">
                //                             <div class="d-flex align-items-center overlay-metric">
                //                                 <i class="fa fa-shopping-bag text-light"></i>
                //                                 <span class="badge badge-danger badge-pill overlay-badge">'. giftsSold($viewed_gifts[$key]) .'</span>
                //                             </div>
                //                             <span class="text-light text-sm">Sold</span>
                //                         </div>
                //                         <div class="d-flex flex-column text-center" title="Items that go with this gift">
                //                             <div class="d-flex align-items-center overlay-metric">
                //                                 <i class="fa fa-puzzle-piece text-light"></i>
                //                                 <span class="badge badge-danger badge-pill overlay-badge">'. countRatings($viewed_gifts[$key]) .'</span>
                //                             </div>
                //                             <span class="text-light text-sm">Add-ons</span>
                //                         </div>
                //                     </div>
                //                 </div>
                //                 <div class="card-content">
                //                     <div class="card-body my-0 py-0">
                //                         <div class="lh-100 mb-0 pb-0">
                //                             <a href="details/'. $value['slug'] .'/'. $viewed_gifts[$key] .'">
                //                                 <p class="font-600 text-capitalize mt-1 mb-0 py-0 product-name popover-info" id="'. $viewed_gifts[$key] .'">
                //                                     '. Str::words($value['gift_name'], 2, '') .'
                //                                 </p>
                //                             </a>
                //                             <a href="/category/'. $value['category_name'] .'" class="text-sm font-500 text-capitalize my-0 py-0">
                //                                 '. $value['category_name'] .'
                //                             </a>
                //                             '. $star_rating .'
                //                         </div>
                //                         <div class="pull-up-1">
                //                             <div class="usd-price">
                //                                 <div class="d-flex align-items-center justify-content-between">
                //                                     <span class="font-600">US$<span class="product-price">'. number_format($value['usd_price'], 2) .'</span></span>
                //                                     <div class="d-flex align-items-center before-prices">
                //                                         <span class="font-600 text-muted strikethrough ml-1">US$'. $usd_before .'</span>
                //                                     </div>
                //                                 </div>
                //                             </div>
                //                             <div class="zar-price d-none">
                //                                 <div class="d-flex align-items-center justify-content-between">
                //                                     <span class="font-600">R<span class="product-price">'. number_format($value['zar_price'], 2) .'</span></span>
                //                                     <div class="d-flex align-items-center before-prices">
                //                                         <span class="font-600 text-muted strikethrough ml-1">R'. $zar_before .'</span>
                //                                     </div>
                //                                 </div>
                //                             </div>
                //                             <div class="zwl-price d-none">
                //                                 <div class="d-flex align-items-center justify-content-between">
                //                                     <span class="font-600">ZW$<span class="product-price">'. number_format($value['zwl_price'], 2) .'</span></span>
                //                                     <div class="d-flex align-items-center before-prices">
                //                                         <span class="font-600 text-muted strikethrough ml-1">$'. $zwl_before .'</span>
                //                                     </div>
                //                                 </div>
                //                             </div>
                //                         </div>
                //                         <div class="d-flex align-items-center justify-content-between text-sm">
                //                             <span><span class="d-sm-none d-md-inline-block">Sale</span>Ends:</span>
                //                             <span class="ml-1 d-flex align-items-center" id="countdown-timer'.$viewed_gifts[$key].'">00d:00h:00m:00s</span>
                //                         </div>
                //                         <div class="row justify-content-center w-100">
                //                             <div class="btn-group btn-group-sm mt-0 pt-0 pulse">
                //                                 <button class="btn btn-primary btn-sm d-flex align-items-center add-to-cart-btn rounded-left" data-id="'. $viewed_gifts[$key] .'">
                //                                     <i class="material-icons text-white mr-1 d-sm-none d-md-inline-block">add_shopping_cart</i>
                //                                     Buy <span class="text-white text-white ml-1">gift</span>
                //                                 </button>
                //                                 <button class="btn border-primary btn-sm text-primary compare-btn d-flex align-items-center rounded-right" id="compare-btn'. $viewed_gifts[$key] .'" data-name="'. $short_name .'" data-id="'. $viewed_gifts[$key] .'">
                //                                     <i class="material-icons text-primary mr-1 d-sm-none d-md-inline-block">compare_arrows</i>
                //                                     Compare
                //                                 </button>
                //                             </div>
                //                         </div>
                //                         <input value="'. $viewed_gifts[$key] .'" id="gift_id" type="hidden">
                //                         <input value="'. $value['gift_name'] .'" id="name'. $viewed_gifts[$key] .'" type="hidden">
                //                         <input value="'. $value['label'] .'" id="label'. $viewed_gifts[$key] .'" type="hidden">
                //                         <input value="'. $value['gift_image'] .'" id="image'. $viewed_gifts[$key] .'" type="hidden">
                //                         <input value="'. $value['usd_price'] .'" id="usd-price'. $viewed_gifts[$key] .'" type="hidden">
                //                         <input value="'. $value['zar_price'] .'" id="zar-price'. $viewed_gifts[$key] .'" type="hidden">
                //                         <input value="'. $value['zwl_price'] .'" id="zwl-price'. $viewed_gifts[$key] .'" type="hidden">
                //                         <input value="'. strtotime($value['ends_on']) * 1000 .'" id="end-time'. $viewed_gifts[$key] .'" type="hidden">
                //                         <input value="'. $value['category_id'] .'" id="category-id'. $viewed_gifts[$key] .'" type="hidden">
                //                         <input value="'. $value['category_name'] .'" id="category-name'. $viewed_gifts[$key] .'" type="hidden">
                //                         <input value="'. $value['units'] .'" id="product-units'. $viewed_gifts[$key] .'" type="hidden">
                //                         <input value="1" id="quantity'. $viewed_gifts[$key] .'" type="hidden">
                //                         <input value="'. $value['description'] .'" id="description'. $viewed_gifts[$key] .'" type="hidden">
                //                     </div>
                //                 </div>
                //             </div>
                //             <!-- /.Product Card -->
                //         ';
                //     }
                // }
                $data = [
                    'message'          => 'success',
                    'customized_gifts' => $customized_gifts, 
                    'kitchenware'      => $kitchenware_gifts,
                    'personal_care'    => $care_gifts,
                    'plasticware'      => $plasticware_gifts,
                    'combo_gifts'      => $combos, 
                    'appliances'       => $appliance_gifts,
                    'viewed_gifts'     => $browsed_gifts,
                    'countdown_date'   => $end_dates,
                    'now'              => $now,
                    'gift_ids'         => $gift_ids
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
                $comparisons = Session::get('comparisons', []);
                $count = count($comparisons);

                $gift_id = $request->gift_id;

                // Create a gift item array
                $item = [
                    'gift_id'          => $gift_id,
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

                // Check if comparisons session is set
                if($count < 3){
                    if(Session::has('comparisons')){
                        if(array_key_exists($gift_id, $comparisons)){
                            Session::put('comparisons', $comparisons);
                        } else {
                            $comparisons = [
                                $gift_id => $item
                            ];
                            Session::put('comparisons', $comparisons);
                        }
                    } else {
                        $comparisons = [
                            $gift_id => $item
                        ];
                        Session::put('comparisons', $comparisons);
                    }
                }
                $count = count($comparisons);
                return response()->json([
                    'message' => 'success',
                    'data'    => $comparisons,
                    'count'   => $count
                ]);
            }
        }
    }

    // Remove a gift from the comparison session
    public function remove_comparison(Request $request)
    {
        if($request->ajax()){
            if($request->action == 'remove-comparison'){
                // Retrieve the whole comparison session
                $comparisons = Session::get('comparisons', []);
                unset($comparisons[$request->gift_id]);
                Session::put('comparisons', $comparisons);
                return response()->json([
                    'message' => 'success',
                    'data'    => $comparisons
                ]);
            }
        }
    }

    // Clear the comparisons session
    public function clear_comparisons(Request $request)
    {
        if($request->ajax()){
            if($request->action == 'clear-comparisons'){
                if(Session::has('comparisons')){
                    Session::forget('comparisons');
                    Session::save();
                    return response()->json([
                        'message' => 'session-cleared'
                    ]);
                }
            }
        }
    }

    // Compare gifts comparisons page
    public function compare_page()
    {
        $data = [
            'title'       => 'Gift Comparisons',
            'comparisons' => session('comparisons')
        ];
        return view('compare_page')->with($data);
    }

    // Fetch gift's popover info
    public function popoverInfo(Request $request)
    {
        if($request->ajax()){
            if($request->action == 'gift-info'){
                $gift_id = $request->gift_id;
                $gift = Gift::find($gift_id);

                $output = '
                    <!-- Gift Popover Info -->
                    <div class="popover-card card border-0 rounded-0">
                        <div class="card-img-top rounded-0">
                            <div class="d-grid grid-2">
                                <img src="/storage/gifts/'. $gift->gift_image .'" height="150" class="popover-img w-100">
                            </div>
                        </div>
                        <div class="card-body border-top border-bottom lh-100">
                            <div class="d-flex align-items-center">
                                <div class="d-block">
                                    <h6 class="lead my-0 py-0 font-600 text-capitalize">'. $gift->gift_name .'</h6>
                                    <p class="text-muted text-capitalize my-0 py-0 font-500">'. categoryName($gift_id) .'</p>
                                    '. giftStarRating($gift_id) .'
                                </div>
                                <div class="ml-auto">
                                    <a role="button" href="details.php?id='. $gift_id .'" class="btn btn-sm border-primary text-primary rounded-pill px-4">View</a>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-around w-100 my-1 border-bottom">
                            <div class="d-block text-center">
                                <div class="d-flex align-items-center justify-content-center">
                                    <i class="material-icons text-faded">add_shopping_cart</i>
                                    <span class="text-faded font-600">'. giftsSold($gift->id) .'</span>
                                </div>
                                <span class="text-muted">Items sold</span>
                            </div>
                            <div class="d-block text-center">
                                <div class="d-flex align-items-center justify-content-center">
                                    <i class="material-icons text-faded">account_balance_wallet</i>
                                    <span class="text-faded font-600 usd-price">US$'.number_format(totalproductAmt($gift_id), 2).'</span>
                                    <span class="text-faded font-600 zar-price d-none">R'.number_format(totalproductAmt($gift_id) * zaRate(), 2).'</span>
                                    <span class="text-faded font-600 zwl-price d-none">ZW$'.number_format(totalproductAmt($gift_id) * zwRate(), 2).'</span>
                                </div>
                                <span class="text-muted">Total Sold</span>
                            </div>
                            <div class="d-block text-center">
                                <div class="d-flex align-items-center justify-content-center">
                                    <i class="material-icons text-faded">favorite</i>
                                    <span class="text-faded font-600">'.totalWishes($gift_id).'</span>
                                </div>
                                <span class="text-muted">Total Wishes</span>
                            </div>
                        </div>
                        <div class="card-footer border-0 bg-transparent">
                            <p class="text-justify text-faded">
                                '.mb_strimwidth($gift->description, 0, 400, '...<a href="details.php?id='. $gift_id .'" class="font-600">Read more</a>').'
                            </p>
                        </div>
                    </div>
                    <!-- /.Gift Popover Info -->
                ';
                return response()->json([
                    'content' => $output
                ]);
            }
        }
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
                    'reviews'         => $output
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

    // Increment the gift view table
    public function giftViews(Request $request)
    {
        if($request->ajax()){
            if($request->action == 'viewed-gift'){
                $gift_id = $request->gift_id;

                // Create an array from the given gift_id
                $item = Gift::find($gift_id);

                // Increment the view column when the gift item is viewed
                $item->increment('views');

                // Get the session of all user's viewed gifts
                $viewed_gifts = $request->session()->get('viewed-gifts', []);

                if($request->session()->has('viewed-gifts')){
                    if(!in_array($gift_id, $viewed_gifts)){
                        // if the session is empty then this the first gift
                        $viewed_gifts[$gift_id] = $item;
                        $request->session()->push('viewed-gifts', $viewed_gifts);
                    }
                } else {
                    // if the session is empty then this the first gift
                    $viewed_gifts = [
                        $gift_id => $item
                    ];
                    $request->session()->put('viewed-gifts', $viewed_gifts);
                }
                return response()->json([
                    'viewed_gifts' => $viewed_gifts,
                    'count'        => count($viewed_gifts)
                ]);
            }
        }
    }
}
