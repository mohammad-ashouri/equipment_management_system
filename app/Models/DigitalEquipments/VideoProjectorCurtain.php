<?php

namespace App\Models\DigitalEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoProjectorCurtain extends Model
{
    use ModelRelations;

    protected $table = 'video_projector_curtains';
    protected $fillable = [
        'model', 'height', 'width', 'brand', 'status', 'adder', 'editor'
    ];
}
