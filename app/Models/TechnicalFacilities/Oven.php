<?php

namespace App\Models\TechnicalFacilities;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class Oven extends Model
{
    use ModelRelations;

    protected $table = 'ovens';
    protected $fillable = [
        'model', 'type', 'flames_number', 'brand', 'status', 'adder', 'editor'
    ];
}
