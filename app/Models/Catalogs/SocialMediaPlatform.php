<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Model;

class SocialMediaPlatform extends Model
{
    public $table = 'social_media_platforms';
    protected $fillable = [
        'title',
    ];
}
