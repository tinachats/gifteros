<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Gift;
use Gloudemans\ShoppingCart\Facades\Cart;

class CartController extends Controller
{
    public function shoppingCart(Request $request)
    {
        if($request->ajax()){
            if($request->action == 'shopping-cart'){
                $cart = Session::get('cart', []);
                $count_cart = count($cart);
                if($count_cart !== 0){
                    foreach($cart as $gift){
                        $shopping_cart = '
                            <!-- Cart Item -->
                            <li class="list-group-item rounded-0 lh-100 px-1 py-2 cart-menu-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="d-flex w-100">
                                        <!-- Product Item -->
                                        <div class="media align-items-center">
                                            <div class="cart-menu-img-wrapper">
                                                <div class="d-sm-flex d-xl-none flex-column justify-content-center text-center cart-actions-sm">
                                                    <i role="button" class="fa fa-chevron-circle-up text-success-warning subtract-product"></i>
                                                    <span class="font-600 text-success-warning">2</span>
                                                    <i role="button" class="fa fa-chevron-circle-down text-success-warning increase-qty"></i>
                                                </div>
                                                <a href="">
                                                    <img src="/storage/gifts/15f47b9066c522.jpg" height="55" width="55" alt="" class="rounded-2 align-self-center menu-item-img mr-2">
                                                </a>
                                            </div>

                                            <!-- Product Item Details -->
                                            <div class="media-body cart-item-details" id="cart-item-details">
                                                <p class="text-sm font-600 text-capitalize my-0 py-0">
                                                    Sculp Massager
                                                </p>
                                                <p class="text-sm font-weight-light text-lowercase text-faded my-0 py-0">Personal Care</p>
                                                <ul class="list-inline star-rating">
                                                    <li class="list-inline-item text-warning">&starf;</li>
                                                    <li class="list-inline-item text-warning star-rating">&starf;</li>
                                                    <li class="list-inline-item text-warning star-rating">&starf;</li>
                                                    <li class="list-inline-item text-warning star-rating">&starf;</li>
                                                    <li class="list-inline-item text-faded star-rating">&star;</li>
                                                    <li class="list-inline-item text-faded star-rating text-sm font-600">(125)</li>
                                                </ul>
                                                <p class="text-sm font-500 text-lowercase text-faded my-0 py-0 d-flex">
                                                    <span class="pr-2">2 in giftbox</span>
                                                </p>
                                            </div>
                                            <!-- Product Item Details -->
                                            <!-- Cart Actions -->
                                            <div class="hidden-product-actions w-100">
                                                <div class="d-flex align-items-center justify-content-center m-0 p-0">
                                                    <span role="button" class="product-actions material-icons text-success subtract-product">remove_circle</span>
                                                    <span role="button" class="product-actions text-faded mx-4">2</span>
                                                    <span role="button" class="product-actions material-icons text-success increase-qty">add_circle</span>
                                                </div>
                                            </div>
                                            <!-- /.Cart Actions -->
                                        </div>
                                        <!-- /.Product Item -->
                                    </div>
                                    <div class="d-block text-center">
                                        <p class="font-600 my-0 pt-0 pb-1 text-sm usd-price">US$12.99</p>
                                        <p class="font-600 my-0 pt-0 pb-1 text-sm zar-price d-none">R214.34</p>
                                        <p class="font-600 my-0 pt-0 pb-1 text-sm zwl-price d-none">ZW$1299</p>
                                        <i role="button" class="fa fa-trash-o fa-2x text-danger remove-item" title="Remove Item" data-action="remove-product"></i>
                                    </div>
                                </div>
                            </li>
                            <!-- /.Cart Item -->
                        ';
                    }
                } else {
                    $shopping_cart = '
                        <li class="list-group-item d-inline-block text-center rounded-0 lh-100 w-100">
                            <i class="fa fa-dropbox fa-3x text-faded"></i>
                            <h5 class="font-600 text-faded">Your giftbox is empty!</h5>
                        </li>
                    ';
                }
                $data = [
                    'message'       => 'success',
                    'shopping_cart' => $shopping_cart,
                    'count_cart'    => $count_cart,
                    'usd_total'     => 0,
                    'zar_total'     => 0,
                    'zwl_total'     => 0,
                ];
                return response()->json($data);
            }
        }
    }

    public function addToCart(Request $request)
    {
        if($request->ajax()){
            if($request->action == 'add-item'){
                $usd_subtotal = $zar_subtotal = $zwl_subtotal = 0;
                $count_cart = $item_count = $is_available = 0;
                $cart = [];

                // Any item array with all required props
                $gift_id = $request->gift_id;

                $item = [
                    'id'             => $gift_id,
                    'name'           => $request->gift_name,
                    'quantity'       => $request->gift_quantity,
                    'price'          => $request->usd_price,
                ];

                Cart::add($item);

                Session::put('cart', $cart);
                $item_count = 1;
                $count_cart = Cart::count();
                $cart = Cart::content();
                $usd_subtotal = Cart::subtotal($decimals, '.', ',');
               
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

    // Clear the shopping cart
    public function clearCart(Request $request)
    {
        if($request->ajax()){
            if($request->action == 'clear-cart'){
                Session::flush();
                return response()->json([
                    'message' => 'success'
                ]);
            }
        }
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
