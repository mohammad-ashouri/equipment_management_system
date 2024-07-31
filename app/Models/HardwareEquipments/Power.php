<?php

namespace App\Models\HardwareEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Power extends Model
{
    use ModelRelations;

    protected $table = 'powers';
    protected $fillable = [
        'model', 'voltage', 'brand', 'status', 'adder', 'editor'
    ];
}
