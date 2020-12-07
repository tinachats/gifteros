<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Developers extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  string  $name
     */
    public function index($name){
        $data = [
            'title'  => 'Tinashe Chaterera'
        ];
        return view('developer.index')->with($data);
    }
}
