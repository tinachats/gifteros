<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Stripe extends Controller
{
    public function checkout(Request $request)
    {
        if($request->ajax()){
            if($request->action == 'customer-order'){
                // Cart details 
                $usd_subtotal = $zar_subtotal = $zwl_subtotal = 0;
                $usd_total = $zar_total = $zwl_total = $stripe_amount = 0;
                $has_coupon = false;
                $cart_items = [];
                $usd_delivery_cost = session()->get('shipping_costs')['usd_delivery_cost'] ?? 0;
                $zar_delivery_cost = number_format($usd_delivery_cost * zaRate(), 2) ?? 0;
                $zwl_delivery_cost = number_format($usd_delivery_cost * zwRate(), 2) ?? 0;
                $usd_discount = session()->get('coupon')['usd_value'] ?? 0;
                $zar_discount = session()->get('coupon')['zar_value'] ?? 0;
                $zwl_discount = session()->get('coupon')['zwl_value'] ?? 0;

                // Check if the order has a coupon
                if($usd_discount == 0){
                    $has_coupon = false;
                } else {
                    $has_coupon = true; 
                }

                $cart = session()->get('cart');
                foreach($cart as $key => $value){
                    $usd_subtotal += ($value['qty'] * $value['usd_price']);
                    $zar_subtotal += ($value['qty'] * $value['zar_price']);
                    $zwl_subtotal += ($value['qty'] * $value['zwl_price']);
                    $usd_total = ($usd_subtotal + $usd_delivery_cost) - $usd_discount;
                    $zar_total = ($zar_subtotal + $zar_delivery_cost) - $zar_discount;
                    $zwl_total = ($zwl_subtotal + $zwl_delivery_cost) - $zwl_discount;
                    $cart_items[] = $value['gift_name'].' ('.$value['qty'].')';
                }
                $count_cart = count($cart);

                // User details
                $user_id = Auth::user()->id;
                $suburb = $request->input('suburb');
                $fullname = explode(' ', $request->input('fullname'));
                $first_name = $fullname[0];
                $last_name = $fullname[1];
                $recipient_cell = $request->input('mobile-number');
                $recipient_address = $request->input('customer-address');
                $recipient_email = $request->input('customer-email') ?? '';
                $delivery_date = date('Y-m-d H:i:s', strtotime($request->input('delivery-date')));
                $date = date('d', strtotime($request->input('delivery-date')));
                $month = date('M', strtotime($request->input('delivery-date')));
                $order_date = date('Y-m-d H:i:s');
                $occasion = $request->occasion;
                $currency = $request->input('currency');

                if($currency == 'usd'){
                    $stripe_amount = round($usd_total * 100);
                } else if($currency == 'zar'){
                    $stripe_amount = round($zar_total * 100);
                }

                $data = [
                    'user_id'                => $user_id,
                    'gift_items'             => json_encode($cart_items),
                    'ordered_items'          => $count_cart,
                    'customer_name'          => $first_name,
                    'customer_surname'       => $last_name,
                    'customer_email'         => $recipient_email,
                    'customer_phone'         => $recipient_cell,
                    'customer_address'       => $recipient_address,
                    'customer_city'          => $suburb,
                    'occasion'               => $occasion,
                    'order_gateway'          => 'stripe',
                    'usd_total'              => $usd_total,
                    'zar_total'              => $zar_total,
                    'zwl_total'              => $zwl_total,
                    'delivery_date'          => $delivery_date
                ];

                // Insert into the orders table and retrieve the last inserted ID
                $order_id = DB::table('orders')->insertGetId($data);

                // Create an order's number
                $track_id = trackID($order_id, $order_date);
                
                // Insert every gift in the giftbox
                foreach($cart as $key => $value){
                    $gift_array = [
                        'order_id'      => $order_id,
                        'track_id'      => $track_id,
                        'gift_id'       => $value['gift_id'],
                        'gift_name'     => $value['gift_name'],
                        'gift_image'    => $value['gift_image'],
                        'quantity'      => $value['qty'],
                        'usd_price'     => $value['usd_price'],
                        'zar_price'     => $value['zar_price'],
                        'zwl_price'     => $value['zwl_price']
                    ];
                    DB::table('ordered_gifts')->insert($gift_array);
                    
                    // Decrease the gift units 
                    DB::table('gifts')
                       ->decrement('units', $value['qty'], ['id'=> $value['gift_id']]);
                }

                DB::table('gift_customizations')
                   ->where('user_id', $user_id)
                   ->update(['status' => 'customized']);

                // Check if recipient is a registered customer
                $customer_data = DB::table('users')
                               ->where('mobile_phone', $recipient_cell)
                               ->get();
                if(count($customer_data) > 0){
                    foreach($customer_data as $row){
                        $data = [
                            'user_id'            => $user_id, 
                            'friend_id'          => $row->id, 
                            'recipients_name'    => $first_name, 
                            'recipients_surname' => $last_name, 
                            'recipients_cell'    => $recipient_cell, 
                            'recipients_email'   => $recipient_email, 
                            'recipients_address' => $recipient_address, 
                            'recipients_city'    => $suburb, 
                            'status'             => 'friend'
                        ];
                        DB::table('recipients')->insert($data);
                    }
                } else {
                    $data = [
                        'user_id'            => $user_id, 
                        'recipients_name'    => $first_name, 
                        'recipients_surname' => $last_name, 
                        'recipients_cell'    => $recipient_cell, 
                        'recipients_email'   => $recipient_email, 
                        'recipients_address' => $recipient_address, 
                        'recipients_city'    => $suburb, 
                        'status'             => 'recipient'
                    ];
                    DB::table('recipients')->insert($data);
                }
                $address = preg_replace('/\s/', '', $recipient_address);
                $suburb = preg_replace('/\s/', '', $suburb);
                $params = [
                    'name'      => $first_name,
                    'surname'   => $last_name,
                    'email'     => $recipient_email ?? 'Null',
                    'cell'      => $recipient_cell,
                    'address'   => $address,
                    'suburb'    => $suburb,
                    'items'     => $count_cart,
                    'total'     => $usd_total,
                    'trackid'   => $track_id,
                    'coupon'    => $has_coupon,
                    'delivery_date' => $delivery_date,    
                    'date'      => $date,
                    'month'     => $month,
                    'occasion'  => $occasion ?? 'Null'
                ];
                // Clear the cart
                session()->forget('cart');

                // Clear the shipping session
                session()->forget('shipping_costs');

                // Update the coupons table set newbie_coupon status to used
                DB::table('coupons')->where([
                    'user_id'   => $user_id,
                    'type'      => 'newbie_coupon',
                    'status'    => 'not-used'
                ])->update(['status' => 'used']);

                // Forget the coupons session
                session()->forget('coupons');

                $url = url('/success', $params);
                return response()->json([
                    'message' => 'success',
                    'url'     => $url
                ]);
            }
        }
    }
}
