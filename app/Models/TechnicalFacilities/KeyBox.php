<?php

namespace App\Models\TechnicalFacilities;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class KeyBox extends Model
{
    use ModelRelations;

    protected $table = 'key_boxes';
    protected $fillable = [
        'model', 'color', 'material', 'door_number', 'key_number', 'brand', 'status', 'adder', 'editor'
    ];
}
