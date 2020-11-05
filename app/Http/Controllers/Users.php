<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class Users extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // Change profile picture
    public function profile_pic(Request $request)
    {
        if($request->ajax()){
            // Save user's profile picture
            $this->validate($request, [
                'profile_pic' => 'image|nullable|max:4999'
            ]);

            // Handle file upload
            if($request->hasFile('profile-pic')){
                // Get extension
                $ext = $request->file('profile-pic')->getClientOriginalExtension();
                // Filename to store
                $profile_pic = uniqid(true) . '.' . $ext;
                // Upload cover image
                $path = $request->file('profile-pic')->storeAs('public/users', $profile_pic);
            } else {
                $profile_pic = 'user.png';
            }

            // Update user's profile
            $update = DB::table('users')
                         ->where('id', Auth::user()->id)
                         ->update([
                             'profile_pic' => $profile_pic
                         ]);

            return response()->json([
                'message' => 'Profile picture successfully updated!'
            ]);
        }

    }

    // Change cover page
    public function cover_page(Request $request)
    {
        if($request->ajax()){
            // Save user's profile picture
            $this->validate($request, [
                'cover-img' => 'image|nullable|max:4999'
            ]);

            // Handle file upload
            if($request->hasFile('cover-img')){
                // Get extension
                $ext = $request->file('cover-img')->getClientOriginalExtension();
                // Filename to store
                $cover_page = uniqid(true) . '.' . $ext;
                // Upload cover image
                $path = $request->file('cover-img')->storeAs('public/cover-page', $cover_page);
            } else {
                $cover_page = 'default-coverpage.png';
            }

            // Update user's profile
            $update = DB::table('users')
                         ->where('id', Auth::user()->id)
                         ->update([
                            'cover_page' => $cover_page
                         ]);

            return response()->json([
                'message' => 'Cover page successfully updated!'
            ]);
        }

    }
    
    // Change account info
    public function update_profile(Request $request)
    {
        if($request->ajax()){
            if($request->action){
                DB::table('users')
                    ->where('id', Auth::user()->id)
                    ->update([
                        'name'         => $request->post('name'),
                        'email'        => $request->post('email'),
                        'mobile_phone' => $request->post('mobile_phone'),
                        'address'      => $request->post('address'),
                        'city'         => $request->post('city')        ,
                        'birthday'     => $request->post('bithday'),
                    ]);
                return response()->json([
                    'message' => 'updated'
                ]);
            }
        }
    }

    // Check if password entered is same as one in storage
    public function check_password(Request $request)
    {
        if($request->ajax()){
            if($request->action){
                $password = DB::table('users')
                               ->select('password')
                               ->where('id', Auth::user()->id)
                               ->value('password');
                if(password_verify($request->post('password'), $password)){
                    return response()->json([
                        'message' => 'correct'
                    ]);
                } else {
                    return response()->json([
                        'message' => 'incorrect'
                    ]);
                } 
            }
        }
    }

    // Change user's acccount password
    public function change_password(Request $request)
    {
        if($request->ajax()){
            if($request->action){
                $new_password = password_hash($request->post('new_password'), PASSWORD_DEFAULT);
                $update = DB::table('users')
                    ->where('id', Auth::user()->id)
                    ->update([
                        'password' => $new_password
                    ]);
                if($update){
                    return response()->json([
                        'message' => 'success'
                    ]);
                } else {
                    return response()->json([
                        'message' => 'error'
                    ]);
                }
            }
        }
    }

    // Fetch user's info
    public function user_info(Request $request)
    {
        if($request->ajax()){
            if($request->action == 'user-info'){
                $count_wishlist = DB::table('wishlist')
                                    ->where('user_id', Auth::user()->id)
                                    ->count();
                if(!empty(Auth::user()->birthday)){
                    $birthday = explode('/', Auth::user()->birthday);
                    $birth_year = $birthday[0];
                    $birth_month = $birthday[1];
                    $birth_date = $birthday[2];
                } else {
                    $birth_year = 1900;
                    $birth_month = 'january';
                    $birth_date = 01;
                }
                return response()->json([
                    'count_wishlist' => $count_wishlist,
                    'birth_date' => $birth_date,
                    'birth_month'=> $birth_month,
                    'birth_year' => $birth_year
                ]);
            }
        }
    }

    // Add gift item to wishlist
    public function wish(Request $request)
    {
        if($request->ajax()){
            if($request->action == 'wish'){
                $data = [
                    'gift_id' => $request->post('gift_id'),
                    'user_id' => $request->post('user_id')
                ];
                DB::table('wishlist')->insert($data);
                return response()->json([
                    'message' => 'Gift item added to your Wishlist'
                ]);
            }
        }
    }

    // Remove gift item from wishlist
    public function unwish(Request $request)
    {
        if($request->ajax()){
            if($request->action == 'unwish'){
                DB::table('wishlist')
                    ->where([
                        'gift_id' => $request->post('gift_id'),
                        'user_id' => $request->post('user_id')
                    ])
                    ->delete();
                return response()->json([
                    'message' => 'Gift item removed from your Wishlist'
                ]);
            }
        }
    }

    // Submit customer gift review
    public function gift_review(Request $request)
    {
        if($request->ajax()){
            if($request->action == 'gift-review'){
                $data = [
                    'gift_id'         => $request->post('gift-id'),
                    'user_id'         => Auth::user()->id,
                    'customer_rating' => $request->post('star-rating'),
                    'customer_review' => $request->post('user-review')
                ];
                DB::table('gift_ratings')->insert($data);
                return response()->json([
                    'message' => 'success'
                ]);
            }
        }
    }

    // Click on the helpful button
    public function helpful(Request $request)
    {
        if($request->ajax()){
            if($request->action == 'helpful'){
                $data = [
                    'rating_id'  => $request->rating_id,
                    'gift_id'    => $request->gift_id,
                    'user_id'    => Auth::user()->id
                ];
                DB::table('helpful')->insert($data);
                $check = DB::table('unhelpful')
                            ->select('rating_id')
                            ->where('rating_id', $request->rating_id)
                            ->get();
                if($check->count() > 0){
                    DB::table('unhelpful')
                        ->where('rating_id', $request->rating_id)
                        ->delete();
                }
                DB::table('notifications')->insert([
                    'user_id'           => Auth::user()->id,
                    'channel_id'        => $request->rating_id,
                    'notification_type' => $request->notification_type
                ]);
                $queue = [
                    'status'     => 'helpful',
                    'message'    => 'Thank you for your feedback!'
                ];
                return response()->json($queue);
            }
        }
    }

    // Click on the unhelpful button
    public function unhelpful(Request $request)
    {
        if($request->ajax()){
            if($request->action == 'unhelpful'){
                $data = [
                    'rating_id'  => $request->rating_id,
                    'gift_id'    => $request->gift_id,
                    'user_id'    => Auth::user()->id
                ];
                DB::table('helpful')
                        ->where($data)
                        ->delete();
                DB::table('notifications')
                        ->where([
                            'channel_id' => $request->rating_id,
                            'user_id'   => Auth::user()->id
                        ])
                        ->delete();
                $queue = [
                    'status'     => 'unhelpful',
                    'message'    => ''
                ];
                return response()->json($queue);
            }
        }
    }

    // Click on the like button
    public function like(Request $request)
    {
        if($request->ajax()){
            if($request->action == 'like'){
                $data = [
                    'rating_id'  => $request->rating_id,
                    'gift_id'    => $request->gift_id,
                    'user_id'    => Auth::user()->id
                ];
                DB::table('unhelpful')
                        ->where($data)
                        ->delete();
                DB::table('notifications')
                        ->where([
                            'channel_id' => $request->rating_id,
                            'user_id'   => Auth::user()->id
                        ])
                        ->delete();
                $queue = [
                    'status'     => 'cancel',
                    'message'    => ''
                ];
                return response()->json($queue);
            }
        }
    }

    // Click on the unlike button
    public function unlike(Request $request)
    {
        if($request->ajax()){
            if($request->action == 'unlike'){
                $data = [
                    'rating_id'  => $request->rating_id,
                    'gift_id'    => $request->gift_id,
                    'user_id'    => Auth::user()->id
                ];
                DB::table('unhelpful')->insert($data);
                DB::table('helpful')
                        ->where($data)
                        ->delete();
                DB::table('notifications')->insert([
                            'user_id'           => Auth::user()->id,
                            'channel_id'        => $request->rating_id,
                            'notification_type' => $request->notification_type
                        ]);
                $queue = [
                    'status'     => 'unhelpful',
                    'message'    => 'Thank you for your feedback!'
                ];
                return response()->json($queue);
            }
        }
    }
}