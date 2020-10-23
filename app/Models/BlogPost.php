<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'blog';

    // Primary Key
    public $primaryKey = 'id';

    // Timestamps 
    public $timestamps = true;

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
