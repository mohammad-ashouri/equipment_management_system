<?php

namespace App\Models\NetworkEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class PunchWrench extends Model
{
    use ModelRelations;

    protected $table = 'punch_wrenches';
    protected $fillable = [
        'model', 'brand', 'status', 'adder', 'editor'
    ];
}
