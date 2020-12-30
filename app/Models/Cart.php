<?php

namespace App\Models;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Cart
{
    public $items =  null;
    public $count_cart = 0;
    public $total_cart = 0;

    public function __construct($old_cart)
    {
        if($old_cart){
            $this->items = $old_cart->items;
            $this->count_cart = $old_cart->count_cart;
            $this->total_cart = $old_cart->total_cart;
        } 
    }

    public function add($item, $gift_id)
    {
        $stored_item = [
            'usd_price'            => number_format($this->usd_price, 2),
            'zar_price'            => number_format($this->zar_price, 2),
            'zwl_price'            => number_format($this->zwl_price, 2),
            'qty'                  => 0,
            'item'                 => $item
        ];

        if($this->items){
            if(array_key_exists($gift_id, $this->items)){
                $stored_item = $this->items[$gift_id];
            }
        }
        $stored_item['qty']++;
        $stored_item['usd_price'] = number_format($item->usd_price * $stored_item['qty'], 2);
        $stored_item['zar_price'] = number_format($item->zar_price * $stored_item['qty'], 2);
        $stored_item['zwl_price'] = number_format($item->zwl_price * $stored_item['qty'], 2);
        $this->items[$gift_id] = $stored_item;
        $this->count_cart++;
        $this->total_cart += $item->usd_price;
    }

    // Code to be reviewed
    public function addToCart(Request $request)
    {
        if($request->ajax()){
            if($request->action == 'add-item'){
                $usd_total = $zar_total = $zwl_total = $item_count = 0;
                // Any item array with all required props
                $gift_id = $request->gift_id;
                $item = [
                    'gift_id'        => $gift_id,
                    'gift_name'      => $request->gift_name,
                    'gift_image'     => $request->gift_image,
                    'usd_price'      => $request->usd_price,
                    'zar_price'      => $request->zar_price,
                    'zwl_price'      => $request->zwl_price,
                    'sale_end_time'  => $request->sale_end_time,
                    'gift_quantity'  => $request->gift_quantity,
                    'gift_units'     => $request->gift_units,
                    'category_name'  => $request->category_name
                ];
               
                $cart = Session::get('cart', []);
                Session::put('cart', $cart);

                if(isset($cart[$gift_id])){
                    $cart[$gift_id]['qty']++;
                } else {
                    $cart[$gift_id]['qty'] = 1;
                }
                Session::put('cart', $cart);
                $item_count = $cart[$gift_id]['qty'];
                $count_cart = count(Session::get('cart'));
                $usd_total = number_format($cart['usd_price'] * $cart['qty'], 2);
                $zar_total = number_format($cart['zar_price'] * $cart['qty'], 2);
                $zwl_total = number_format($cart['zwl_price'] * $cart['qty'], 2);
                
                return response()->json([
                    'message'    => 'success',
                    'usd_total'  => $usd_total,
                    'count_cart' => $count_cart,
                    'cart'       => $cart,
                    'item_count' => $item_count
                ]);
            }
        }
    }
}
