<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChangeHistory extends Model
{
    protected $fillable = ['equipment_id', 'changes', 'updated_at'];
}
