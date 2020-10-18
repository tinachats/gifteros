<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $title = 'Gifteros';
        $showcase_gifts = DB::table('gifts')
                            ->join('categories', 'categories.id', '=', 'gifts.category_id')
                            ->get();
        $customized_gifts = DB::table('gifts')
                            ->join('categories', 'categories.id', '=', 'gifts.category_id')
                            ->select('gifts.*', 'categories.category_name')
                            ->where('label', 'customizable')
                            ->take(4)
                            ->get();
        $kitchenware = DB::table('gifts')
                            ->join('categories', 'categories.id', '=', 'gifts.category_id')
                            ->select('gifts.*', 'categories.category_name')
                            ->where('category_id', 9)
                            ->orderBy('usd_price', 'asc')
                            ->take(4)
                            ->get();
        $plasticware =  DB::table('gifts')
                            ->join('categories', 'categories.id', '=', 'gifts.category_id')
                            ->select('gifts.*', 'categories.category_name')
                            ->where('category_id', 21)
                            ->orderBy('usd_price', 'asc')
                            ->take(4)
                            ->get();
        $combo_gifts =  DB::table('gifts')
                            ->join('categories', 'categories.id', '=', 'gifts.category_id')
                            ->select('gifts.*', 'categories.category_name')
                            ->where('category_id', 34)
                            ->orderBy('usd_price', 'asc')
                            ->take(4)
                            ->get();
        $appliances =  DB::table('gifts')
                            ->join('categories', 'categories.id', '=', 'gifts.category_id')
                            ->select('gifts.*', 'categories.category_name')
                            ->where('category_id', 8)
                            ->orderBy('usd_price', 'asc')
                            ->take(4)
                            ->get();
        $data = [
            'showcase_gifts'   => $showcase_gifts,
            'customized_gifts' => $customized_gifts, 
            'kitchenware'      => $kitchenware,
            'plasticware'      => $plasticware,
            'combo_gifts'      => $combo_gifts, 
            'appliances'       => $appliances,
            'title'            => $title
        ];
        return view('index')->with($data);
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
                                ['category_name', '=', 'pastries'],
                                ['category_name', '=', 'confectionery'],
                                ['gifts.id', '!=', $id]
                            ])
                            ->orderBy('usd_price', 'asc')
                            ->get();
        $title = DB::table('gifts')
                    ->where('id', $id)
                    ->value('gift_name');
        $data = [
            'title' => $title,
            'gift'  => $gift,
            'greeting_cards' => $greeting_cards,
            'wrappers' => $wrappers,
            'accesories' => $accesories
        ];
        return view('/details.show')->with($data);
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
