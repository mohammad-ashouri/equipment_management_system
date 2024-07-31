<?php

namespace App\Models\HardwareEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motherboard extends Model
{
    use ModelRelations;

    protected $table = 'motherboards';
    protected $fillable = [
        'brand',
        'model',
        'generation',
        'ram_slot_type',
        'cpu_slot_type',
        'cpu_slots_number',
        'ram_slots_number',
        'status',
        'adder',
        'editor',
    ];
}
