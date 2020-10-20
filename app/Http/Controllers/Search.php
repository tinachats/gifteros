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
        return view('search');
    }

    public function fetch(Request $request){
        if($request->ajax()){
            $query = $request->get('search');
            $results = DB::table('gifts')
                         ->join('categories', 'categories.id', '=', 'gifts.category_id')
                         ->where('gift_name', 'like', '%'.$query.'%')
                         ->orderBy('usd_price', 'asc')
                         ->get();
            $output = '';
            if(count($results) > 0){
                foreach($results as $gift){
                    $output .= '
                        <!-- Search result -->
                        <li class="list-group-item rounded-0 lh-100 px-1 py-2">
                            <div class="d-flex justify-content-between align-items-start">
                                <a href="">
                                    <div class="media">
                                        <img src="/storage/gifts/'.$gift->gift_image.'" height="55" width="55" alt="" class="rounded-2 align-self-center mr-2">
                                        <div class="media-body">
                                            <p class="text-sm font-600 text-capitalize my-0 py-0">'.$gift->gift_name.'</p>
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
            } else {
                $output .= '
                        <!-- Search result -->
                        <li class="list-group-item rounded-0 lh-100 px-1 py-2">
                            <div class="d-block text-center">
                                <i class="material-icons lead text-faded">extension</i>
                                <span class="font-600 text-faded">
                                    No gift item(s) match your search.
                                </span>
                            </div>
                        </li>
                        <!-- /Search result --> 
                    ';
            }
            return Response($output);
        }
    }
}
