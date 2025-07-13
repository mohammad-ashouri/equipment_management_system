<?php

namespace App\Models\GymEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class Crossover extends Model
{
    use ModelRelations;

    protected $table = 'crossovers';
    protected $fillable = [
        'model', 'type', 'brand', 'status', 'adder', 'editor'
    ];
}
