<?php

namespace App\Models\DigitalEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class BatteryCabinet extends Model
{
    use ModelRelations;

    protected $table = 'battery_cabinets';
    protected $fillable = [
        'model', 'brand', 'status', 'adder', 'editor'
    ];
}
