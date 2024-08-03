<?php

namespace App\Models\DigitalEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalHardDisk extends Model
{
    use ModelRelations;

    protected $table = 'external_hard_disks';
    protected $fillable = [
        'model', 'capacity', 'brand', 'status', 'adder', 'editor'
    ];
}
