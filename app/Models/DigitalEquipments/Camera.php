<?php

namespace App\Models\DigitalEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Camera extends Model
{
    use ModelRelations;

    protected $table = 'cameras';
    protected $fillable = [
        'model', 'type', 'brand', 'status', 'adder', 'editor'
    ];
}
