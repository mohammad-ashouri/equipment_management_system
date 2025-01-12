<?php

namespace App\Models\TechnicalFacilities;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class ShoeCabinet extends Model
{
    use ModelRelations;

    protected $table = 'shoe_cabinets';
    protected $fillable = [
        'model', 'color', 'doors_number', 'floors_number', 'brand', 'status', 'adder', 'editor'
    ];
}
