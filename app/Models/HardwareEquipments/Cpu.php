<?php

namespace App\Models\HardwareEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cpu extends Model
{
    use ModelRelations;

    protected $table = 'cpus';
    protected $fillable = [
        'model', 'generation', 'brand', 'status', 'adder', 'editor'
    ];
}
