<?php

namespace App\Models\NetworkEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class NetworkCard extends Model
{
    use ModelRelations;

    protected $table = 'network_cards';
    protected $fillable = [
        'model', 'function_type', 'connectivity_type', 'brand', 'status', 'adder', 'editor'
    ];
}
