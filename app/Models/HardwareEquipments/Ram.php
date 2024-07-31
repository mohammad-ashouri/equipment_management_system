<?php

namespace App\Models\HardwareEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ram extends Model
{
    use ModelRelations;

    protected $table = 'rams';
    protected $fillable = [
        'model', 'type', 'brand', 'size', 'frequency', 'status', 'adder', 'editor'
    ];
}
