<?php

namespace App\Models\DigitalEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ups extends Model
{
    use ModelRelations;

    protected $table = 'ups';
    protected $fillable = [
        'model', 'capacity', 'brand', 'status', 'adder', 'editor'
    ];
}
