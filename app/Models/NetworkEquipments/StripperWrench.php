<?php

namespace App\Models\NetworkEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StripperWrench extends Model
{
    use ModelRelations;

    protected $table = 'stripper_wrenches';
    protected $fillable = [
        'model', 'brand', 'status', 'adder', 'editor'
    ];
}
