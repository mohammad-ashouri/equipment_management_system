<?php

namespace App\Models\DigitalEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class SetTopBox extends Model
{
    use ModelRelations;

    protected $table = 'set_top_boxes';
    protected $fillable = [
        'model', 'brand', 'status', 'adder', 'editor'
    ];
}
