<?php

namespace App\Models\TechnicalFacilities;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class Refrigerator extends Model
{
    use ModelRelations;

    protected $table = 'refrigerators';
    protected $fillable = [
        'model', 'type', 'brand', 'status', 'adder', 'editor'
    ];
}
