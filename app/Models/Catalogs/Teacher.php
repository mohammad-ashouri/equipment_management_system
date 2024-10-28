<?php

namespace App\Models\Catalogs;

use App\Models\Picture;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    public $table = 'teachers';
    protected $fillable = [
        'adjective', 'name', 'post', 'status', 'adder', 'editor'
    ];

    public function adjectiveInfo()
    {
        return $this->belongsTo(PersonAdjective::class, 'adjective', 'id');
    }

    public function mainImage()
    {
        return $this->belongsTo(Picture::class, 'id', 'post_id')->where('post_type', 'teacher_picture')->where('image_type', 'picture_main');
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
