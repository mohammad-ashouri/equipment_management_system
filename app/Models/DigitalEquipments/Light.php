<?php

namespace App\Models\DigitalEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class Light extends Model
{
    use ModelRelations;

    protected $table = 'lights';
    protected $fillable = [
        'model', 'brand', 'status', 'adder', 'editor'
    ];
}
