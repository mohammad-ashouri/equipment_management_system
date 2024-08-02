<?php

namespace App\Models\HardwareEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Printer extends Model
{
    use ModelRelations;

    protected $table = 'printers';
    protected $fillable = [
        'model', 'function_type', 'brand', 'status', 'adder', 'editor'
    ];
}
