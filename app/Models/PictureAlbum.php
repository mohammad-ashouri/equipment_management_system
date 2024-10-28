<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PictureAlbum extends Model
{
    use  SoftDeletes;

    public $table = 'picture_albums';
    protected $fillable = [
        'title',
        'date',
        'status',
        'adder',
        'editor',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function pictureSrc()
    {
        return $this->belongsTo(Picture::class, 'id', 'post_id')->where('post_type', 'picture_album')->where('image_type', 'picture_main');
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
