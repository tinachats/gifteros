<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the user account's page
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $birth_date = $birth_month = $birth_year = '';
        Auth::user()->id = auth()->user()->id;
        $user = User::find(Auth::user()->id);
        $title = ucfirst($user->name);
        $recipients = DB::select('select distinct recipients_cell, count(*) as recipient from recipients where user_id = :user_id group by recipients_cell', ['user_id' => Auth::user()->id]);
        $data = [
            'title'      => $title,
            'posts'      => $user->posts,
            'recipients' => $recipients
        ];
        return view('account')->with($data);
    }

    public function profile(Request $request)
    {
        if($request->ajax()){
            $output = $address = $mobile_phone = $gift_reviews = '';
            $count_reviews = '';
            if($request->action){
                // Fetching user profile details
                $result = DB::table('users')
                             ->where('id', Auth::user()->id)
                             ->get();
                foreach($result as $row){
                    if(empty($row->address) && empty($row->city)){
                        $address = '
                            Address: N/A
                        ';
                    } else {
                        $address = $row->address. ', ' . $row->city;
                    }
                    if(empty($row->mobile_phone)){
                        $mobile_phone = 'Cell: N/A';
                    } else {
                        $mobile_phone = '
                            Cell: '.$row->mobile_phone.'
                        ';
                    }
                    $output .= '
                        <div class="card delivery-pad box-shadow-sm rounded-0">
                            <label class="mb-0" for="cover-img">
                                <input class="d-none" type="file" name="cover-img" id="cover-img" onchange="displayCoverImg(this)" accept="image/*">
                                <span role="button" class="floating-btn edit-icon" title="Change cover page" onclick="changeCoverPic()">
                                    <i class="material-icons m-auto">edit</i>
                                </span>
                            </label>
                        <div class="box-shadow-lg img-frame">
                            <img src="/storage/users/'. Auth::user()->profile_pic .'" class="prof-pic" height="120" width="120" alt="">
                        </div>
                        <img src="/storage/cover-page/'. Auth::user()->cover_page .'" height="200" alt="" class="card-img-top cover-page rounded-0">
                        <div class="card-body py-0 text-center">
                            <h5 class="display-5 mb-0 pb-0 text-capitalize">'. Auth::user()->name .'</h5>
                            <p class="text-capitalize text-sm text-faded my-0 py-0">
                                '. $address .'
                            </p>
                            <p class="text-sm text-faded my-0 py-0">
                                '. $mobile_phone .'
                            </p>
                            <p class="text-muted text-sm">
                                Customer since '. date('M. d, Y', strtotime($row->created_at)) .'
                            </p>
                        </div>
                        </div>
                        <div class="card box-shadow-sm rounded-0">
                            <div class="card-body p-0">
                                <div class="d-flex justify-content-around">
                                    <div class="d-block text-center">
                                        <div class="text-primary mt-1 d-flex align-items-center justify-content-center">
                                            <i class="material-icons text-blue">redeem</i>
                                            <span class="font-500 text-blue">
                                                '. totalBought(Auth::user()->id) .'
                                            </span>
                                        </div>
                                        <h6 class="text-muted text-sm font-600">Gifts Bought</h6>
                                    </div>
                                    <div class="border-right"></div>
                                    <div class="d-block text-center">
                                        <div class="text-primary mt-1 d-flex align-items-center">
                                            <i class="material-icons text-blue">account_balance_wallet</i>
                                            <span class="usd-price font-500 text-blue">
                                                $'. totalSpent(Auth::user()->id) .'
                                            </span>
                                            <span class="zar-price d-none font-500 text-blue">
                                                R'. totalSpent(Auth::user()->id) .'
                                            </span>
                                            <span class="zwl-price d-none font-500 text-blue">
                                                $'. totalSpent(Auth::user()->id) .'
                                            </span>
                                        </div>
                                        <h6 class="text-muted text-sm font-600">Total Spent</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    ';
                }
                // Fetching user gift reviews
                $reviews = DB::table('gift_ratings')
                              ->join('users', 'users.id', '=', 'gift_ratings.user_id')
                              ->join('gifts', 'gifts.id', '=', 'gift_ratings.gift_id')
                              ->where('gift_ratings.user_id', Auth::user()->id)
                              ->orderBy('gift_ratings.rating_id', 'desc')
                              ->get();
                $count = $reviews->count();
                if($count > 0){
                    $gift_reviews .= '<div class="col-12 col-xl-8">';
                    foreach($reviews as $review){
                        $gift_id = $review->gift_id;
    
                        $verified_purchase = verifiedPurchase($gift_id, Auth::user()->id);
                        if(!empty($verified_purchase)){
                            $verified_purchase = verifiedPurchase($gift_id, Auth::user()->id);
                        }
    
                        $gift_reviews .= '
                            <div class="user-review-card bg-whitesmoke box-shadow-lg rounded-3">
                                <!-- gift Review -->
                                <div class="d-flex align-items-start justify-content-between">
                                    <div class="media review-post mb-0 pb-0 ml-1">
                                        <img src="/storage/users/'.Auth::user()->profile_pic.'" alt="" height="40" width="40" class="rounded-circle align-self-start mt-2 mr-2 prof-pic">
                                        <div class="media-body">
                                            <div class="d-block user-details">
                                                <p class="font-500 text-capitalize my-0 py-0">'.Auth::user()->name.'</p>
                                                '.$verified_purchase.'
                                                '.customerRating($review->rating_id, $gift_id, Auth::user()->id).'
                                            </div>
                                        </div>
                                    </div>
                                    <div class="dropdown m-3">
                                        <span role="button" class="material-icons text-faded" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">more_horiz</span>
                                        <div class="dropdown-menu dropdown-menu-right box-shadow-sm">
                                            <div class="d-flex align-items-center p-2" data-review_id="'.$review->rating_id.'">
                                                <i class="fa fa-trash-o icon-md mr-1 text-faded"></i>
                                                <span class="text-capitalize text-faded">Delete review post</span>
                                            </div>
                                            <div class="d-flex align-items-center p-2" data-review_id="'.$review->rating_id.'">
                                                <i class="fa fa-facebook icon-md mr-1 text-faded"></i>
                                                <span class="text-capitalize text-faded">Share on Facebook</span>
                                            </div>
                                            <div class="d-flex align-items-center p-2" data-review_id="'.$review->rating_id.'">
                                                <i class="fa fa-instagram icon-md mr-1 text-faded"></i>
                                                <span class="text-capitalize text-faded">Share on Instagram</span>
                                            </div>
                                            <div class="d-flex align-items-center p-2" data-review_id="'.$review->rating_id.'">
                                                <i class="fa fa-twitter icon-md mr-1 text-faded"></i>
                                                <span class="text-capitalize text-faded">Share on Twitter</span>
                                            </div>
                                            <div class="d-flex align-items-center p-2" data-review_id="'.$review->rating_id.'">
                                                <i class="fa fa-linkedin icon-md mr-1 text-faded"></i>
                                                <span class="text-capitalize text-faded">Share on LinkedIn</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- User\'s Post -->
                                <div class="customer-post">
                                    <p class="text-justify text-faded px-2 ml-1">
                                        '.$review->customer_review.'
                                    </p>
                                    <a href="'.route('details.show', [$review->slug, $gift_id]).'">
                                        <img src="/storage/gifts/'.$review->gift_image.'" alt="'.$review->gift_name.'" class="w-100 border-top border-bottom" height="300" title="View gift">
                                    </a>
                                    <p class="text-sm text-faded px-2 m-1">
                                        '.reviewLikes($review->rating_id, $gift_id).'
                                    </p>
                                    <div class="mt-2 post-actions border-top">
                                        <div class="d-flex align-items-center justify-content-around w-100 p-2">
                                            <span>'.helpful_btn($review->rating_id, $gift_id, Auth::user()->id).'</span>
                                            <span>'.unhelpful_btn($review->rating_id, $gift_id, Auth::user()->id).'</span>
                                            <div class="d-flex d-cursor align-items-center text-sm text-faded mr-2 toggle-comments" data-post_id="'.$review->rating_id.'" data-user_id="' . $review->user_id . '">
                                                <i class="tiny material-icons mr-1">forum</i>('.countReviewComments($review->rating_id).')
                                            </div>
                                            <span role="button" class="tiny material-icons text-faded">share</span>
                                        </div>
                                    </div>
                                    <!-- Commend section -->
                                    <div class="comment-section my-2" id="comment-box'.$review->rating_id.'">
                                        <div id="old-comments'.$review->rating_id.'" class="mx-2">
                                            <!-- Review comments will show up here -->
                                        </div>
                                        <!-- Comment form -->
                                        <div class="d-flex align-items-center">
                                            <img src="/storage/users/'.Auth::user()->profile_pic.'" height="30" width="30" alt="" class="rounded-circle mr-1">
                                            <input type="text" class="form-control form-control-sm rounded-pill" placeholder="Press enter to submit comment" name="add-comment" id="add-comment" data-post_id="'.$review->rating_id.'" data-user_id="' . $review->user_id . '">
                                        </div>
                                        <!-- /.comment form -->
                                    </div>
                                    <!-- /.Commend section -->
                                </div>
                                <!-- /.User\'s Post -->
                                <!-- /.gift review -->
                            </div>
                        ';
                    }
                    $gift_reviews .= '</div>';
                } else {
                    $gift_reviews = '
                        <div class="container justify-content-center w-100 my-5">
                            <div class="col-12 text-center no-content">
                                <i class="material-icons text-muted lead">forum</i>
                                <h5 class="font-600">You\'ve not rated any gift yet!</h5>
                                <p class="text-sm">
                                    If you review any particular gift, your review and rating information will be shown here!
                                </p>
                            </div>
                        </div>
                    ';
                }
                if($count == 1){
                    $count_reviews = '1 Gift Review';
                } else {
                    $count_reviews = $count . ' Gift Reviews';
                }
                return response()->json([
                    'user_data'     => $output,
                    'gift_reviews'  => $gift_reviews,
                    'count_reviews' => $count_reviews
                ]);
            }
        }
    }
}
