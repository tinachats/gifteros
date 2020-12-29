<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Cart;
use App\Models\Gift;

class CartController extends Controller
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
     * @param  int  $gift_id
     */
    public function addItem(Request $request, $gift_id)
    {
        if($request->ajax()){
            if($request->action == 'add-to-cart'){
                $gift = Gift::find($gift_id);
                $old_cart = Session::has('cart') ? Session::get('cart') : null;
                $cart = new Cart($old_cart);
                $cart->add($gift, $gift_id);

                $request->session()->put('cart', $cart);
                return response()->json([
                    'success' => 'Gift successfully added into cart'
                ]);
            }
        }
    }

    public function addToCart(Request $request)
    {
        if($request->ajax()){
            if($request->action == 'add-item'){
                $item = [
                    'gift_id'     => $request->gift_id,
                    'gift_name'   => $request->gift_name,
                    'gift_image'  => $request->gift_image,
                    'usd_price'   => $request->usd_price,
                    'zar_price'   => $request->zar_price,
                    'zwl_price'   => $request->zwl_price,
                    'sale_end_time'  => $request->sale_end_time,
                    'gift_quantity'  => $request->gift_quantity,
                    'gift_units'     => $request->gift_units,
                    'category_name'  => $request->category_name
                ];
                Session::put('cart', $item);
                return response()->json([
                    'message' => 'success'
                ]);
            }
        }
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

    public function checkout()
    {
        $suburbs = DB::table('suburbs')
                    ->orderBy('suburb_name', 'asc')
                    ->distinct()
                    ->get();
        $title = 'Checkout Page';
        $data = [
            'suburbs' => $suburbs,
            'title' => $title
        ];
        return view('checkout')->with($data);
    }
}
