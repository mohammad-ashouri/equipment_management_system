<?php

namespace App\Models\TechnicalFacilities;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class Flashlight extends Model
{
    use ModelRelations;

    protected $table = 'flashlights';
    protected $fillable = [
        'model', 'type', 'battery_type', 'brand', 'status', 'adder', 'editor'
    ];
}
