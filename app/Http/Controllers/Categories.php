<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        return view('category.category')->with($data);
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
                $output = $gift_count = '';
                $result = [];
                $count = 0;
                $filter = $request->filter;
                $filter_rating = $request->rating;
                $sub_category_id = $request->sub_category_id;

                // Filter category gifts by the created_at date (desc)
                if(!empty($request->latest) && $request->latest == 'created_at'){
                    $result = DB::table('gifts')
                                ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                ->select('gifts.*', 'gifts.id as gift_id', 'gifts.slug as gift_slug', 'categories.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                ->where('gifts.category_id', $request->category_id)
                                ->orderBy('gifts.created_at', 'desc')
                                ->distinct()
                                ->get();
                    $count = DB::table('gifts')
                                ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                ->select('gifts.*', 'gifts.id as gift_id', 'gifts.slug as gift_slug', 'categories.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                ->where('gifts.category_id', $request->category_id)
                                ->distinct()
                                ->count();
                }

                // Filter category gifts by their wishlist rankings
                if(!empty($request->likes) && $request->likes == 'top-wishlisted'){
                    $result = DB::table('gifts')
                                ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                ->join('wishlist', 'wishlist.gift_id', '=', 'gifts.id')
                                ->select('gifts.*', 'gifts.id as gift_id', 'gifts.slug as gift_slug', 'categories.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                ->where('gifts.category_id', $request->category_id)
                                ->whereIn('gifts.id', wishlistedGifts())
                                ->orderBy('usd_price', $request->price_ordering)
                                ->distinct()
                                ->get();
                    $count = DB::table('gifts')
                                ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                ->join('wishlist', 'wishlist.gift_id', '=', 'gifts.id')
                                ->select('gifts.*', 'gifts.id as gift_id', 'gifts.slug as gift_slug', 'categories.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                ->where('gifts.category_id', $request->category_id)
                                ->whereIn('gifts.id', wishlistedGifts())
                                ->count();
                }

                // Filter category gifts by their wishlist rankings
                if(!empty($request->trending) && $request->trending == 'top-sold'){
                    $result = DB::table('gifts')
                                ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                ->join('ordered_gifts', 'ordered_gifts.gift_id', '=', 'gifts.id')
                                ->select('gifts.*', 'gifts.id as gift_id', 'gifts.slug as gift_slug', 'categories.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                ->where('gifts.category_id', $request->category_id)
                                ->whereIn('gifts.id', orderedGifts())
                                ->orderBy('usd_price', $request->price_ordering)
                                ->distinct()
                                ->get();
                    $count = DB::table('gifts')
                                ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                ->join('ordered_gifts', 'ordered_gifts.gift_id', '=', 'gifts.id')
                                ->select('gifts.*', 'gifts.id as gift_id', 'gifts.slug as gift_slug', 'categories.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                ->where('gifts.category_id', $request->category_id)
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
                                        ['gifts.category_id', '=', $request->category_id],
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
                                        ['gifts.category_id', '=', $request->category_id],
                                        ['usd_price', '<', 25]
                                    ])
                                    ->distinct()
                                    ->count();
                    } else if($filter == '5-to-20'){
                        $result = DB::table('gifts')
                                    ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                    ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                    ->select('gifts.*', 'gifts.id as gift_id', 'gifts.slug as gift_slug', 'categories.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                    ->where('gifts.category_id', $request->category_id)
                                    ->whereBetween('usd_price', [5, 20])
                                    ->orderBy('usd_price', $request->price_ordering)
                                    ->distinct()
                                    ->get();
                        $count = DB::table('gifts')
                                    ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                    ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                    ->select('gifts.*', 'gifts.id as gift_id', 'gifts.slug as gift_slug', 'categories.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                    ->where('gifts.category_id', $request->category_id)
                                    ->whereBetween('usd_price', [5, 20])
                                    ->distinct()
                                    ->count();
                    } else if($filter == '20-to-50'){
                        $result = DB::table('gifts')
                                    ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                    ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                    ->select('gifts.*', 'gifts.id as gift_id', 'gifts.slug as gift_slug', 'categories.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                    ->where('gifts.category_id', $request->category_id)
                                    ->whereBetween('usd_price', [20, 50])
                                    ->orderBy('usd_price', $request->price_ordering)
                                    ->distinct()
                                    ->get();
                        $count = DB::table('gifts')
                                    ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                    ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                    ->select('gifts.*', 'gifts.id as gift_id', 'gifts.slug as gift_slug', 'categories.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                    ->where('gifts.category_id', $request->category_id)
                                    ->whereBetween('usd_price', [20, 50])
                                    ->distinct()
                                    ->count();
                    } else if($filter == '50-to-100'){
                        $result = DB::table('gifts')
                                    ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                    ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                    ->select('gifts.*', 'gifts.id as gift_id', 'gifts.slug as gift_slug', 'categories.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                    ->where('gifts.category_id', $request->category_id)
                                    ->whereBetween('usd_price', [50, 100])
                                    ->orderBy('usd_price', $request->price_ordering)
                                    ->distinct()
                                    ->get();
                        $count = DB::table('gifts')
                                    ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                    ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                    ->select('gifts.*', 'gifts.id as gift_id', 'gifts.slug as gift_slug', 'categories.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                    ->where('gifts.category_id', $request->category_id)
                                    ->whereBetween('usd_price', [50, 100])
                                    ->distinct()
                                    ->count();
                    } else if($filter == 'above-100'){
                        $result = DB::table('gifts')
                                    ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                    ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                    ->select('gifts.*', 'gifts.id as gift_id', 'gifts.slug as gift_slug', 'categories.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                    ->where([
                                        ['gifts.category_id', '=', $request->category_id],
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
                                        ['gifts.category_id', '=', $request->category_id],
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
                                    ->where('gifts.category_id', $request->category_id)
                                    ->whereBetween('usd_price', [$request->min_price, $request->max_price])
                                    ->orderBy('usd_price', $request->price_ordering)
                                    ->distinct()
                                    ->get();
                        $count = DB::table('gifts')
                                    ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                    ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                    ->select('gifts.*', 'gifts.id as gift_id', 'gifts.slug as gift_slug', 'categories.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                    ->where('gifts.category_id', $request->category_id)
                                    ->whereBetween('usd_price', [$request->min_price, $request->max_price])
                                    ->distinct()
                                    ->count();
                    } else if($request->currency == 'zar'){
                        $result = DB::table('gifts')
                                    ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                    ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                    ->select('gifts.*', 'gifts.id as gift_id', 'gifts.slug as gift_slug', 'categories.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                    ->where('gifts.category_id', $request->category_id)
                                    ->whereBetween('zar_price', [$request->min_price, $request->max_price])
                                    ->orderBy('zar_price', $request->price_ordering)
                                    ->distinct()
                                    ->get();
                        $count = DB::table('gifts')
                                    ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                    ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                    ->select('gifts.*', 'gifts.id as gift_id', 'gifts.slug as gift_slug', 'categories.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                    ->where('gifts.category_id', $request->category_id)
                                    ->whereBetween('zar_price', [$request->min_price, $request->max_price])
                                    ->distinct()
                                    ->count();
                    } else {
                        $result = DB::table('gifts')
                                    ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                    ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                    ->select('gifts.*', 'gifts.id as gift_id', 'gifts.slug as gift_slug', 'categories.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                    ->where('gifts.category_id', $request->category_id)
                                    ->whereBetween('zwl_price', [$request->min_price, $request->max_price])
                                    ->orderBy('zwl_price', $request->price_ordering)
                                    ->distinct()
                                    ->get();
                        $count = DB::table('gifts')
                                    ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                    ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                    ->select('gifts.*', 'gifts.id as gift_id', 'gifts.slug as gift_slug', 'categories.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                    ->where('gifts.category_id', $request->category_id)
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
                                        ['gifts.category_id', '=', $request->category_id],
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
                                        ['gifts.category_id', '=', $request->category_id],
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
                                        ['gifts.category_id', '=', $request->category_id],
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
                                        ['gifts.category_id', '=', $request->category_id],
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
                                        ['gifts.category_id', '=', $request->category_id],
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
                                        ['gifts.category_id', '=', $request->category_id],
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
                                        ['gifts.category_id', '=', $request->category_id],
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
                                        ['gifts.category_id', '=', $request->category_id],
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
                                        ['gifts.category_id', '=', $request->category_id],
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
                                        ['gifts.category_id', '=', $request->category_id],
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
                    $result = DB::table('gifts')
                                ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                ->select('gifts.*', 'gifts.id as gift_id', 'gifts.slug as gift_slug', 'categories.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                ->where('gifts.category_id', $request->category_id)
                                ->offset($request->start)
                                ->limit($request->limit)
                                ->orderBy('usd_price', $request->price_ordering)
                                ->distinct()
                                ->get();
                    $count = DB::table('gifts')
                                ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                ->select('gifts.*', 'gifts.id as gift_id', 'gifts.slug as gift_slug', 'categories.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                ->where('gifts.category_id', $request->category_id)
                                ->distinct()
                                ->count();
                }

                if($count > 0){
                    foreach($result as $gift){
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
                                    <a href="/details/'. $gift->gift_slug .'/'. $gift->gift_id .'" title="View product">
                                        <img src="/storage/gifts/'. $gift->gift_image .'" alt="'. $gift->gift_name .'" height="200" class="card-img-top rounded-0">
                                    </a>
                                    <div class="overlay py-1 px-2">
                                        <div class="d-flex align-items-center">
                                            <a href="/details/'. $gift->gift_slug .'/'. $gift->gift_id .'" class="d-flex align-items-center">
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
                                            <a href="/details/'. $gift->gift_slug .'/'. $gift->gift_id .'" class="d-flex align-items-center ml-2" title="See Reviews">
                                                <span role="button" class="material-icons overlay-icon">forum</span>
                                                <small class="text-light d-list-grid">'. countRatings($gift->gift_id) .'</small>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <div class="card-body my-0 py-0">
                                        <div class="lh-100">
                                            <a href="/details/'. $gift->gift_slug .'/'. $gift->gift_id .'">
                                                <p class="font-600 text-capitalize mt-1 mb-0 py-0 product-name popover-info" id="'. $gift->gift_id .'">
                                                    '. mb_strimwidth($gift->gift_name, 0, 25, '...') .'
                                                </p>
                                            </a>
                                            <a href="'. route('gifts_subcategory', [$gift->sub_category_id, $gift->subcategory_slug]) .'" class="text-sm font-500 text-capitalize my-0 py-0">
                                                '. $gift->sub_category.'
                                            </a>
                                            '. $star_rating .'
                                        </div>
                                        <p class="product-description text-sm font-500 text-faded text-justify my-0 py-0">
                                            '. mb_strimwidth($gift->description, 0, 60, '...') .'
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
                    'gifts'      => $output,
                    'gift_count' => $gift_count,
                    'result'     => $result
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
