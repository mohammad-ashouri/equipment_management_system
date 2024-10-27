<?php

namespace App\Models\Catalogs;

use App\Models\Picture;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class SocialMediaPlatform extends Model
{
    public $table = 'social_media_platforms';
    protected $fillable = [
        'name',
        'icon_src',
        'adder',
        'editor',
    ];

    public function mainImage()
    {
        return $this->belongsTo(Picture::class, 'id', 'post_id')->where('post_type', 'social_media_platform_picture')->where('image_type', 'picture_main');
    }

    public function adderInfo()
    {
        return $this->belongsTo(User::class, 'adder', 'id');
    }

    public function editorInfo()
    {
        return $this->belongsTo(User::class, 'editor', 'id');
    }
}
