<?php

namespace App\Models\TechnicalFacilities;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class Samovar extends Model
{
    use ModelRelations;

    protected $table = 'tea_makers';
    protected $fillable = [
        'model', 'type', 'liter_capacity', 'brand', 'status', 'adder', 'editor'
    ];
}
