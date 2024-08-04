<?php

namespace App\Models\DigitalEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CameraHolder extends Model
{
    use ModelRelations;

    protected $table = 'camera_holders';
    protected $fillable = [
        'model', 'type', 'parts_number', 'head_type', 'brand', 'status', 'adder', 'editor'
    ];
}
