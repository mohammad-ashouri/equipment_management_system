<?php

namespace App\Models\TechnicalFacilities;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class WaterDispenser extends Model
{
    use ModelRelations;

    protected $table = 'water_dispensers';
    protected $fillable = [
        'model', 'refrigerator', 'tank', 'cold_water_tap', 'warm_water_tap', 'brand', 'status', 'adder', 'editor'
    ];
}
