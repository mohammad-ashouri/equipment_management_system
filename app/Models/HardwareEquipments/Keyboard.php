<?php

namespace App\Models\HardwareEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keyboard extends Model
{
    use ModelRelations;

    protected $table = 'keyboards';
    protected $fillable = [
        'model', 'connectivity_type', 'brand', 'status', 'adder', 'editor'
    ];
}
