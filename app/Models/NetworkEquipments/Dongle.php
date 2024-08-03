<?php

namespace App\Models\NetworkEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dongle extends Model
{
    use ModelRelations;

    protected $table = 'dongles';
    protected $fillable = [
        'type', 'model', 'brand', 'status', 'adder', 'editor'
    ];
}
