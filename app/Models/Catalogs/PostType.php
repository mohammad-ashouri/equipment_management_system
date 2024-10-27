<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Model;

class PostType extends Model
{
    public $table = 'post_types';
    protected $fillable = [
        'title', 'status', 'adder', 'editor'
    ];
}
