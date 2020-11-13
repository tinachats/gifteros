<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UI extends Controller
{
    public function category_ui()
    {
        return view('ui-designs.category-ui')->with('title', 'Category Mobile UI');
    }
}
