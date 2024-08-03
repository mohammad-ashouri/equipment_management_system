<?php

namespace App\Models\NetworkEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rack extends Model
{
    use ModelRelations;

    protected $table = 'racks';
    protected $fillable = [
        'type', 'units_number', 'model', 'brand', 'status', 'adder', 'editor'
    ];
}
