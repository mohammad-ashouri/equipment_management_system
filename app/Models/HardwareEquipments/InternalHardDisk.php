<?php

namespace App\Models\HardwareEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternalHardDisk extends Model
{
    use ModelRelations;

    protected $table = 'internal_hard_disks';
    protected $fillable = [
        'model', 'capacity', 'connectivity_type', 'brand', 'status', 'adder', 'editor'
    ];
}
