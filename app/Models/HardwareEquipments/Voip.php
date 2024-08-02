<?php

namespace App\Models\HardwareEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voip extends Model
{
    use ModelRelations;

    protected $table = 'voips';
    protected $fillable = [
        'model', 'brand', 'status', 'adder', 'editor'
    ];
}
