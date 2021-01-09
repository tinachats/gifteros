<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;

class CouponController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->ajax()){
            if($request->action == 'coupon'){
                $discount = 0;
                $message = '';
                $subtotal = $request->subtotal;
                $coupon = Coupon::where('code', $request->coupon)->first();
                if($coupon){
                    $discount = $coupon->discount($subtotal);
                    $message = 'Coupon has been applied';
                } else {
                    $discount = 0;
                    $message = 'Invalid coupon code';
                }
                return response()->json([
                    'message'  => $message,
                    'discount' => $discount
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
