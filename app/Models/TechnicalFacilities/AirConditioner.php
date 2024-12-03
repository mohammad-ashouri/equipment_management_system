<?php

namespace App\Models\TechnicalFacilities;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AirConditioner extends Model
{
    use ModelRelations;

    protected $table = 'air_conditioners';
    protected $fillable = [
        'model', 'capacity', 'brand', 'status', 'adder', 'editor'
    ];
}
