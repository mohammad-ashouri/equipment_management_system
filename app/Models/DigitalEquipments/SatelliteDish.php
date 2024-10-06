<?php

namespace App\Models\DigitalEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SatelliteDish extends Model
{
    use ModelRelations;

    protected $table = 'satellite_dishes';
    protected $fillable = [
        'model', 'brand', 'status', 'adder', 'editor'
    ];
}
