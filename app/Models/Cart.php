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
                $usd_subtotal = $zar_subtotal = $zwl_subtotal = 0;
                $count_cart = $item_count = $is_available = 0;
                $cart = [];

                $item = [
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

                // Any item array with all required props
                $gift_id = $request->gift_id;

                // Check if the cart session has data
                if(Session::has('cart')){
                    // Get cart data from the session
                    $cart = Session::get('cart');

                    // Check if the added gift item is already in the cart
                    if(array_key_exists($gift_id, $cart)){
                        $cart[$gift_id]['qty']++;
                    } else {
                        $cart[$gift_id]['qty'] = 1;
                    }
                    $item_count = $cart[$gift_id]['qty'];
                    Session::push('cart', $cart);
                } else {
                    $cart[$gift_id]['qty'] = 1;
                    $item_count = 1;
                    Session::put('cart', $cart);
                }
                
                $count_cart = count(Session::get('cart'));
               
                $data = [
                    'message'    => 'success',
                    'cart'       => $cart,
                    'count_cart' => $count_cart,
                    'item_count' => $item_count
                ];

                return response()->json($data);
            }
        }
    }
}
