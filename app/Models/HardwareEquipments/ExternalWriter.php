<?php

namespace App\Models\HardwareEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class ExternalWriter extends Model
{
    use ModelRelations;
    protected $table = 'external_writers';
    protected $fillable = [
        'model', 'connectivity_type', 'brand', 'status', 'adder', 'editor'
    ];
}
