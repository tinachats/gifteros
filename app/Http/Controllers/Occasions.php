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
        $category = explode('_', $occasion);
        $title = ucfirst($category[0]) . ' ' . ucfirst($category[1]);
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
            'title'       => $title,
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
                $output = $gift_count = '';
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
                    $output .= '
                        <div class="d-grid grid-view grid-p-1 mt-3 products-shelf" id="category-gifts">
                    ';
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
                                            <a href="'. route('gifts_category', [$gift->category_id, $gift->category_slug]) .'" class="text-sm font-500 text-capitalize my-0 py-0">
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
                    $output .= '</div>';
                } else {
                    $output = '
                        <div class="container justify-content-center w-100 my-5" id="null-gifts">
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
                    'result'      => $result,
                    'gifts'      => $output,
                    'gift_count' => $gift_count
                ]);
            }
        }
    }
}
