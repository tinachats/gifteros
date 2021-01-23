<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Categories extends Controller
{
    /**
     * Display a listing of the resource.
     * @param  string  $category
     * @param int $category_id
     */
    public function index($category_id, $category)
    {   
        $sub_categories = DB::table('sub_categories')
                            ->join('gifts', 'gifts.sub_category_id', '=', 'sub_categories.id')
                            ->select('sub_categories.*')
                            ->where('sub_categories.category_id', $category_id)
                            ->distinct()
                            ->get();
        $data = [
            'category_id'    =>$category_id,   
            'sub_categories' => $sub_categories,
            'title'          => ucfirst($category .' Gifts')
        ];
        return view('category')->with($data);
    }

     /**
     * Display the specified resource.
     *
     * @param int $category_id
     * @return \Illuminate\Http\Response
     */
    public function gifts(Request $request)
    {
        if($request->ajax()){
            if($request->action == 'category-gifts'){
                $output = $gift_count = $gift_label = '';
                $timer = $custom_link = '';
                $end_dates = $gift_ids = $result = [];
                $date_diff =  $count = 0;

                // Current time
                $now = time() * 1000;

                $filter = $request->filter;
                $filter_rating = $request->rating;
                $category_id = $request->category_id;
                $sub_category_id = $request->sub_category_id;

                $main_query = DB::table('gifts')
                                ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                ->select('gifts.*', 'gifts.id as gift_id', 'gifts.slug as gift_slug', 'categories.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                ->where('gifts.category_id', $category_id);

                // Filter category gifts by the created_at date (desc)
                if(!empty($request->latest) && $request->latest == 'created_at'){
                    $query = $main_query
                                ->orderBy('gifts.created_at', 'desc')
                                ->distinct();
                    $result = $query->get();
                    $count = $query->count();
                }

                // Filter category gifts by their wishlist rankings
                if(!empty($request->likes) && $request->likes == 'top-wishlisted'){
                    $result = DB::table('gifts')
                                ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                ->join('wishlist', 'wishlist.gift_id', '=', 'gifts.id')
                                ->select('gifts.*', 'gifts.id as gift_id', 'gifts.slug as gift_slug', 'categories.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                ->where('gifts.category_id', $category_id)
                                ->whereIn('gifts.id', wishlistedGifts())
                                ->orderBy('usd_price', $request->price_ordering)
                                ->distinct()
                                ->get();
                    $count = DB::table('gifts')
                                ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                ->join('wishlist', 'wishlist.gift_id', '=', 'gifts.id')
                                ->select('gifts.*', 'gifts.id as gift_id', 'gifts.slug as gift_slug', 'categories.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                ->where('gifts.category_id', $category_id)
                                ->whereIn('gifts.id', wishlistedGifts())
                                ->count();
                }

                // Filter category gifts by their wishlist rankings
                if(!empty($request->trending) && $request->trending == 'top-sold'){
                    $result = $main_query
                                ->whereIn('gifts.id', orderedGifts())
                                ->orderBy('usd_price', $request->price_ordering)
                                ->distinct()
                                ->get();
                    $count = $main_query
                                ->whereIn('gifts.id', orderedGifts())
                                ->distinct()
                                ->count();
                }

                // Filter category gifts by their sub-category
                if(isset($request->sub_category_id)){
                    $result = DB::table('gifts')
                                ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                ->select('gifts.*', 'gifts.id as gift_id', 'gifts.slug as gift_slug', 'categories.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                ->where('gifts.sub_category_id', $request->sub_category_id)
                                ->orderBy('usd_price', $request->price_ordering)
                                ->distinct()
                                ->get();
                    $count = DB::table('gifts')
                                ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                ->select('gifts.*', 'gifts.id as gift_id', 'gifts.slug as gift_slug', 'categories.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                ->where('gifts.sub_category_id', $request->sub_category_id)
                                ->distinct()
                                ->count();
                }

                // Filter category gifts by price
                if(isset($filter)){
                    if($filter == 'under-25'){
                        $result = DB::table('gifts')
                                    ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                    ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                    ->select('gifts.*', 'gifts.id as gift_id', 'gifts.slug as gift_slug', 'categories.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                    ->where([
                                        ['gifts.category_id', '=', $category_id],
                                        ['usd_price', '<', 25]
                                    ])
                                    ->orderBy('usd_price', $request->price_ordering)
                                    ->distinct()
                                    ->get();
                        $count = DB::table('gifts')
                                    ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                    ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                    ->select('gifts.*', 'gifts.id as gift_id', 'gifts.slug as gift_slug', 'categories.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                    ->where([
                                        ['gifts.category_id', '=', $category_id],
                                        ['usd_price', '<', 25]
                                    ])
                                    ->distinct()
                                    ->count();
                    } else if($filter == '5-to-20'){
                        $result = DB::table('gifts')
                                    ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                    ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                    ->select('gifts.*', 'gifts.id as gift_id', 'gifts.slug as gift_slug', 'categories.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                    ->where('gifts.category_id', $category_id)
                                    ->whereBetween('usd_price', [5, 20])
                                    ->orderBy('usd_price', $request->price_ordering)
                                    ->distinct()
                                    ->get();
                        $count = DB::table('gifts')
                                    ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                    ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                    ->select('gifts.*', 'gifts.id as gift_id', 'gifts.slug as gift_slug', 'categories.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                    ->where('gifts.category_id', $category_id)
                                    ->whereBetween('usd_price', [5, 20])
                                    ->distinct()
                                    ->count();
                    } else if($filter == '20-to-50'){
                        $result = DB::table('gifts')
                                    ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                    ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                    ->select('gifts.*', 'gifts.id as gift_id', 'gifts.slug as gift_slug', 'categories.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                    ->where('gifts.category_id', $category_id)
                                    ->whereBetween('usd_price', [20, 50])
                                    ->orderBy('usd_price', $request->price_ordering)
                                    ->distinct()
                                    ->get();
                        $count = DB::table('gifts')
                                    ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                    ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                    ->select('gifts.*', 'gifts.id as gift_id', 'gifts.slug as gift_slug', 'categories.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                    ->where('gifts.category_id', $category_id)
                                    ->whereBetween('usd_price', [20, 50])
                                    ->distinct()
                                    ->count();
                    } else if($filter == '50-to-100'){
                        $result = DB::table('gifts')
                                    ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                    ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                    ->select('gifts.*', 'gifts.id as gift_id', 'gifts.slug as gift_slug', 'categories.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                    ->where('gifts.category_id', $category_id)
                                    ->whereBetween('usd_price', [50, 100])
                                    ->orderBy('usd_price', $request->price_ordering)
                                    ->distinct()
                                    ->get();
                        $count = DB::table('gifts')
                                    ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                    ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                    ->select('gifts.*', 'gifts.id as gift_id', 'gifts.slug as gift_slug', 'categories.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                    ->where('gifts.category_id', $category_id)
                                    ->whereBetween('usd_price', [50, 100])
                                    ->distinct()
                                    ->count();
                    } else if($filter == 'above-100'){
                        $result = DB::table('gifts')
                                    ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                    ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                    ->select('gifts.*', 'gifts.id as gift_id', 'gifts.slug as gift_slug', 'categories.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                    ->where([
                                        ['gifts.category_id', '=', $category_id],
                                        ['usd_price', '>', 100]
                                    ])
                                    ->orderBy('usd_price', $request->price_ordering)
                                    ->distinct()
                                    ->get();
                        $count = DB::table('gifts')
                                    ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                    ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                    ->select('gifts.*', 'gifts.id as gift_id', 'gifts.slug as gift_slug', 'categories.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                    ->where([
                                        ['gifts.category_id', '=', $category_id],
                                        ['usd_price', '>', 100]
                                    ])
                                    ->distinct()
                                    ->count();
                    }
                }

                // Filter category gifts by customer price range
                if(!empty($request->min_price) && !empty($request->max_price)){
                    if($request->currency == 'usd'){
                        $result = DB::table('gifts')
                                    ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                    ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                    ->select('gifts.*', 'gifts.id as gift_id', 'gifts.slug as gift_slug', 'categories.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                    ->where('gifts.category_id', $category_id)
                                    ->whereBetween('usd_price', [$request->min_price, $request->max_price])
                                    ->orderBy('usd_price', $request->price_ordering)
                                    ->distinct()
                                    ->get();
                        $count = DB::table('gifts')
                                    ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                    ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                    ->select('gifts.*', 'gifts.id as gift_id', 'gifts.slug as gift_slug', 'categories.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                    ->where('gifts.category_id', $category_id)
                                    ->whereBetween('usd_price', [$request->min_price, $request->max_price])
                                    ->distinct()
                                    ->count();
                    } else if($request->currency == 'zar'){
                        $result = DB::table('gifts')
                                    ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                    ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                    ->select('gifts.*', 'gifts.id as gift_id', 'gifts.slug as gift_slug', 'categories.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                    ->where('gifts.category_id', $category_id)
                                    ->whereBetween('zar_price', [$request->min_price, $request->max_price])
                                    ->orderBy('zar_price', $request->price_ordering)
                                    ->distinct()
                                    ->get();
                        $count = DB::table('gifts')
                                    ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                    ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                    ->select('gifts.*', 'gifts.id as gift_id', 'gifts.slug as gift_slug', 'categories.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                    ->where('gifts.category_id', $category_id)
                                    ->whereBetween('zar_price', [$request->min_price, $request->max_price])
                                    ->distinct()
                                    ->count();
                    } else {
                        $result = DB::table('gifts')
                                    ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                    ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                    ->select('gifts.*', 'gifts.id as gift_id', 'gifts.slug as gift_slug', 'categories.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                    ->where('gifts.category_id', $category_id)
                                    ->whereBetween('zwl_price', [$request->min_price, $request->max_price])
                                    ->orderBy('zwl_price', $request->price_ordering)
                                    ->distinct()
                                    ->get();
                        $count = DB::table('gifts')
                                    ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                    ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                    ->select('gifts.*', 'gifts.id as gift_id', 'gifts.slug as gift_slug', 'categories.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                    ->where('gifts.category_id', $category_id)
                                    ->whereBetween('zwl_price', [$request->min_price, $request->max_price])
                                    ->distinct()
                                    ->count();
                    }
                }

                // Filter category gifts by customer ratings
                if(!empty($filter_rating)){
                    if($filter_rating == 'above-4-rating'){
                        $result = DB::table('gifts')
                                    ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                    ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                    ->join('gift_ratings', 'gift_ratings.gift_id', '=', 'gifts.id')
                                    ->select('gifts.*', 'gifts.slug as gift_slug', 'categories.*', 'gift_ratings.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                    ->where([
                                        ['gifts.category_id', '=', $category_id],
                                        ['customer_rating', '>=', 4]
                                    ])
                                    ->orderBy('usd_price', $request->price_ordering)
                                    ->distinct()
                                    ->get();
                        $count = DB::table('gifts')
                                    ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                    ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                    ->join('gift_ratings', 'gift_ratings.gift_id', '=', 'gifts.id')
                                    ->select('gifts.*', 'gifts.slug as gift_slug', 'categories.*', 'gift_ratings.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                    ->where([
                                        ['gifts.category_id', '=', $category_id],
                                        ['customer_rating', '>=', 4]
                                    ])
                                    ->distinct()
                                    ->count();
                    } else if($filter_rating == 'above-3-rating'){
                        $result = DB::table('gifts')
                                    ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                    ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                    ->join('gift_ratings', 'gift_ratings.gift_id', '=', 'gifts.id')
                                    ->select('gifts.*', 'gifts.slug as gift_slug', 'categories.*', 'gift_ratings.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                    ->where([
                                        ['gifts.category_id', '=', $category_id],
                                        ['customer_rating', '>=', 3]
                                    ])
                                    ->orderBy('usd_price', $request->price_ordering)
                                    ->distinct()
                                    ->get();
                        $count = DB::table('gifts')
                                    ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                    ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                    ->join('gift_ratings', 'gift_ratings.gift_id', '=', 'gifts.id')
                                    ->select('gifts.*', 'gifts.slug as gift_slug', 'categories.*', 'gift_ratings.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                    ->where([
                                        ['gifts.category_id', '=', $category_id],
                                        ['customer_rating', '>=', 3]
                                    ])
                                    ->distinct()
                                    ->count();
                    } else if($filter_rating == 'above-2-rating'){
                        $result = DB::table('gifts')
                                    ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                    ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                    ->join('gift_ratings', 'gift_ratings.gift_id', '=', 'gifts.id')
                                    ->select('gifts.*', 'gifts.slug as gift_slug', 'categories.*', 'gift_ratings.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                    ->where([
                                        ['gifts.category_id', '=', $category_id],
                                        ['customer_rating', '>=', 2]
                                    ])
                                    ->orderBy('usd_price', $request->price_ordering)
                                    ->distinct()
                                    ->get();
                        $count = DB::table('gifts')
                                    ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                    ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                    ->join('gift_ratings', 'gift_ratings.gift_id', '=', 'gifts.id')
                                    ->select('gifts.*', 'gifts.slug as gift_slug', 'categories.*', 'gift_ratings.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                    ->where([
                                        ['gifts.category_id', '=', $category_id],
                                        ['customer_rating', '>=', 2]
                                    ])
                                    ->distinct()
                                    ->count();
                    } else if($filter_rating == 'above-1-rating'){
                        $result = DB::table('gifts')
                                    ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                    ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                    ->join('gift_ratings', 'gift_ratings.gift_id', '=', 'gifts.id')
                                    ->select('gifts.*', 'gifts.slug as gift_slug', 'categories.*', 'gift_ratings.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                    ->where([
                                        ['gifts.category_id', '=', $category_id],
                                        ['customer_rating', '>=', 1]
                                    ])
                                    ->orderBy('usd_price', $request->price_ordering)
                                    ->distinct()
                                    ->get();
                        $count = DB::table('gifts')
                                    ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                    ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                    ->join('gift_ratings', 'gift_ratings.gift_id', '=', 'gifts.id')
                                    ->select('gifts.*', 'gifts.slug as gift_slug', 'categories.*', 'gift_ratings.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                    ->where([
                                        ['gifts.category_id', '=', $category_id],
                                        ['customer_rating', '>=', 1]
                                    ])
                                    ->distinct()
                                    ->count();
                    } else {
                        $result = DB::table('gifts')
                                    ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                    ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                    ->join('gift_ratings', 'gift_ratings.gift_id', '=', 'gifts.id')
                                    ->select('gifts.*', 'gifts.slug as gift_slug', 'categories.*', 'gift_ratings.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                    ->where([
                                        ['gifts.category_id', '=', $category_id],
                                        ['customer_rating', '>=', 0]
                                    ])
                                    ->orderBy('usd_price', $request->price_ordering)
                                    ->distinct()
                                    ->get();
                        $count = DB::table('gifts')
                                    ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                    ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                    ->join('gift_ratings', 'gift_ratings.gift_id', '=', 'gifts.id')
                                    ->select('gifts.*', 'gifts.slug as gift_slug', 'categories.*', 'gift_ratings.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                    ->where([
                                        ['gifts.category_id', '=', $category_id],
                                        ['customer_rating', '>=', 0]
                                    ])
                                    ->distinct()
                                    ->count();
                    }
                }
                
                // Fetch all category gifts
                if(empty($filter) && empty($request->min_price) && empty($request->max_price) 
                && empty($request->rating) && empty($sub_category_id) && empty($request->latest)
                && empty($request->likes) && empty($request->trending && $request->currency == 'usd')){
                    $result = $main_query
                                ->offset($request->start)
                                ->limit($request->limit)
                                ->orderBy('usd_price', $request->price_ordering)
                                ->distinct()
                                ->get();
                    $count = $main_query->distinct()->count();
                }

                if($count > 0){
                    $output = '
                        <div class="d-grid grid-view grid-p-1 mt-3 products-shelf" id="customizable-gifts">
                    ';
                    foreach($result as $gift){
                        // Gift star rating
                    $star_rating = giftStarRating($gift->gift_id);

                    // Gift sale percentage
                    $sale_percentage = $gift->sale_percentage;
                    
                    // Gift's short name to show on comparison pane
                    $short_name = mb_strimwidth($gift->gift_name, 0, 15, '...');

                    // Show if user customized or wishlisted the gift
                    if(isset(Auth::user()->id)){
                        $wishlist_icon = wishlistIcon($gift->gift_id, Auth::user()->id);
                        if(!empty(customizedLabel($gift->gift_id, Auth::user()->id))){
                            $gift_label = customizedLabel($gift->gift_id, Auth::user()->id);
                        } else {
                            $gift_label = giftLabel($gift->gift_id, round(100 * $gift->sale_percentage));
                        }
                    } else {
                        $wishlist_icon = '
                            <i role="button" class="fa fa-heart-o text-light guest-wishes" id="'. $gift->gift_id .'" data-name="'. $gift->gift_name .'"></i>
                        ';
                        $gift_label = giftLabel($gift->gift_id, round(100 * $gift->sale_percentage));
                    }

                    // Fetch sale end-date
                    $end_date = strtotime($gift->ends_on) * 1000;
                    $end_dates[] = $end_date;

                    // Determine if end date is greater than today
                    $date_diff = floor(abs(($end_date - $now) / (1000 * 3600 * 24)));

                    // Fetch all gif-ids
                    $gift_ids[] = $gift->gift_id;

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
                                <div class="d-flex align-items-center text-sm">
                                    <span class="d-xs-none">Ends<span class="d-sm-none d-md-inline ml-1">in</span>:</span>
                                    <span class="ml-1 d-flex align-items-center" id="countdown-timer'.$gift->gift_id.'">00d:00h:00m:00s</span>
                                </div>
                            ';
                        } else {
                            // Show that the sale is closed
                            $timer = '
                                <div class="sale-timer d-flex align-items-center text-sm pt-sm-2">
                                    <span class="d-xs-none">Ends<span class="d-sm-none d-md-inline ml-1">in</span>:</span>
                                    <span class="ml-1 d-flex text-danger align-items-center" id="countdown-timer'.$gift->gift_id.'">Sale closed</span>
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
                            <a href="#" class="nav-link icon-link toggle-customization" id="customize'.$gift->gift_id.'" title="Customize gift" data-id="'. $gift->gift_id .'">
                                <i class="material-icons">palette</i>
                            </a>
                        ';
                    }

                        $output .= '
                            <!-- Product Card -->
                            <div class="card product-card rounded-2 box-shadow-sm" data-id="'.$gift->gift_id.'">
                                <!-- Cart Actions -->
                                <div class="gift-cart-options bg-whitesmoke box-shadow-sm d-none" id="cart-options'.$gift->gift_id.'">
                                    <div class="d-flex align-items-center px-2">
                                        <div class="d-flex align-items-center justify-content-around m-0 p-0">
                                            <span role="button" class="product-actions material-icons text-success subtract-product" data-id="'.$gift->gift_id.'" title="Decrease quantity">remove_circle</span>
                                            <span role="button" class="product-actions item-quantity text-faded" id="item-count'.$gift->gift_id.'">0</span>
                                            <span role="button" class="product-actions material-icons text-success increase-qty" data-id="'.$gift->gift_id.'" title="Increase quantity">add_circle</span>
                                        </div>
                                        <div class="ml-auto d-flex align-items-center">
                                            '.$custom_link.'
                                            <a href="#" class="nav-link icon-link text-danger remove-item ml-2" title="Remove Item" data-id="'.$gift->gift_id.'">
                                                <i class="material-icons notifications">delete</i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.Cart Actions -->
                                <div class="product-img-wrapper">
                                    '. $gift_label .'
                                    <a href="/details/'. $gift->gift_slug .'/'. $gift->gift_id .'" title="View product">
                                        <img src="/storage/gifts/'. $gift->gift_image .'" alt="'. $gift->gift_name .'" height="200" class="card-img-top">
                                    </a>
                                    <div class="overlay d-flex justify-content-around py-1">
                                        <div class="d-flex flex-column text-center" title="'. $gift->units .' In Stock">
                                            <i class="fa fa-home text-light"></i>
                                            <span class="text-light text-sm">'. $gift->units .'</span>
                                        </div>
                                        <div class="d-flex flex-column text-center" title="'. viewCounter($gift->gift_id) .' Total Views">
                                            <i class="fa fa-eye text-light"></i>
                                            <span class="text-light text-sm">'. viewCounter($gift->gift_id) .'</span>
                                        </div>
                                        <div class="d-flex flex-column text-center" title="Wishlisted by '. totalWishes($gift->gift_id) .' customer(s)">
                                            '.$wishlist_icon.'
                                            <span class="text-light text-sm">'. totalWishes($gift->gift_id) .'</span>
                                        </div>
                                        <div class="d-flex flex-column text-center" title="'. giftsSold($gift->gift_id) .' gift(s) sold">
                                            <div class="d-flex align-items-center overlay-metric">
                                                <i class="fa fa-shopping-bag text-light"></i>
                                                <span class="badge badge-danger badge-pill overlay-badge">'. giftsSold($gift->gift_id) .'</span>
                                            </div>
                                            <span class="text-light text-sm">Sold</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <div class="card-body my-0 py-0">
                                        <div class="lh-100 mb-0 pb-0">
                                            <a href="/details/'. $gift->gift_slug .'/'. $gift->gift_id .'">
                                                <p class="d-sm-none d-md-block font-600 text-capitalize mt-1 mb-0 py-0 product-name popover-info" id="'. $gift->gift_id .'">
                                                    '. Str::words($gift->gift_name, 2, '') .'
                                                </p>
                                                <p class="d-md-none font-600 text-capitalize mt-1 mb-0 py-0 product-name popover-info" id="'. $gift->gift_id .'">
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
                                                    <span class="font-600">$<span class="product-price">'. $usd_price .'</span></span>
                                                    <div class="d-flex align-items-center before-prices">
                                                        <span class="font-600 text-muted strikethrough ml-1">$'. $usd_before .'</span>
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
                                                    <span class="font-600">$<span class="product-price">'. $zwl_price .'</span></span>
                                                    <div class="d-flex align-items-center before-prices">
                                                        <span class="font-600 text-muted strikethrough ml-1">$'. $zwl_before .'</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        '. $timer .'
                                        <div class="row justify-content-center w-100">
                                            <div class="btn-group btn-group-sm mt-0 pt-0 pulse">
                                                <button class="btn btn-primary btn-sm d-flex align-items-center add-to-cart-btn rounded-left" data-id="'. $gift->gift_id .'">
                                                    <i class="material-icons text-white mr-1 d-sm-none d-md-inline-block">add_shopping_cart</i>
                                                    Buy <span class="text-white text-white ml-1">gift</span rounded-right>
                                                </button>
                                                <button class="btn border-primary btn-sm text-primary compare-btn d-flex align-items-center rounded-right" id="compare-btn'. $gift->gift_id .'" data-name="'. $short_name .'" data-id="'. $gift->gift_id .'">
                                                    <i class="material-icons text-primary mr-1 d-sm-none d-md-inline-block">compare_arrows</i>
                                                    Compare
                                                </button>
                                            </div>
                                        </div>
                                        <input value="'. $gift->gift_id .'" id="gift_id" type="hidden">
                                        <input value="'. $gift->gift_name .'" id="name'. $gift->gift_id .'" type="hidden">
                                        <input value="'. $gift->label .'" id="label'. $gift->gift_id .'" type="hidden">
                                        <input value="'. $gift->gift_image .'" id="image'. $gift->gift_id .'" type="hidden">
                                        <input value="'. $usd_price .'" id="usd-price'. $gift->gift_id .'" type="hidden">
                                        <input value="'. $zar_price .'" id="zar-price'. $gift->gift_id .'" type="hidden">
                                        <input value="'. $zwl_price .'" id="zwl-price'. $gift->gift_id .'" type="hidden">
                                        <input value="'. $end_date .'" id="end-time'. $gift->gift_id .'" type="hidden">
                                        <input value="'. $gift->category_id .'" id="category-id'. $gift->gift_id .'" type="hidden">
                                        <input value="'. $gift->category_name .'" id="category-name'. $gift->gift_id .'" type="hidden">
                                        <input value="'. $gift->units .'" id="product-units'. $gift->gift_id .'" type="hidden">
                                        <input value="1" id="quantity'. $gift->gift_id .'" type="hidden">
                                        <input value="'. $gift->description .'" id="description'. $gift->gift_id .'" type="hidden">
                                    </div>
                                </div>
                            </div>
                            <!-- /.Product Card -->
                        ';
                    }
                    $output .= '</div>';
                } else {
                    $output = '
                        <div class="container justify-content-center w-100 my-5">
                            <div class="col-12 text-center no-content">
                                <i class="material-icons text-muted lead">redeem</i>
                                <h5 class="my-0 py-0">Oops! No results found!</h5>
                                <h6 class="text-center">No gift items that fall into this category range found!</h6>
                                <div class="row justify-content-center">
                                    <button class="btn btn-primary btn-sm rounded-pill d-flex align-items-center px-3 my-2" id="fetch-all-btn">
                                        <i class="material-icons mr-1">refresh</i> Fetch All
                                    </button>
                                </div>
                            </div>
                        </div>
                    ';
                }
                
                if($count == 1){
                    $gift_count = '1 gift item in stock';
                } else {
                    $gift_count = $count . ' gift items in stock';
                }

                return response()->json([
                    'gifts'          => $output,
                    'gift_count'     => $gift_count,
                    'result'         => $result,
                    'countdown_date' => $end_dates,
                    'now'            => $now,
                    'gift_ids'       => $gift_ids
                ]);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
