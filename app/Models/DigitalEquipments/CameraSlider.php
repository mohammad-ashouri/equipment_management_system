<?php

namespace App\Models\DigitalEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class CameraSlider extends Model
{
    use ModelRelations;

    protected $table = 'camera_sliders';
    protected $fillable = [
        'model', 'brand', 'status', 'adder', 'editor'
    ];
}
