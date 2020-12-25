<?php

namespace App\Models;

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
}
