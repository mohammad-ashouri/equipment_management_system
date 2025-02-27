<?php

namespace App\Models\DigitalEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class SatelliteSwitch extends Model
{
    use ModelRelations;

    protected $table = 'satellite_switches';
    protected $fillable = [
        'model', 'brand', 'status', 'adder', 'editor'
    ];
}
