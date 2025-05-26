<?php

namespace App\Models\DigitalEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class DigitalPen extends Model
{
    use ModelRelations;

    protected $table = 'digital_pens';
    protected $fillable = [
        'model', 'connectivity_type', 'brand', 'status', 'adder', 'editor'
    ];
}
