<?php

namespace App\Models\TechnicalFacilities;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class FlowerPot extends Model
{
    use ModelRelations;

    protected $table = 'flower_pots';
    protected $fillable = [
        'model', 'material', 'brand', 'status', 'adder', 'editor'
    ];
}
