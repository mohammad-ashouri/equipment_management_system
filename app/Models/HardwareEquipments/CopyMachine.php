<?php

namespace App\Models\HardwareEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CopyMachine extends Model
{
    use ModelRelations;

    protected $table = 'copy_machines';
    protected $fillable = [
        'model', 'brand', 'status', 'adder', 'editor'
    ];
}
