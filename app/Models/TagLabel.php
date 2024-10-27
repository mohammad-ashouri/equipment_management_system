<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TagLabel extends Model
{
    use  SoftDeletes;

    public $table = 'tag_labels';
    protected $fillable = [
        'name',
        'adder',
    ];
}
