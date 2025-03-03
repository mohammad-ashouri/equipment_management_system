<?php

namespace App\Models\NetworkEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    use ModelRelations;

    protected $table = 'servers';
    protected $fillable = [
        'ram', 'cpu', 'hdd', 'ssd', 'm2', 'model', 'brand', 'status', 'adder', 'editor'
    ];
}
