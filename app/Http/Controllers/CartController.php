<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function shoppingCart(Request $request)
    {
        if($request->ajax()){
            if($request->action == 'shopping-cart'){
                $usd_subtotal = $zar_subtotal = $zwl_subtotal = 0;
                $usd_total = $zar_total = $zwl_total = 0;
                $usd_delivery_cost = session()->get('shipping_costs')['usd_delivery_cost'] ?? 0;
                $zar_delivery_cost = number_format($usd_delivery_cost * zaRate(), 2) ?? 0;
                $zwl_delivery_cost = number_format($usd_delivery_cost * zwRate(), 2) ?? 0;
                $usd_discount = session()->get('coupon')['usd_value'] ?? 0;
                $zar_discount = session()->get('coupon')['zar_value'] ?? 0;
                $zwl_discount = session()->get('coupon')['zwl_value'] ?? 0;
                $shopping_cart = $cart_items = '';
                $cart = Session::get('cart', []);
                $count_cart = count($cart);

                if($count_cart !== 0){
                    $shopping_cart .= '
                        <div class="list-group-item box-shadow-sm rounded-top-2 lh-100 px-1 py-2 fixed-top">
                            <h6 class="lead font-600 ml-2 my-0">'.$count_cart.' giftbox  items</h6>
                        </div>
                    ';
                    foreach($cart as $key => $value){
                        $usd_subtotal += ($value['qty'] * $value['usd_price']);
                        $zar_subtotal += ($value['qty'] * $value['zar_price']);
                        $zwl_subtotal += ($value['qty'] * $value['zwl_price']);
                        $usd_total = ($usd_subtotal + $usd_delivery_cost) - $usd_discount;
                        $zar_total = ($zar_subtotal + $zar_delivery_cost) - $zar_discount;
                        $zwl_total = ($zwl_subtotal + $zwl_delivery_cost) - $zwl_discount;
                        $count_cart += $value['qty'];
                        $cart_items .= '
                            <!-- Cart Item -->
                            <li class="list-group-item rounded-0 lh-100 px-1 py-2 cart-menu-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="d-flex w-100">
                                        <!-- Product Item -->
                                        <div class="media align-items-center">
                                            <div class="cart-menu-img-wrapper">
                                                <div class="d-sm-flex d-xl-none flex-column justify-content-center text-center cart-actions-sm">
                                                    <i role="button" class="fa fa-chevron-circle-up text-success-warning subtract-product"></i>
                                                    <span class="font-600 text-success-warning item-count'.$value['gift_id'].'">0</span>
                                                    <i role="button" class="fa fa-chevron-circle-down text-success-warning increase-qty"></i>
                                                </div>
                                                <a href="">
                                                    <img src="/storage/gifts/'.$value['gift_image'].'" height="55" width="55" alt="" class="rounded-2 align-self-center menu-item-img mr-2">
                                                </a>
                                            </div>

                                            <!-- Product Item Details -->
                                            <div class="media-body cart-item-details" id="cart-item-details">
                                                <p class="text-sm font-600 text-capitalize my-0 py-0">
                                                    '.Str::words($value['gift_name'], 2, ' ...').'
                                                </p>
                                                '.giftStarRating($value['gift_id']).'
                                                <p class="text-sm font-500 text-lowercase text-faded my-0 py-0 d-flex">
                                                    <span class="pr-2">'.$value['qty'].' in giftbox</span>
                                                </p>
                                            </div>
                                            <!-- Product Item Details -->
                                            <!-- Cart Actions -->
                                            <div class="hidden-product-actions w-100">
                                                <div class="d-flex align-items-center justify-content-center m-0 p-0 cursor">
                                                    <span role="button" class="product-actions material-icons text-success subtract-product" data-id="'.$value['gift_id'].'" title="Subtract quantity">remove_circle</span>
                                                    <span role="button" class="product-actions text-faded mx-4">'.$value['qty'].'</span>
                                                    <span role="button" class="product-actions material-icons text-success increase-qty" data-id="'.$value['gift_id'].'" title="Add more items">add_circle</span>
                                                </div>
                                            </div>
                                            <!-- /.Cart Actions -->
                                        </div>
                                        <!-- /.Product Item -->
                                    </div>
                                    <div class="d-block text-center">
                                        <p class="font-600 my-0 pt-0 pb-1 text-sm usd-price">US$'.number_format($value['qty'] * $value['usd_price'], 2).'</p>
                                        <p class="font-600 my-0 pt-0 pb-1 text-sm zar-price d-none">R'.number_format($value['qty'] * $value['zar_price'], 2).'</p>
                                        <p class="font-600 my-0 pt-0 pb-1 text-sm zwl-price d-none">ZW$'.number_format($value['qty'] * $value['zwl_price'], 2).'</p>
                                        <span role="button" class="fa fa-trash-o fa-2x text-danger remove-item" data-id="'.$value['gift_id'].'" onclick="removeItem('.$value['gift_id'].')" title="Remove Item" data-action="remove-product"></span>
                                    </div>
                                </div>
                            </li>
                            <!-- /.Cart Item -->
                        ';
                    }
                    $shopping_cart .= $cart_items;
                } else {
                    $shopping_cart = '
                        <li class="list-group-item d-inline-block text-center rounded-2 lh-100 w-100">
                            <i class="fa fa-dropbox fa-3x text-faded"></i>
                            <h5 class="font-600 text-faded">Your giftbox is empty!</h5>
                        </li>
                    ';
                    $cart_items = '
                        <li class="list-group-item d-inline-block text-center rounded-0 lh-100 w-100">
                            <i class="fa fa-dropbox fa-3x text-faded"></i>
                            <h5 class="font-600 text-faded">Your giftbox is empty!</h5>
                        </li>
                    ';
                }
                $data = [
                    'message'           => 'success',
                    'shopping_cart'     => $shopping_cart,
                    'cart_items'        => $cart_items,
                    'cart'              => $cart,
                    'count_cart'        => count(Session::get('cart', [])),
                    'usd_subtotal'      => number_format($usd_subtotal, 2),
                    'zar_subtotal'      => number_format($zar_subtotal, 2),
                    'zwl_subtotal'      => number_format($zwl_subtotal, 2),
                    'usd_delivery_cost' => number_format($usd_delivery_cost, 2),
                    'zar_delivery_cost' => number_format($zar_delivery_cost, 2),
                    'zwl_delivery_cost' => number_format($zwl_delivery_cost, 2),
                    'usd_discount'      => number_format($usd_discount, 2),
                    'zar_discount'      => number_format($zar_discount, 2),
                    'zwl_discount'      => number_format($zwl_discount, 2),
                    'usd_total'         => number_format($usd_total, 2),
                    'zar_total'         => number_format($zar_total, 2),
                    'zwl_total'         => number_format($zwl_total, 2),
                ];
                return response()->json($data);
            }
        }
    }

    // Add a gift item into the shopping cart
    public function addToCart(Request $request)
    {
        if($request->ajax()){
            if($request->action == 'add-item'){
                $item_count = 0;

                $gift_id = $request->gift_id;

                $item = [
                    'gift_id'        => $gift_id,
                    'gift_name'      => $request->gift_name,
                    'gift_image'     => $request->gift_image,
                    'usd_price'      => $request->usd_price,
                    'zar_price'      => $request->zar_price,
                    'zwl_price'      => $request->zwl_price,
                    'sale_end_time'  => $request->sale_end_time,
                    'qty'            => $request->gift_quantity,
                    'gift_units'     => $request->gift_units,
                    'category_name'  => $request->category_name
                ];

                // Get cart data from the cart session
                $cart = Session::get('cart', []);

                // Check if cart session is set
                if(Session::has('cart')){
                    // if cart not empty then check if this gift 
                    // exist then increment quantity
                    if(array_key_exists($gift_id, $cart)){
                        $cart[$gift_id]['qty']++;
                    } else {
                        $cart[$gift_id] = $item;
                    }
                    $item_count = $cart[$gift_id]['qty'];
                    Session::put('cart', $cart);
                } else {
                    // if cart is empty then this the first gift
                    $cart = [
                        $gift_id => $item
                    ];
                    $item_count =  1;
                    Session::put('cart', $cart);
                }

                $data = [
                    'message'    => 'success',
                    'cart'       => $cart,
                    'count_cart' => count($cart),
                    'item_count' => $item_count
                ];

                return response()->json($data);
            }
        }
    }

    // Subtract a gift item quantity from the shopping cart
    function decreaseQty(Request $request)
    {
        if($request->ajax()){
            if($request->action == 'decrease-qty'){
                $item_count = 0;
                $gift_id = $request->gift_id;
                $cart = Session::get('cart', []);
                if(Session::has('cart')){
                    foreach($cart as $key => $value){
                        if($value['gift_id'] === $gift_id){
                            if($cart[$key]['qty'] >= 1){
                                $cart[$gift_id]['qty']--;
                                $item_count = $cart[$gift_id]['qty'];
                            } else {
                                unset($cart[$gift_id]);
                                $item_count = 0;
                            }
                        }
                    }
                }
                Session::put('cart', $cart);
                return response()->json([
                    'message'    => 'success',
                    'item_count' => $item_count
                ]); 
            }
        }
    }

    // Remove an item from the cart
    function removeItem(Request $request)
    {
        if($request->ajax()){
            if($request->action == 'remove-item'){
                $gift_id = $request->gift_id;
                // Retrieve the session 
                $cart = Session::get('cart', []);
                unset($cart[$gift_id]);
                Session::put('cart', $cart);
                $item_count = 0;
                return response()->json([
                    'message'    => 'success',
                    'item_count' => $item_count
                ]);
            }
        }
    }

    // Clear the shopping cart
    public function clearCart(Request $request)
    {
        if($request->ajax()){
            if($request->action == 'clear-cart'){
                if(Session::has('cart')){
                    Session::forget('cart');
                    Session::save();
                    return response()->json([
                        'message' => 'success'
                    ]);
                }
            }
        }
    }

    // Harare suburbs
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

    // Success page
    public function success()
    {
        $data = [
            'title' => 'Order Success'
        ];
        return view('success')->with($data);
    }

    // Delivery (Shipping) costs
    public function shippingCosts(Request $request)
    {
        if($request->ajax()){
            if($request->action == 'shipping-costs'){
                $usd_delivery_cost = number_format($request->usd_delivery_cost, 2);
                $zar_delivery_cost = number_format($request->zar_delivery_cost, 2);
                $zwl_delivery_cost = number_format($request->zwl_delivery_cost, 2);
                session()->put('shipping_costs', [
                    'usd_delivery_cost' => $usd_delivery_cost,
                    'zar_delivery_cost' => $zar_delivery_cost,
                    'zwl_delivery_cost' => $zwl_delivery_cost,
                ]);
            }
        }
    }
}
