<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gift extends Model
{
    use HasFactory;

    protected $table = 'gifts';

    // Fetch a gift category
    // public function category(){
    //     return $this->belongsTo('App\Models\Category');
    // }

    // Fetch a gift sub_category
    // public function sub_category(){
    //     return $this->belongsTo('App\Models\SubCategory');
    // }
}
