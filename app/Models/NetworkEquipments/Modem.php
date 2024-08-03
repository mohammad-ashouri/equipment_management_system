<?php

namespace App\Models\NetworkEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modem extends Model
{
    use ModelRelations;

    protected $table = 'modems';
    protected $fillable = [
        'ports_number', 'type', 'connectivity_type', 'antennas_number', 'model', 'brand', 'status', 'adder', 'editor'
    ];
}
