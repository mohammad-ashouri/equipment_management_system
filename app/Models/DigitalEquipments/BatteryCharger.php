<?php

namespace App\Models\DigitalEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatteryCharger extends Model
{
    use ModelRelations;

    protected $table = 'battery_chargers';
    protected $fillable = [
        'model', 'brand', 'status', 'adder', 'editor'
    ];
}
