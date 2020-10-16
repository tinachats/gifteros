<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // A category can have many gifts which belong to it

    protected $table = 'categories';

    // public function gifts(){
    //     return $this->hasMany('App\Models\Gift');
    // }
}
