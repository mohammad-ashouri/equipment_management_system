<?php

namespace App\Models\TechnicalFacilities;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FireExtinguisher extends Model
{
    use ModelRelations;

    protected $table = 'fire_extinguishers';
    protected $fillable = [
        'model', 'weight', 'brand', 'status', 'adder', 'editor'
    ];
}
