<?php

namespace App\Models\DigitalEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Webcam extends Model
{
    use ModelRelations;

    protected $table = 'webcams';
    protected $fillable = [
        'model', 'brand', 'status', 'adder', 'editor'
    ];
}
