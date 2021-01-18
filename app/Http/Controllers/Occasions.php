<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Occasions extends Controller
{
    /**
     * Display the specified category.
     *
     * @param  string $name
     * @return \Illuminate\Http\Response
     */
    public function occasion($occasion)
    {
        // $category = explode('_', $occasion);
        // $title = ucfirst($category[0]) . ' ' . ucfirst($category[1]);
        switch($occasion){
            case 'trending_gifts':
                $filters = DB::table('categories')
                              ->join('gifts', 'gifts.category_id', '=', 'categories.id')
                              ->join('ordered_gifts', 'ordered_gifts.gift_id', '=', 'gifts.id')
                              ->whereIn('gifts.id', orderedGifts())
                              ->select('categories.*')
                              ->distinct()
                              ->get();
                break;
            case 'hot_deals':
                $filters = DB::table('categories')
                              ->join('gifts', 'gifts.category_id', '=', 'categories.id')
                              ->where('gifts.label', 'sale')
                              ->orWhere('gifts.label', 'hot-offer')
                              ->select('categories.*')
                              ->distinct()
                              ->get();
                break;
            default: 
                $filters = DB::table('categories')
                              ->join('gifts', 'gifts.category_id', '=', 'categories.id')
                              ->select('categories.*')
                              ->distinct()
                              ->get();

        }
        $trending = DB::table('gifts')
                    ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                    ->join('categories', 'categories.id', '=', 'gifts.category_id')
                    ->select('gifts.*', 'gifts.id as gift_id', 'gifts.slug as gift_slug', 'categories.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                    ->whereIn('gifts.id', orderedGifts())
                    ->orderBy('usd_price', 'asc')
                    ->distinct()
                    ->get();
        $data = [
            'title'       => $occasion,
            'filters'     => $filters,
            'occasion'    => $occasion,
            'trending'    => $trending
        ];
        return view('category.occasion')->with($data);
    }

    /**
     * Display the specified resource.
     *
     * @param int $category_id
     * @return \Illuminate\Http\Response
     */
    public function occasional_gifts(Request $request)
    {
        if($request->ajax()){
            if($request->action == 'occasional-gifts'){
                $output = $gift_count = $gift_label = '';
                $timer = $custom_link = '';
                $end_dates = $gift_ids = $result = [];
                $date_diff =  $count = 0;
                $result = [];
                $count = 0;
                
                // Fetch all occasional gifts
                switch($request->occasion){
                    case 'trending_gifts':
                        $result = DB::table('gifts')
                                    ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                    ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                    ->select('gifts.*', 'gifts.id as gift_id', 'gifts.slug as gift_slug', 'categories.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                    ->whereIn('gifts.id', orderedGifts())
                                    ->orderBy('usd_price', $request->price_ordering)
                                    ->distinct()
                                    ->offset($request->start)
                                    ->limit($request->limit)
                                    ->get();
                        $count = DB::table('gifts')
                                    ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                    ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                    ->select('gifts.*', 'gifts.id as gift_id', 'gifts.slug as gift_slug', 'categories.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                    ->whereIn('gifts.id', orderedGifts())
                                    ->count();
                        break;
                    case 'hot_deals':
                        $result = DB::table('gifts')
                                    ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                    ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                    ->select('gifts.*', 'gifts.id as gift_id', 'gifts.slug as gift_slug', 'categories.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                    ->where('gifts.label', 'sale')
                                    ->orWhere('gifts.label', 'hot-offer')
                                    ->orderBy('usd_price', $request->price_ordering)
                                    ->distinct()
                                    ->offset($request->start)
                                    ->limit($request->limit)
                                    ->get();
                        $count = DB::table('gifts')
                                    ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                    ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                    ->select('gifts.*', 'gifts.id as gift_id', 'gifts.slug as gift_slug', 'categories.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                    ->where('gifts.label', 'sale')
                                    ->orWhere('gifts.label', 'hot-offer')
                                    ->count();
                        break;
                    case 'anniversary_gifts':
                    case 'valentines_gifts':
                        $result = DB::select('select distinct gifts.*, gifts.id as gift_id, gifts.slug as gift_slug, 
                                    categories.*, sub_categories.*, sub_categories.name as sub_category from gifts inner join sub_categories 
                                    on sub_categories.id = gifts.sub_category_id inner join categories on categories.id = gifts.category_id
                                    where category_name = "teddy bears" or category_name = "combo" or category_name = "flowers"
                                    or category_name = "jewelry" or category_name = "appliances" or category_name = "accessories"
                                    or category_name = "customizable" or category_name = "vases"
                                    or sub_categories.name = "anniversary"
                                    or sub_categories.name = "chocolates" or sub_categories.name = "perfumes & Deodorants"
                                    or sub_categories.name = "Wines" or sub_categories.name = "watches" 
                                    or sub_categories.name = "valentines cards" or sub_categories.name = "computers" 
                                    or sub_categories.name = "phones" or sub_categories.name = "tablets" 
                                    or sub_categories.name = "games" order by usd_price '. $request->price_ordering .' 
                                    limit '. $request->start .', '. $request->limit .'');
                        $query = DB::select('select distinct gifts.*, gifts.id as gift_id, gifts.slug as gift_slug, 
                                    categories.*, sub_categories.*, sub_categories.name as sub_category from gifts inner join sub_categories 
                                    on sub_categories.id = gifts.sub_category_id inner join categories on categories.id = gifts.category_id
                                    where category_name = "teddy bears" or category_name = "combo" or category_name = "flowers"
                                    or category_name = "jewelry" or category_name = "appliances" or category_name = "accessories"
                                    or category_name = "customizable" or category_name = "vases"
                                    or sub_categories.name = "anniversary"
                                    or sub_categories.name = "chocolates" or sub_categories.name = "perfumes & Deodorants"
                                    or sub_categories.name = "Wines" or sub_categories.name = "watches" 
                                    or sub_categories.name = "valentines cards" or sub_categories.name = "computers" 
                                    or sub_categories.name = "phones" or sub_categories.name = "tablets" 
                                    or sub_categories.name = "games"');
                        $count = count($query);
                        break;
                    case 'birthday_gifts':
                        $result = DB::select('select distinct gifts.*, gifts.id as gift_id, gifts.slug as gift_slug, 
                                    categories.*, sub_categories.*, sub_categories.name as sub_category from gifts inner join sub_categories 
                                    on sub_categories.id = gifts.sub_category_id inner join categories on categories.id = gifts.category_id
                                    where category_name = "teddy bears" or category_name = "combo" or category_name = "flowers"
                                    or category_name = "jewelry" or category_name = "appliances" or category_name = "accessories"
                                    or category_name = "customizable"  or sub_categories.name = "birthday cakes"
                                    or sub_categories.name = "chocolates" or sub_categories.name = "perfumes & Deodorants"
                                    or sub_categories.name = "Wines" or sub_categories.name = "watches" 
                                    or category_name = "vases" or category_name = "bags"
                                    or sub_categories.name = "birthday cards" or sub_categories.name = "computers" 
                                    or sub_categories.name = "phones" or sub_categories.name = "tablets" 
                                    or sub_categories.name = "games" order by usd_price '. $request->price_ordering .' 
                                    limit '. $request->start .', '. $request->limit .'');
                        $query = DB::select('select distinct gifts.*, gifts.id as gift_id, gifts.slug as gift_slug, 
                                    categories.*, sub_categories.*, sub_categories.name as sub_category from gifts inner join sub_categories 
                                    on sub_categories.id = gifts.sub_category_id inner join categories on categories.id = gifts.category_id
                                    where category_name = "teddy bears" or category_name = "combo" or category_name = "flowers"
                                    or category_name = "jewelry" or category_name = "appliances" or category_name = "accessories"
                                    or category_name = "customizable"  or sub_categories.name = "birthday cakes"
                                    or sub_categories.name = "chocolates" or sub_categories.name = "perfumes & Deodorants"
                                    or sub_categories.name = "Wines" or sub_categories.name = "watches" 
                                    or category_name = "vases" or category_name = "bags"
                                    or sub_categories.name = "birthday cards" or sub_categories.name = "computers" 
                                    or sub_categories.name = "phones" or sub_categories.name = "tablets" 
                                    or sub_categories.name = "games"');
                        $count = count($query);
                        break;
                    case 'christmas_gifts':
                    case 'newyear_gifts':
                        $result = DB::select('select distinct gifts.*, gifts.id as gift_id, gifts.slug as gift_slug, 
                                    categories.*, sub_categories.*, sub_categories.name as sub_category from gifts inner join sub_categories 
                                    on sub_categories.id = gifts.sub_category_id inner join categories on categories.id = gifts.category_id
                                    where category_name <> "teddy bears" or category_name <> "combo" or 
                                    sub_categories.name <> "Couple Matching Clothes" or sub_categories.name <> "easter cards"
                                    or sub_categories.name <> "easter eggs" or sub_categories.name <> "farewell cards"
                                    or sub_categories.name <> "fathers day cards" or sub_categories.name <> "mothers day cards"
                                    or sub_categories.name <> "get well soon cards" or sub_categories.name <> "graduation cards"
                                    or sub_categories.name <> "wedding cards" or sub_categories.name <> "workplace cards"
                                    or sub_categories.name <> "thank you cards" or sub_categories.name <> "birthday cards"
                                    or sub_categories.name <> "valentines cards" or sub_categories.name <> "wedding cakes"
                                    order by usd_price '. $request->price_ordering .' 
                                    limit '. $request->start .', '. $request->limit .'');
                        $query = DB::select('select distinct gifts.*, gifts.id as gift_id, gifts.slug as gift_slug, 
                                    categories.*, sub_categories.*, sub_categories.name as sub_category from gifts inner join sub_categories 
                                    on sub_categories.id = gifts.sub_category_id inner join categories on categories.id = gifts.category_id
                                    where category_name <> "teddy bears" or category_name <> "combo" or 
                                    sub_categories.name <> "Couple Matching Clothes" or sub_categories.name <> "easter cards"
                                    or sub_categories.name <> "easter eggs" or sub_categories.name <> "farewell cards"
                                    or sub_categories.name <> "fathers day cards" or sub_categories.name <> "mothers day cards"
                                    or sub_categories.name <> "get well soon cards" or sub_categories.name <> "graduation cards"
                                    or sub_categories.name <> "wedding cards" or sub_categories.name <> "workplace cards"
                                    or sub_categories.name <> "thank you cards" or sub_categories.name <> "birthday cards"
                                    or sub_categories.name <> "valentines cards" or sub_categories.name <> "wedding cakes"');
                        $count = count($query);
                        break;
                    case 'congrats_gifts':
                    case 'thanks_gifts':
                    case 'workplace_gifts':
                        $result = DB::select('select distinct gifts.*, gifts.id as gift_id, gifts.slug as gift_slug, 
                                    categories.*, sub_categories.*, sub_categories.name as sub_category from gifts inner join sub_categories 
                                    on sub_categories.id = gifts.sub_category_id inner join categories on categories.id = gifts.category_id
                                    where category_name = "kitchenware" or category_name = "flowers"
                                    or category_name = "shoes" or category_name = "appliances" or category_name = "accessories"
                                    or category_name = "customizable"  or sub_categories.name = "workplace cards"
                                    or sub_categories.name = "chocolates" or sub_categories.name = "perfumes & Deodorants"
                                    or sub_categories.name = "Wines" or sub_categories.name = "watches" 
                                    or sub_categories.name = "congrats cards" or sub_categories.name = "computers" 
                                    or sub_categories.name = "phones" or sub_categories.name = "tablets" 
                                    or sub_categories.name = "games" order by usd_price '. $request->price_ordering .' 
                                    limit '. $request->start .', '. $request->limit .'');
                        $query = DB::select('select distinct gifts.*, gifts.id as gift_id, gifts.slug as gift_slug, 
                                    categories.*, sub_categories.*, sub_categories.name as sub_category from gifts inner join sub_categories 
                                    on sub_categories.id = gifts.sub_category_id inner join categories on categories.id = gifts.category_id
                                    where category_name = "kitchenware" or category_name = "flowers"
                                    or category_name = "shoes" or category_name = "appliances" or category_name = "accessories"
                                    or category_name = "customizable"  or sub_categories.name = "workplace cards"
                                    or sub_categories.name = "chocolates" or sub_categories.name = "perfumes & Deodorants"
                                    or sub_categories.name = "Wines" or sub_categories.name = "watches" 
                                    or sub_categories.name = "congrats cards" or sub_categories.name = "computers" 
                                    or sub_categories.name = "phones" or sub_categories.name = "tablets" 
                                    or sub_categories.name = "games"');
                        $count = count($query);
                        break;
                    case 'easter_gifts': 
                        $result = DB::select('select distinct gifts.*, gifts.id as gift_id, gifts.slug as gift_slug, 
                                    categories.*, sub_categories.*, sub_categories.name as sub_category from gifts inner join sub_categories 
                                    on sub_categories.id = gifts.sub_category_id inner join categories on categories.id = gifts.category_id
                                    where category_name = "kitchenware" or category_name = "flowers"
                                    or category_name = "shoes" or category_name = "appliances" 
                                    or category_name = "accessories" or category_name = "pastries"
                                    or category_name = "confectionery" or category_name = "dairy"
                                    or category_name = "beverages" or category_name = "snacks"
                                    or category_name = "plasticware" or category_name = "clothing"
                                    or category_name = "customizable"  or sub_categories.name = "easter cards"
                                    or sub_categories.name = "chocolates" or sub_categories.name = "perfumes & Deodorants"
                                    or sub_categories.name = "Wines" or sub_categories.name = "watches" 
                                    or sub_categories.name = "computers" or sub_categories.name = "easter eggs"
                                    or sub_categories.name = "phones" or sub_categories.name = "tablets" 
                                    or sub_categories.name = "games" order by usd_price '. $request->price_ordering .' 
                                    limit '. $request->start .', '. $request->limit .'');
                        $query = DB::select('select distinct gifts.*, gifts.id as gift_id, gifts.slug as gift_slug, 
                                    categories.*, sub_categories.*, sub_categories.name as sub_category from gifts inner join sub_categories 
                                    on sub_categories.id = gifts.sub_category_id inner join categories on categories.id = gifts.category_id
                                    where category_name = "kitchenware" or category_name = "flowers"
                                    or category_name = "shoes" or category_name = "appliances" 
                                    or category_name = "accessories" or category_name = "pastries"
                                    or category_name = "confectionery" or category_name = "dairy"
                                    or category_name = "beverages" or category_name = "snacks"
                                    or category_name = "plasticware" or category_name = "clothing"
                                    or category_name = "customizable"  or sub_categories.name = "easter cards"
                                    or sub_categories.name = "chocolates" or sub_categories.name = "perfumes & Deodorants"
                                    or sub_categories.name = "Wines" or sub_categories.name = "watches" 
                                    or sub_categories.name = "computers" or sub_categories.name = "easter eggs"
                                    or sub_categories.name = "phones" or sub_categories.name = "tablets" 
                                    or sub_categories.name = "games"');
                        $count = count($query);
                        break;
                    case 'farewell_gifts':
                    case 'retirement_gifts':
                        $result = DB::select('select distinct gifts.*, gifts.id as gift_id, gifts.slug as gift_slug, 
                                    categories.*, sub_categories.*, sub_categories.name as sub_category from gifts inner join sub_categories 
                                    on sub_categories.id = gifts.sub_category_id inner join categories on categories.id = gifts.category_id
                                    where category_name = "kitchenware" or category_name = "flowers"
                                    or category_name = "shoes" or category_name = "appliances" 
                                    or category_name = "pastries"
                                    or category_name = "vases" or category_name = "bags"
                                    or category_name = "plasticware" or category_name = "clothing"
                                    or sub_categories.name = "farewell cards" or sub_categories.name = "keyholders"
                                    or sub_categories.name = "necklaces" or sub_categories.name = "keyholders"
                                    or sub_categories.name = "chocolates" or sub_categories.name = "perfumes & Deodorants"
                                    or sub_categories.name = "Wines" or sub_categories.name = "watches" 
                                    or sub_categories.name = "computers"
                                    or sub_categories.name = "phones" or sub_categories.name = "tablets" 
                                    or sub_categories.name = "games" order by usd_price '. $request->price_ordering .' 
                                    limit '. $request->start .', '. $request->limit .'');
                        $query = DB::select('select distinct gifts.*, gifts.id as gift_id, gifts.slug as gift_slug, 
                                    categories.*, sub_categories.*, sub_categories.name as sub_category from gifts inner join sub_categories 
                                    on sub_categories.id = gifts.sub_category_id inner join categories on categories.id = gifts.category_id
                                    where category_name = "kitchenware" or category_name = "flowers"
                                    or category_name = "shoes" or category_name = "appliances" 
                                    or category_name = "pastries"
                                    or category_name = "vases" or category_name = "bags"
                                    or category_name = "plasticware" or category_name = "clothing"
                                    or sub_categories.name = "farewell cards" or sub_categories.name = "keyholders"
                                    or sub_categories.name = "necklaces" or sub_categories.name = "keyholders"
                                    or sub_categories.name = "chocolates" or sub_categories.name = "perfumes & Deodorants"
                                    or sub_categories.name = "Wines" or sub_categories.name = "watches" 
                                    or sub_categories.name = "computers"
                                    or sub_categories.name = "phones" or sub_categories.name = "tablets" 
                                    or sub_categories.name = "games"');
                        $count = count($query);
                        break;
                    case 'for_him':
                        $result = DB::select('select distinct gifts.*, gifts.id as gift_id, gifts.slug as gift_slug, 
                                    categories.*, sub_categories.*, sub_categories.name as sub_category from gifts inner join sub_categories 
                                    on sub_categories.id = gifts.sub_category_id inner join categories on categories.id = gifts.category_id
                                    where category_name = "appliances" or category_name = "vases" 
                                    or sub_categories.name = "backpacks"
                                    or sub_categories.name = "spirits" or sub_categories.name = "diaries"
                                    or sub_categories.name = "pens" or sub_categories.name = "fathers day cards"
                                    or sub_categories.name = "shaving blade" or sub_categories.name = "keyholders"
                                    or sub_categories.name = "blenders" or sub_categories.name = "shaving gels"
                                    or sub_categories.name = "bluetooth speakers" or sub_categories.name = "perfumes & Deodorants"
                                    or sub_categories.name = "Wines" or sub_categories.name = "watches" 
                                    or sub_categories.name = "computers" or sub_categories.name = "alcohol"
                                    or sub_categories.name = "phones" or sub_categories.name = "tablets" 
                                    or sub_categories.name = "games" order by usd_price '. $request->price_ordering .' 
                                    limit '. $request->start .', '. $request->limit .'');
                        $query = DB::select('select distinct gifts.*, gifts.id as gift_id, gifts.slug as gift_slug, 
                                    categories.*, sub_categories.*, sub_categories.name as sub_category from gifts inner join sub_categories 
                                    on sub_categories.id = gifts.sub_category_id inner join categories on categories.id = gifts.category_id
                                    where category_name = "appliances" or category_name = "vases" 
                                    or sub_categories.name = "backpacks"
                                    or sub_categories.name = "spirits" or sub_categories.name = "diaries"
                                    or sub_categories.name = "pens" or sub_categories.name = "fathers day cards"
                                    or sub_categories.name = "shaving blade" or sub_categories.name = "keyholders"
                                    or sub_categories.name = "blenders" or sub_categories.name = "shaving gels"
                                    or sub_categories.name = "bluetooth speakers" or sub_categories.name = "perfumes & Deodorants"
                                    or sub_categories.name = "Wines" or sub_categories.name = "watches" 
                                    or sub_categories.name = "computers" or sub_categories.name = "alcohol"
                                    or sub_categories.name = "phones" or sub_categories.name = "tablets" 
                                    or sub_categories.name = "games"');
                        $count = count($query);
                        break;
                    case 'getwell_gifts':
                    case 'sympathy_gifts':
                    case 'because_gifts':
                        $result = DB::select('select distinct gifts.*, gifts.id as gift_id, gifts.slug as gift_slug, 
                                    categories.*, sub_categories.*, sub_categories.name as sub_category from gifts inner join sub_categories 
                                    on sub_categories.id = gifts.sub_category_id inner join categories on categories.id = gifts.category_id
                                    where category_name = "flowers" or category_name = "confectionery"  
                                    or category_name = "plants" or category_name = "beverages"
                                    or category_name = "vases" or category_name = "snacks"
                                    or category_name = "books" or sub_categories.name = "cupcakes"  
                                    or category_name = "games" or sub_categories.name = "chocolates" 
                                    or sub_categories.name = "perfumes & Deodorants" or sub_categories.name = "watches"
                                    order by usd_price '. $request->price_ordering .' 
                                    limit '. $request->start .', '. $request->limit .'');
                        $query = DB::select('select distinct gifts.*, gifts.id as gift_id, gifts.slug as gift_slug, 
                                    categories.*, sub_categories.*, sub_categories.name as sub_category from gifts inner join sub_categories 
                                    on sub_categories.id = gifts.sub_category_id inner join categories on categories.id = gifts.category_id
                                    where category_name = "flowers" or category_name = "confectionery"  
                                    or category_name = "plants" or category_name = "beverages"
                                    or category_name = "vases" or category_name = "snacks"
                                    or category_name = "books" or sub_categories.name = "cupcakes"  
                                    or category_name = "games" or sub_categories.name = "chocolates" 
                                    or sub_categories.name = "perfumes & Deodorants" or sub_categories.name = "watches"');
                        $count = count($query);
                        break;
                    case 'graduation_gifts':
                        $result = DB::select('select distinct gifts.*, gifts.id as gift_id, gifts.slug as gift_slug, 
                                    categories.*, sub_categories.*, sub_categories.name as sub_category from gifts inner join sub_categories 
                                    on sub_categories.id = gifts.sub_category_id inner join categories on categories.id = gifts.category_id
                                    where category_name = "confectionery" or category_name = "phones"
                                    or category_name = "computers" or category_name = "tablets" 
                                    or category_name = "appliances"
                                    or category_name = "plants" or category_name = "beverages"
                                    or category_name = "vases" or category_name = "accessories"  
                                    or sub_categories.name = "graduation cards" or sub_categories.name = "chocolates" 
                                    or sub_categories.name = "perfumes & Deodorants" or sub_categories.name = "cupcakes"
                                    or sub_categories.name = "watches" or sub_categories.name = "pens"
                                    or sub_categories.name = "whisky glasses" or sub_categories.name = "fathers day cards"
                                    or sub_categories.name = "keyholders" or sub_categories.name = "whiskey"
                                    or sub_categories.name = "necklaces" or sub_categories.name = "Sandals"
                                    or sub_categories.name = "printed t-shirts" or sub_categories.name = "printed hoodies"
                                    or sub_categories.name = "printed cups" or sub_categories.name = "spirits"
                                    or sub_categories.name = "sports" or sub_categories.name = "sports shoes"
                                    or sub_categories.name = "shaving blade" or sub_categories.name = "shaving gels"
                                    or sub_categories.name = "blenders" or sub_categories.name = "backpacks"
                                    or sub_categories.name = "bluetooth speakers" or sub_categories.name = "diaries"
                                    or sub_categories.name = "pens" or sub_categories.name = "formal shirts"
                                    or sub_categories.name = "jackets" or sub_categories.name = "laundry bags"
                                    order by usd_price '. $request->price_ordering .' 
                                    limit '. $request->start .', '. $request->limit .'');
                        $query = DB::select('select distinct gifts.*, gifts.id as gift_id, gifts.slug as gift_slug, 
                                    categories.*, sub_categories.*, sub_categories.name as sub_category from gifts inner join sub_categories 
                                    on sub_categories.id = gifts.sub_category_id inner join categories on categories.id = gifts.category_id
                                    where category_name = "confectionery" or category_name = "phones"
                                    or category_name = "computers" or category_name = "tablets" 
                                    or category_name = "appliances"
                                    or category_name = "plants" or category_name = "beverages"
                                    or category_name = "vases" or category_name = "accessories"  
                                    or sub_categories.name = "graduation cards" or sub_categories.name = "chocolates" 
                                    or sub_categories.name = "perfumes & Deodorants" or sub_categories.name = "cupcakes"
                                    or sub_categories.name = "watches" or sub_categories.name = "pens"
                                    or sub_categories.name = "whisky glasses" or sub_categories.name = "fathers day cards"
                                    or sub_categories.name = "keyholders" or sub_categories.name = "whiskey"
                                    or sub_categories.name = "necklaces" or sub_categories.name = "Sandals"
                                    or sub_categories.name = "printed t-shirts" or sub_categories.name = "printed hoodies"
                                    or sub_categories.name = "printed cups" or sub_categories.name = "spirits"
                                    or sub_categories.name = "sports" or sub_categories.name = "sports shoes"
                                    or sub_categories.name = "shaving blade" or sub_categories.name = "shaving gels"
                                    or sub_categories.name = "blenders" or sub_categories.name = "backpacks"
                                    or sub_categories.name = "bluetooth speakers" or sub_categories.name = "diaries"
                                    or sub_categories.name = "pens" or sub_categories.name = "formal shirts"
                                    or sub_categories.name = "jackets" or sub_categories.name = "laundry bags"');
                        $count = count($query);
                        break;
                    case 'for_her':
                        $result = DB::select('select distinct gifts.*, gifts.id as gift_id, gifts.slug as gift_slug, 
                                    categories.*, sub_categories.*, sub_categories.name as sub_category from gifts inner join sub_categories 
                                    on sub_categories.id = gifts.sub_category_id inner join categories on categories.id = gifts.category_id
                                    where category_name = "accessories" or category_name = "phones"
                                    or category_name = "computers" or category_name = "tablets"
                                    or category_name = "appliances" or category_name = "plasticware"
                                    or category_name = "kitchenware" or category_name = "pastries"
                                    or category_name = "plants" or category_name = "vases"
                                    or category_name = "furniture" or category_name = "household essentials"
                                    or category_name = "bed clothing" or category_name = "flowers"
                                    or category_name = "confectionary" or category_name = "snacks"
                                    or sub_categories.name = "mothers day cards" or sub_categories.name = "cutting boards"
                                    or sub_categories.name = "keyholders" or sub_categories.name = "Fruit juices"
                                    or sub_categories.name = "necklaces" or sub_categories.name = "handbags"
                                    or sub_categories.name = "printed t-shirts" or sub_categories.name = "printed hoodies"
                                    or sub_categories.name = "printed cups" or sub_categories.name = "heels"
                                    or sub_categories.name = "sports" or sub_categories.name = "sports shoes"
                                    or sub_categories.name = "diaries"
                                    or sub_categories.name = "pens"
                                    or sub_categories.name = "laundry bags"
                                    order by usd_price '. $request->price_ordering .' 
                                    limit '. $request->start .', '. $request->limit .'');
                        $query = DB::select('select distinct gifts.*, gifts.id as gift_id, gifts.slug as gift_slug, 
                                    categories.*, sub_categories.*, sub_categories.name as sub_category from gifts inner join sub_categories 
                                    on sub_categories.id = gifts.sub_category_id inner join categories on categories.id = gifts.category_id
                                    where category_name = "accessories" or category_name = "phones"
                                    or category_name = "computers" or category_name = "tablets"
                                    or category_name = "appliances" or category_name = "plasticware"
                                    or category_name = "kitchenware" or category_name = "pastries"
                                    or category_name = "plants" or category_name = "vases"
                                    or category_name = "furniture" or category_name = "household essentials"
                                    or category_name = "bed clothing" or category_name = "flowers"
                                    or category_name = "confectionary" or category_name = "snacks"
                                    or sub_categories.name = "mothers day cards" or sub_categories.name = "cutting boards"
                                    or sub_categories.name = "keyholders" or sub_categories.name = "Fruit juices"
                                    or sub_categories.name = "necklaces" or sub_categories.name = "handbags"
                                    or sub_categories.name = "printed t-shirts" or sub_categories.name = "printed hoodies"
                                    or sub_categories.name = "printed cups" or sub_categories.name = "heels"
                                    or sub_categories.name = "sports" or sub_categories.name = "sports shoes"
                                    or sub_categories.name = "diaries"
                                    or sub_categories.name = "pens"
                                    or sub_categories.name = "laundry bags"');
                        $count = count($query);
                        break;
                    case 'baby_gifts':
                        $result = DB::select('select distinct gifts.*, gifts.id as gift_id, gifts.slug as gift_slug, 
                                    categories.*, sub_categories.*, sub_categories.name as sub_category from gifts inner join sub_categories 
                                    on sub_categories.id = gifts.sub_category_id inner join categories on categories.id = gifts.category_id
                                    where category_name = "teddy_bears" or category_name = "toys" 
                                    or category_name = "babies" or category_name = "dairy" 
                                    order by usd_price '. $request->price_ordering .' 
                                    limit '. $request->start .', '. $request->limit .'');
                        $query = DB::select('select distinct gifts.*, gifts.id as gift_id, gifts.slug as gift_slug, 
                                    categories.*, sub_categories.*, sub_categories.name as sub_category from gifts inner join sub_categories 
                                    on sub_categories.id = gifts.sub_category_id inner join categories on categories.id = gifts.category_id
                                    where category_name = "teddy_bears" or category_name = "toys" 
                                    or category_name = "babies" or category_name = "dairy"');
                        $count = count($query);
                        break;
                    case 'kid_gifts':
                        $result = DB::select('select distinct gifts.*, gifts.id as gift_id, gifts.slug as gift_slug, 
                                    categories.*, sub_categories.*, sub_categories.name as sub_category from gifts inner join sub_categories 
                                    on sub_categories.id = gifts.sub_category_id inner join categories on categories.id = gifts.category_id
                                    where category_name = "confectionery" or category_name = "snacks"
                                    or category_name = "books" or sub_categories.name = "cupcakes"  
                                    or category_name = "games" or sub_categories.name = "chocolates" 
                                    or sub_categories.name = "perfumes & Deodorants" or sub_categories.name = "watches"
                                    or sub_categories.name = "bluetooth speakers" or sub_categories.name = "backpacks"
                                    or category_name = "phones" or category_name = "computers" 
                                    or category_name = "tablets" or sub_categories.name = "sports" 
                                    or sub_categories.name = "sports shoes"
                                    order by usd_price '. $request->price_ordering .' 
                                    limit '. $request->start .', '. $request->limit .'');
                        $query = DB::select('select distinct gifts.*, gifts.id as gift_id, gifts.slug as gift_slug, 
                                    categories.*, sub_categories.*, sub_categories.name as sub_category from gifts inner join sub_categories 
                                    on sub_categories.id = gifts.sub_category_id inner join categories on categories.id = gifts.category_id
                                    where category_name = "confectionery" or category_name = "snacks"
                                    or category_name = "books" or sub_categories.name = "cupcakes"  
                                    or category_name = "games" or sub_categories.name = "chocolates" 
                                    or sub_categories.name = "perfumes & Deodorants" or sub_categories.name = "watches"
                                    or sub_categories.name = "bluetooth speakers" or sub_categories.name = "backpacks"
                                    or category_name = "phones" or category_name = "computers" 
                                    or category_name = "tablets" or sub_categories.name = "sports" 
                                    or sub_categories.name = "sports shoes"');
                        $count = count($query);
                        break;
                    case 'home_gifts':
                        $result = DB::select('select distinct gifts.*, gifts.id as gift_id, gifts.slug as gift_slug, 
                                    categories.*, sub_categories.*, sub_categories.name as sub_category from gifts inner join sub_categories 
                                    on sub_categories.id = gifts.sub_category_id inner join categories on categories.id = gifts.category_id
                                    where category_name = "flowers" or category_name = "customized" 
                                    or category_name = "beverages" or category_name = "confectionery"
                                    or category_name = "dairy" or category_name = "bags"
                                    or category_name = "appliances" or category_name = "cameras"
                                    or category_name = "plasticware" or category_name = "kitchenware"
                                    or category_name = "snacks" or category_name = "bed clothing" or category_name = "plants"
                                    or category_name = "vases" or sub_categories.name = "printed cups"
                                    order by usd_price '. $request->price_ordering .' 
                                    limit '. $request->start .', '. $request->limit .'');
                        $query = DB::select('select distinct gifts.*, gifts.id as gift_id, gifts.slug as gift_slug, 
                                    categories.*, sub_categories.*, sub_categories.name as sub_category from gifts inner join sub_categories 
                                    on sub_categories.id = gifts.sub_category_id inner join categories on categories.id = gifts.category_id
                                    where category_name = "flowers" or category_name = "customized" 
                                    or category_name = "beverages" or category_name = "confectionery"
                                    or category_name = "dairy" or category_name = "bags"
                                    or category_name = "appliances" or category_name = "cameras"
                                    or category_name = "plasticware" or category_name = "kitchenware"
                                    or category_name = "snacks" or category_name = "bed clothing" or category_name = "plants"
                                    or category_name = "vases" or sub_categories.name = "printed cups"');
                        $count = count($query);
                        break;
                    case 'wedding_gifts':
                        $result = DB::select('select distinct gifts.*, gifts.id as gift_id, gifts.slug as gift_slug, 
                                    categories.*, sub_categories.*, sub_categories.name as sub_category from gifts inner join sub_categories 
                                    on sub_categories.id = gifts.sub_category_id inner join categories on categories.id = gifts.category_id
                                    where category_name = "teddy_bears" or category_name = "flowers"
                                    or category_name = "jewelry" or category_name = "combo gifts"
                                    or category_name = "kitchenware" or category_name = "appliances"
                                    or category_name = "plants" or category_name = "plasticware"
                                    or category_name = "accessories" or category_name = "beverages"
                                    or category_name = "customizable" 
                                    or sub_categories.name = "wedding cakes" or sub_categories.name = "wedding cards"
                                    or sub_categories.name = "chocolates" or sub_categories.name = "perfumes & Deodorants"
                                    or sub_categories.name = "Valentines Teddy Bears" or sub_categories.name = "Wines"
                                    or sub_categories.name = "Couple Matching Clothes"
                                    order by usd_price '. $request->price_ordering .' 
                                    limit '. $request->start .', '. $request->limit .'');
                        $query = DB::select('select distinct gifts.*, gifts.id as gift_id, gifts.slug as gift_slug, 
                                    categories.*, sub_categories.*, sub_categories.name as sub_category from gifts inner join sub_categories 
                                    on sub_categories.id = gifts.sub_category_id inner join categories on categories.id = gifts.category_id
                                    where category_name = "teddy_bears" or category_name = "flowers"
                                    or category_name = "jewelry" or category_name = "combo gifts"
                                    or category_name = "kitchenware" or category_name = "appliances"
                                    or category_name = "plants" or category_name = "plasticware"
                                    or category_name = "accessories" or category_name = "beverages"
                                    or category_name = "customizable" 
                                    or sub_categories.name = "wedding cakes" or sub_categories.name = "wedding cards"
                                    or sub_categories.name = "chocolates" or sub_categories.name = "perfumes & Deodorants"
                                    or sub_categories.name = "Valentines Teddy Bears" or sub_categories.name = "Wines"
                                    or sub_categories.name = "Couple Matching Clothes"');
                        $count = count($query);
                        break;
                    default: 
                        $result = DB::table('gifts')
                                    ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                    ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                    ->select('gifts.*', 'gifts.id as gift_id', 'gifts.slug as gift_slug', 'categories.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                    ->orderBy('usd_price', $request->price_ordering)
                                    ->distinct()
                                    ->offset($request->start)
                                    ->limit($request->limit)
                                    ->get();
                        $count = DB::table('gifts')
                                    ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                                    ->join('categories', 'categories.id', '=', 'gifts.category_id')
                                    ->select('gifts.*', 'gifts.id as gift_id', 'gifts.slug as gift_slug', 'categories.*', 'sub_categories.*', 'sub_categories.name as sub_category')
                                    ->orderBy('usd_price', $request->price_ordering)
                                    ->distinct()
                                    ->count();
                }

                if($count > 0){
                    foreach($result as $gift){
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
                        $now = time() * 1000;

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
                                        <span>Sale Ends:</span>
                                        <span class="ml-1 d-flex align-items-center" id="countdown-timer'.$gift->id.'">00d:00h:00m:00s</span>
                                    </div>
                                ';
                            } else {
                                // Show that the sale is closed
                                $timer = '
                                    <div class="d-flex align-items-center justify-content-between text-sm">
                                        <span>Sale Ends:</span>
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

                        $output .= '
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
                                                <p class="font-600 text-capitalize mt-1 mb-0 py-0 product-name popover-info" id="'. $gift->id .'">
                                                    '. Str::words($gift->gift_name, 2, '') .'
                                                </p>
                                            </a>
                                            <a href="/category/'. $gift->category_name .'" class="text-sm font-500 text-capitalize my-0 py-0">
                                                '. $gift->category_name .'
                                            </a>
                                            '. $star_rating .'
                                        </div>
                                        <div class="pull-up-1">
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
                                                <button class="btn btn-primary btn-sm d-flex align-items-center add-to-cart-btn rounded-left font-600" data-id="'. $gift->id .'">
                                                    <i class="material-icons text-white mr-1">add_shopping_cart</i>
                                                    Buy <span class="text-white text-white ml-1">gift</span rounded-right>
                                                </button>
                                                <button class="btn border-primary btn-sm text-primary compare-btn d-flex align-items-center rounded-right font-600" id="compare-btn'. $gift->id .'" data-name="'. $short_name .'" data-id="'. $gift->id .'">
                                                    <i class="material-icons text-primary mr-1">compare_arrows</i>
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
                }
                
                if($count == 1){
                    $gift_count = '1 gift item in stock';
                } else {
                    $gift_count = $count . ' gift items in stock';
                }
                
                return response()->json([
                    'result'      => $result,
                    'gifts'      => $output,
                    'gift_count' => $gift_count
                ]);
            }
        }
    }
}
