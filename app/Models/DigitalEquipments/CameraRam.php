<?php

namespace App\Models\DigitalEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class CameraRam extends Model
{
    use ModelRelations;

    protected $table = 'camera_rams';
    protected $fillable = [
        'model', 'brand', 'type', 'capacity', 'status', 'adder', 'editor'
    ];
}
