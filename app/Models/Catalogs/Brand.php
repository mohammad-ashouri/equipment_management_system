<?php

namespace App\Models\Catalogs;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'brands';
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    protected $fillable = ['name', 'status', 'adder', 'editor'];
    public function adderInfo()
    {
        return $this->belongsTo(User::class, 'adder', 'id');
    }

    public function editorInfo()
    {
        return $this->belongsTo(User::class, 'editor', 'id');
    }
}
