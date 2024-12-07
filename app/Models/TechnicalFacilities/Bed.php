<?php

namespace App\Models\TechnicalFacilities;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class Bed extends Model
{
    use ModelRelations;

    protected $table = 'beds';
    protected $fillable = [
        'model', 'material', 'capacity', 'brand', 'status', 'adder', 'editor'
    ];
}
