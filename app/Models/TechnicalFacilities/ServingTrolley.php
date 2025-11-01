<?php

namespace App\Models\TechnicalFacilities;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class ServingTrolley extends Model
{
    use ModelRelations;

    protected $table = 'serving_trolleys';
    protected $fillable = [
        'model', 'material', 'floors_number', 'color', 'brand', 'status', 'adder', 'editor'
    ];
}
