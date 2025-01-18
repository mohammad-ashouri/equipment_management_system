<?php

namespace App\Models\TechnicalFacilities;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class Safe extends Model
{
    use ModelRelations;

    protected $table = 'safes';
    protected $fillable = [
        'model', 'type', 'floors_number', 'brand', 'status', 'adder', 'editor'
    ];
}
