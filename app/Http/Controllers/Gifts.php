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
