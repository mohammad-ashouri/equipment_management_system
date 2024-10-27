<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Picture extends Model
{
    use  SoftDeletes;

    public $table = 'pictures';
    protected $fillable = [
        'post_id', 'post_type', 'image_type', 'src', 'description', 'adder'
    ];
}
