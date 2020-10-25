<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class Users extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}