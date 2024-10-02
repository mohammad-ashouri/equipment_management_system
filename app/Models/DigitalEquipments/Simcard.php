<?php

namespace App\Models\DigitalEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class Simcard extends Model
{
    use ModelRelations;

    protected $table = 'simcards';
    protected $fillable = [
        'type_use', 'number', 'puk', 'pin', 'serial', 'brand', 'status', 'adder', 'editor'
    ];
}
