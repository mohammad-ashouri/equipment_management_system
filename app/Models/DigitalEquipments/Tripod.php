<?php

namespace App\Models\DigitalEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tripod extends Model
{
    use ModelRelations;

    protected $table = 'tripods';
    protected $fillable = [
        'model', 'color', 'brand', 'status', 'adder', 'editor'
    ];
}
