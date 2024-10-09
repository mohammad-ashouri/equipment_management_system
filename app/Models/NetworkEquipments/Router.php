<?php

namespace App\Models\NetworkEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Router extends Model
{
    use ModelRelations;

    protected $table = 'routers';
    protected $fillable = [
        'ports_number', 'antennas_number', 'model', 'brand', 'status', 'adder', 'editor'
    ];
}
