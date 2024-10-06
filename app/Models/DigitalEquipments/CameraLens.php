<?php

namespace App\Models\DigitalEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CameraLens extends Model
{
    use ModelRelations;

    protected $table = 'camera_lenses';
    protected $fillable = [
        'model', 'brand', 'status', 'adder', 'editor'
    ];
}
