<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChangeHistory extends Model
{
    protected $fillable = ['equipment_id', 'new', 'edit', 'delete', 'user', 'updated_at'];

    public function userInfo()
    {
        return $this->belongsTo(User::class, 'user', 'id');
    }

    public function equipmentInfo()
    {
        return $this->belongsTo(Equipment::class, 'equipment_id', 'id');
    }
}
