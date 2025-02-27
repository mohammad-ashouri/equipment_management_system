<?php

namespace App\Models\DigitalEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class Pbx extends Model
{
    use ModelRelations;

    protected $table = 'pbxes';
    protected $fillable = [
        'model', 'brand', 'status', 'adder', 'editor'
    ];
}
