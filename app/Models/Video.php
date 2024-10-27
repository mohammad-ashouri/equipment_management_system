<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use  SoftDeletes;

    public $table = 'videos';
    protected $fillable = [
        'post_id', 'post_type', 'video_type', 'src', 'adder'
    ];
}
