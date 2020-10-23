<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Search extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //  
    }

    public function fetch(Request $request){
        if($request->ajax()){
            $output = '';
            $query = $request->get('search');
            $results = DB::table('gifts')
                         ->join('categories', 'categories.id', '=', 'gifts.category_id')
                         ->where('gift_name', 'like', '%'.$query.'%')
                         ->orderBy('usd_price', 'asc')
                         ->take(5)
                         ->get();
            $count = DB::table('gifts')
                        ->join('categories', 'categories.id', '=', 'gifts.category_id')
                        ->where('gift_name', 'like', '%'.$query.'%')
                        ->orderBy('usd_price', 'asc')
                        ->count();
            if($count > 0){
                foreach($results as $gift){
                    $output .= '
                        <!-- Search result -->
                        <li class="list-group-item rounded-0 lh-100 px-1 py-2">
                            <div class="d-flex justify-content-between align-items-start">
                                <a href="'.route('details.show', [$gift->slug, $gift->id]).'">
                                    <div class="media">
                                        <img src="/storage/gifts/'.$gift->gift_image.'" height="55" width="55" alt="" class="rounded-2 align-self-center mr-2">
                                        <div class="media-body">
                                            <p class="text-sm font-600 text-capitalize my-0 py-0">'.mb_strimwidth($gift->gift_name, 0, 30, '...').'</p>
                                            <p class="text-sm font-weight-light text-lowercase text-faded my-0 py-0">'.$gift->category_name.'</p>
                                            '.giftStarRating($gift->id).'
                                            <p class="text-sm font-500 text-capitalize text-faded my-0 py-0 d-flex">
                                                <span class="border-right pr-2">Only '.$gift->units.' left</span>
                                                <span class="pl-2 text-capitalize">'.$gift->label.'</span>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                                <div class="d-block text-center">
                                    <p class="font-600 my-0 pt-0 pb-1 text-sm usd-price">US$'.number_format($gift->usd_price, 2).'</p>
                                    <p class="font-600 my-0 pt-0 pb-1 text-sm zar-price d-none">R'.number_format($gift->zar_price, 2).'</p>
                                    <p class="font-600 my-0 pt-0 pb-1 text-sm zwl-price d-none">ZW$'.number_format($gift->zwl_price, 2).'</p>
                                    <button class="btn btn-primary btn-sm border-primary pt-1">
                                        Buy now
                                    </button>
                                </div>
                            </div>
                        </li>
                        <!-- /Search result --> 
                    ';
                }
                if($count > 5){
                    $output .= '
                        <li class="list-group-item rounded-0 lh-100 py-3 text-center text-sm font-600">
                            <a id="view-search-results" href="">See all '.$count.' results</a>
                        </li>
                    ';
                }
            } else {
                $output .= '
                        <!-- Search result -->
                        <li class="list-group-item rounded-0 lh-100 px-1 py-2">
                            <div class="d-flex flex-column justify-content-center text-center">
                                <i class="material-icons lead text-faded fa-2x">search</i>
                                <span class="text-faded">
                                    Sorry! We couldn\'t find any gift item(s) that match your search.
                                </span>
                            </div>
                        </li>
                        <!-- /Search result --> 
                    ';
            }
            $data = [
                'count'   => $count,
                'results' => $output
            ];
            return json_encode($data);
        }
    }
}
