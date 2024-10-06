<?php

namespace App\Models\DigitalEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SatelliteFinder extends Model
{
    use ModelRelations;

    protected $table = 'satellite_finders';
    protected $fillable = [
        'model', 'brand', 'type', 'status', 'adder', 'editor'
    ];
}
