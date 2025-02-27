<?php

namespace App\Models\NetworkEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class Nvr extends Model
{
    use ModelRelations;

    protected $table = 'nvrs';
    protected $fillable = [
        'brand', 'model', 'channels_number', 'status', 'adder', 'editor'
    ];
}
