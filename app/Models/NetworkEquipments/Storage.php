<?php

namespace App\Models\NetworkEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    use ModelRelations;

    protected $table = 'storages';
    protected $fillable = [
        'ram', 'cpu', 'hdd', 'ssd', 'm2', 'model', 'brand', 'status', 'adder', 'editor'
    ];
}
