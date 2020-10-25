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
        $saved_gifts = $count_wishlist = '';
        $wishlist = DB::table('wishlist')
                   ->join('gifts', 'gifts.id', '=', 'wishlist.gift_id')
                   ->join('categories', 'categories.id', '=', 'gifts.category_id')
                   ->join('sub_categories', 'sub_categories.id', '=', 'gifts.sub_category_id')
                   ->join('users', 'users.id', '=', 'wishlist.user_id')
                   ->where('users.id', Auth::user()->id)
                   ->orderBy('usd_price', 'asc')
                   ->get();
        $count = $wishlist->count();
        if($count > 0){
            $count_wishlist = $count;
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
        } else {
            $saved_gifts = '
                <i class="material-icons text-faded">favorite_border</i>
                <div class="text-sm font-500 ml-1">
                    0 gifts saved
                </div>
            ';
        }
        $title = 'Gifteros | My Wishlist ('.$count.')';
        $data = [
            'wishlist'          => $wishlist,
            'title'             => $title,
            'count_wishlist'    => $count_wishlist,
            'saved_gifts'       => $saved_gifts
        ];
        return view('wishlist.index')->with($data);
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
