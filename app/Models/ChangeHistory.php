<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChangeHistory extends Model
{
    protected $fillable = ['equipment_id', 'changes', 'user', 'updated_at'];

    public function userInfo()
    {
        return $this->belongsTo(User::class, 'user', 'id');
    }
}
