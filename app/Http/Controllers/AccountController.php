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
    public function index(Request $request)
    {
        Auth::user()->id = auth()->user()->id;
        $user = User::find(Auth::user()->id);
        $title = strtoupper($user->name);
        $data = [
            'title' => $title,
            'posts' => $user->posts
        ];
        return view('account')->with($data);
    }

    public function profile(Request $request){
        if($request->ajax()){
            $output = $address = $mobile_phone = '';
            if($request->action){
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
                return response()->json([
                    'user_data' => $output
                ]);
            }
        }
    }
}
