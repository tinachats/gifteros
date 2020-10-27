<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MailingList extends Controller
{
    /**
     * Update or insert user's records both in the mailing_list and users table
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function subscribe(Request $request)
    {
        if($request->ajax()){
            if($request->action){
                $data = [
                    'name'         => $request->post('fullname'),
                    'email'        => $request->post('email-address'),
                    'mobile_phone' => $request->post('mobile-number'),
                    'address'      => $request->post('customer-location'),
                    'birthday'     => $request->post('birth-year') . '/' . $request->post('birth-month') . '/' . $request->post('birthday-date'),
                    'gender'       => $request->post('gender'),
                ];

                // Check to see if the record already exist
                $count = DB::table('mailing_list')
                            ->select('mobile_phone')
                            ->where('mobile_phone', $request->post('mobile-number'))
                            ->count();
                if($count > 0){
                    DB::table('mailing_list')
                        ->where('mobile_phone', $request->post('mobile-number'))
                        ->update($data);
                    
                    if(!empty(Auth::user()->id)){
                        DB::table('users')
                            ->where('id', Auth::user()->id)
                            ->update(
                                [
                                    'name'         => $request->post('fullname'),
                                    'email'        => $request->post('email-address'),
                                    'mobile_phone' => $request->post('mobile-number'),
                                    'address'      => $request->post('customer-location'),
                                    'birthday'     => $request->post('birth-year') . '/' . $request->post('birth-month') . '/' . $request->post('birthday-date'),
                                    'gender'       => $request->post('gender'),
                                    'newsletter'   => 'subscribed'
                                ]
                            );
                    }  
                } else {
                    DB::table('mailing_list')->insert($data);
                    if(!empty(Auth::user()->id)){
                        DB::table('users')
                            ->where('id', Auth::user()->id)
                            ->update(
                                [
                                    'name'         => $request->post('fullname'),
                                    'email'        => $request->post('email-address'),
                                    'mobile_phone' => $request->post('mobile-number'),
                                    'address'      => $request->post('customer-location'),
                                    'birthday'     => $request->post('birth-year') . '/' . $request->post('birth-month') . '/' . $request->post('birthday-date'),
                                    'gender'       => $request->post('gender'),
                                    'newsletter'   => 'subscribed'
                                ]
                            );
                    } 
                }  
                return response()->json([
                    'message' => 'success'
                ]);
            }
        }
    }
}
