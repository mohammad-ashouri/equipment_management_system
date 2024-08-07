<?php

namespace App\Models;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use ModelRelations;

    protected $table = 'equipments';
    protected $fillable = [
        'personnel', 'equipment_type', 'property_code', 'delivery_date', 'info', 'description', 'status', 'adder', 'editor'
    ];
}
