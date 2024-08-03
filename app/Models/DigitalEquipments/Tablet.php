<?php

namespace App\Models\DigitalEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tablet extends Model
{
    use ModelRelations;

    protected $table = 'tablets';
    protected $fillable = [
        'model', 'internal_memory','ram','simcard_number', 'brand', 'status', 'adder', 'editor'
    ];
}
