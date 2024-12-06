<?php

namespace App\Models\TechnicalFacilities;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class WaterPurifier extends Model
{
    use ModelRelations;

    protected $table = 'water_purifiers';
    protected $fillable = [
        'model', 'type', 'brand', 'status', 'adder', 'editor'
    ];
}
