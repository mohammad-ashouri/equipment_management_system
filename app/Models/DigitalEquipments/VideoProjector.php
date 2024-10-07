<?php

namespace App\Models\DigitalEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoProjector extends Model
{
    use ModelRelations;

    protected $table = 'video_projectors';
    protected $fillable = [
        'model', 'brand', 'status', 'adder', 'editor'
    ];
}
