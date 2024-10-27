<?php

namespace App\Models\Catalogs;

use App\Models\BookIntroduction;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $table = 'categories';
    protected $fillable = [
        'name','status','adder','editor'
    ];
    public function childes()
    {
        return $this->hasMany(Category::class,'parent','id');
    }
    public function bookIntroductions()
    {
        return $this->belongsToMany(BookIntroduction::class);
    }
}
