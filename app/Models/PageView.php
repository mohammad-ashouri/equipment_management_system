<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageView extends Model
{
    protected $table = 'page_views';
    protected $fillable = [
        'model_type',
        'model_slug',
        'created_at'
    ];
}
