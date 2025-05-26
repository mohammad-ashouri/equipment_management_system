<?php

namespace App\Models\TechnicalFacilities;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class IranianCooler extends Model
{
    use ModelRelations;

    protected $table = 'iranian_coolers';
    protected $fillable = [
        'model', 'capacity', 'type', 'brand', 'status', 'adder', 'editor'
    ];
}
