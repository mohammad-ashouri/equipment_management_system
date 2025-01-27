<?php

namespace App\Models\HardwareEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class Monitor extends Model
{
    use ModelRelations;

    protected $table = 'monitors';
    protected $fillable = [
        'model', 'size', 'brand', 'status', 'adder', 'editor'
    ];
}
