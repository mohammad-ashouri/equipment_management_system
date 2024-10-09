<?php

namespace App\Models\NetworkEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessPoint extends Model
{
    use ModelRelations;

    protected $table = 'access_points';
    protected $fillable = [
        'antennas_number', 'model', 'brand', 'status', 'adder', 'editor'
    ];
}
