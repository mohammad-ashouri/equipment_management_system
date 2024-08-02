<?php

namespace App\Models\HardwareEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mouse extends Model
{
    use ModelRelations;

    protected $table = 'mouses';
    protected $fillable = [
        'model', 'connectivity_type', 'brand', 'status', 'adder', 'editor'
    ];
}
