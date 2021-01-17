<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Sales extends Controller
{
    // Close the sale when countdown is off
    public function closeSale(Request $request)
    {
        if($request->ajax()){
            if($request->action == 'sale-closed'){
                DB::table('gifts')->update(['sale_percentage' => 0]);
            }
        }
    }
}
