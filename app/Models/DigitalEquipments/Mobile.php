<?php

namespace App\Models\DigitalEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mobile extends Model
{
    use ModelRelations;

    protected $table = 'mobiles';
    protected $fillable = [
        'model', 'internal_memory','ram','simcard_number', 'brand', 'status', 'adder', 'editor'
    ];
}
