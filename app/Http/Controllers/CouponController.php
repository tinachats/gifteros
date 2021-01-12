<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    // Get a newbie coupon
    public function newbieCoupon(Request $request)
    {
        if($request->ajax()){
            if($request->action == 'newbie-coupon'){
                // Create a newbie coupon
                DB::table('coupons')
                   ->updateOrInsert(
                        [
                            'user_id' => Auth::user()->id,
                            'type'    => 'newbie_coupon',
                            'status'  => 'not-used'
                        ],
                        [
                            'code'    => strtoupper(uniqid(true)),
                            'value'   => number_format(2, 2),
                        ]
                    );
                // Put coupon info in a coupon session
                session()->put('coupon', [
                    'code'      => strtoupper(uniqid(true)),
                    'usd_value' => number_format(2, 2),
                    'zar_value' => number_format((2 * zaRate()), 2),
                    'zwl_value' => number_format((2 * zwRate()), 2),
                ]);

                return response()->json([
                    'message' => 'success'
                ]);
            }
        }
    }

    /**
     * Verify resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function verifyCoupon(Request $request)
    {
        if($request->ajax()){
            if($request->action == 'coupon'){
                $message = '';
                $usd_discount = $zar_discount = $zwl_discount = 0;
                $usd_subtotal = $request->usd_subtotal;
                $zar_subtotal = $request->zar_subtotal;
                $zwl_subtotal = $request->zwl_subtotal;
                if(session()->has('coupon')){
                    $coupon = Coupon::where('code', $request->coupon)->first();
                    $usd_discount = $coupon->discount($usd_subtotal);
                    $zar_discount = $coupon->discount($zar_subtotal);
                    $zwl_discount = $coupon->discount($zwl_subtotal);
                    session()->put('coupon', [
                        'coupon_code'  => $request->coupon,
                        'usd_discount' =>  $usd_discount,
                        'zar_discount' =>  $zar_discount,
                        'zwl_discount' =>  $zwl_discount
                    ]);
                    $message = 'Coupon has been applied';
                } else {
                    $message = 'Invalid coupon code';
                }
                return response()->json([
                    'message'      => $message,
                    'usd_discount' => $usd_discount,
                    'zar_discount' => $zar_discount,
                    'zwl_discount' => $zwl_discount
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
    }
}
