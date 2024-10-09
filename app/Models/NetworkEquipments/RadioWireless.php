<?php

namespace App\Models\NetworkEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class RadioWireless extends Model
{
    use ModelRelations;

    protected $table = 'radio_wirelesses';
    protected $fillable = [
        'model', 'brand', 'status', 'adder', 'editor'
    ];
}
