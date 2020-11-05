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

    // Fetch user's notifications
    public function notifications(Request $request)
    {
        if($request->ajax()){
            $message = $output = $fullname = $notification_type = '';
            $notifications = DB::table('notifications')
                                ->leftJoin('users', 'users.id', '=', 'notifications.user_id')
                                ->leftJoin('orders', 'orders.user_id', '=', 'notifications.user_id')
                                ->leftJoin('gift_ratings', 'gift_ratings.rating_id', '=', 'notifications.channel_id')
                                ->leftJoin('gifts', 'gifts.id', '=', 'gift_ratings.gift_id')
                                ->select('notifications.*', 'orders.*', 'users.*', 'gift_ratings.*', 'gifts.*', 'notifications.created_at as notified_at')
                                ->where([
                                    ['gift_ratings.user_id', '=', Auth::user()->id],
                                    ['notifications.status', '=', 'not-seen'],
                                    ['notifications.user_id', '<>', Auth::user()->id]
                                ])
                                ->orWhere('orders.user_id', Auth::user()->id)
                                ->orderByDesc('notifications.created_at')
                                ->get();
            $count = $notifications->count();
            if($count > 0){
                if($count == 1){
                    $message = '1 Notification';
                } else {
                    $message = $count . ' Notifications';
                }
                $output .= '
                    <div class="dropdown-item text-sm border-bottom">
                        <div class="d-flex align-items-center justify-content-around text-primary">
                            <span class="text-capitalization font-600">'.$message.'</span>
                            <span role="button" class="mx-2">Settings</span>
                        </div>
                    </div>
                ';
                foreach($notifications as $result){
                    if(Auth::user()->name === $result->name){
                        $fullname = 'Me';
                    } else {
                        $fullname = $result->name;
                    }
                    if($result->notification_type == 'comment'){
                        $notification_type = '
                            <!-- Notification -->
                            <div class="dropdown-item my-0 py-1">
                                <a href="'. route("details.show", [$result->slug, $result->gift_id]) .'">
                                    <div class="media lh-100">
                                        <img src="/storage/users/'.$result->profile_pic.'" height="40" width="40" alt="" class="rounded-circle align-self-center mr-2">
                                        <div class="media-body text-sm">
                                            <p class="my-0 py-0" id="subject">
                                                <span class="font-600 text-capitalize">'.mb_strimwidth($fullname, 0, 30, '...').'</span> commented on
                                            </p>
                                            <p class="text-faded my-0 py-1">
                                                '.mb_strimwidth($result->customer_review, 0, 38, '...').'
                                            </p>
                                            <div class="d-flex align-items-center text-faded">
                                                <i class="tiny material-icons text-blue mr-1">forum</i> '.timeago($result->notified_at).'
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <!-- /.Notification -->
                        ';
                    } else if($result->notification_type == 'like'){
                        $notification_type = '
                            <!-- Notification -->
                            <div class="dropdown-item my-0 py-1">
                                <a href="'. route("details.show", [$result->slug, $result->gift_id]) .'">
                                    <div class="media lh-100">
                                        <img src="/storage/users/'.$result->profile_pic.'" height="40" width="40" alt="" class="rounded-circle align-self-center mr-2">
                                        <div class="media-body text-sm">
                                            <p class="my-0 py-0" id="subject">
                                                <span class="font-600 text-capitalize">'.mb_strimwidth($fullname, 0, 30, '...').'</span> found this helpful
                                            </p>
                                            <p class="text-faded my-0 py-1">
                                                '.mb_strimwidth($result->customer_review, 0, 38, '...').'
                                            </p>
                                            <div class="d-flex align-items-center text-faded">
                                                <i class="tiny material-icons text-success mr-1">thumb_up</i> '.timeago($result->notified_at).'
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <!-- /.Notification -->
                        ';
                    } else if($result->notification_type == 'order-confirmed'){
                        $notification_type = '
                            <!-- Notification -->
                            <div class="dropdown-item my-0 py-1">
                                <a href="orders.php">
                                    <div class="media lh-100">
                                        <img src="'. asset("img/app/visionaries-logo.png") .'" height="40" width="40" alt="" class="rounded-circle align-self-center mr-2">
                                        <div class="media-body text-sm">
                                            <p class="my-0 py-0" id="subject">
                                                <span class="font-600 text-capitalize">Targets</span>
                                            </p>
                                            <p class="text-faded my-0 py-1">
                                                Your order has been confirmed!
                                            </p>
                                            <div class="d-flex align-items-center text-faded">
                                                <i class="small material-icons text-blue mr-1">store</i> '.timeago($result->notified_at).'
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <!-- /.Notification -->
                        ';
                    } else {
                        $notification_type = '
                            <!-- Notification -->
                            <div class="dropdown-item my-0 py-1">
                                <a href="'. route("orders") .'">
                                    <div class="media lh-100">
                                        <img src="dist/img/app/visionaries-logo.png" height="40" width="40" alt="" class="rounded-circle align-self-center mr-2">
                                        <div class="media-body text-sm">
                                            <p class="my-0 py-0" id="subject">
                                                <span class="font-600 text-capitalize">Targets</span>
                                            </p>
                                            <p class="text-faded my-0 py-1">
                                                Your order is now on the way!
                                            </p>
                                            <div class="d-flex align-items-center text-faded">
                                                <i class="small material-icons text-blue mr-1">local_shipping</i> '.timeago($result->notified_at).'
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <!-- /.Notification -->
                        ';
                    }
                    $output .= $notification_type;
                }
            } else {
                $output .= '
                    <div class="dropdown-item my-0 py-2">
                        <h6 class="font-600 text-sm">
                            You\'ve no notifications at the moment.
                        </h6>
                    </div>
                ';
            }
            if(!empty($request->status)){
                $results = DB::table('notifications')
                                ->leftJoin('users', 'users.id', '=', 'notifications.user_id')
                                ->leftJoin('orders', 'orders.user_id', '=', 'notifications.user_id')
                                ->leftJoin('gift_ratings', 'gift_ratings.rating_id', '=', 'notifications.channel_id')
                                ->leftJoin('gifts', 'gifts.id', '=', 'gift_ratings.gift_id')
                                ->select('notifications.*', 'orders.*', 'users.*', 'gift_ratings.*', 'gifts.*', 'notifications.created_at as notified_at')
                                ->where([
                                    ['gift_ratings.user_id', '=', Auth::user()->id],
                                    ['notifications.status', '=', 'not-seen'],
                                    ['notifications.user_id', '<>', Auth::user()->id]
                                ])
                                ->orWhere('orders.user_id', Auth::user()->id)
                                ->orderByDesc('notifications.created_at')
                                ->get();
                foreach($results as $result){
                    DB::table('notifications')
                        ->where([
                            'channel_id' => $result->channel_id
                        ])
                        ->orWhere([
                            'channel_id' => $result->rating_id
                        ])
                        ->update(['status' => 'seen']);
                }
            }
            $data = array(
                'count'         => $count,
                'notifications' => $output,
                'notification'  => $message
            );
            return response()->json($data);
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

    // Fetch all gift review's comments
    public function review_comments(Request $request)
    {
        if($request->ajax()){
            if($request->action == 'review-comments'){
                $output = '';
                $comments = DB::table('review_comments')
                               ->join('users', 'users.id', '=', 'review_comments.user_id')
                               ->select('review_comments.*', 'users.*', 'review_comments.created_at as commented_at', 'users.id as user_id')
                               ->where('rating_id', $request->post_id)
                               ->orderByDesc('review_comments.created_at')
                               ->get();
                $count = $comments->count();
                if($count > 0){
                    foreach($comments as $comment){
                        $output .= ' 
                            <!-- Comment -->
                            <div class="comment mb-2">
                                <div class="media">
                                    <img src="/storage/users/'.$comment->profile_pic.'" height="30" width="30" alt="" class="rounded-circle align-self-start mt-1 mr-2">
                                    <div class="comment-body media-body">
                                        <p class="d-flex justify-content-between align-items-center text-sm font-600 my-0 py-0">
                                            <span class="text-capitalize">'.$comment->name.'</span> 
                                            <span class="text-sm text-muted">'.timeago($comment->commented_at).'</span>
                                        </p>
                                        <p class="mt-0 pt-0 text-sm text-faded text-justify">
                                            '.$comment->comment.'
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!-- /.Comment -->
                        ';
                    }
                }
                return response()->json([
                    'review_comments' => $output
                ]);
            }
        }
    }

    // Submitting a gift review comment
    public function submit_comment(Request $request)
    {
        if($request->ajax()){
            if($request->action == 'submit-comment'){
                $data = array(
                    'user_id'     => Auth::user()->id,
                    'rating_id'   => $request->post_id,
                    'comment'     => $request->comment
                );
                DB::table('review_comments')->insert($data);
                DB::table('notifications')->insert([
                    'user_id'           => Auth::user()->id,
                    'channel_id'        => $request->post_id,
                    'notification_type' => 'comment'
                ]);
                return response()->json([
                    'status' => 'success'
                ]);
            }
        }
    }
}