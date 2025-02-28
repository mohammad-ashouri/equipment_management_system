<?php

namespace App\Models\DigitalEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class LightHolder extends Model
{
    use ModelRelations;

    protected $table = 'light_holders';
    protected $fillable = [
        'model', 'brand', 'status', 'adder', 'editor'
    ];
}
