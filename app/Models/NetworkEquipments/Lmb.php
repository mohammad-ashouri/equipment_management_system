<?php

namespace App\Models\NetworkEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class Lmb extends Model
{
    use ModelRelations;

    protected $table = 'lmbs';
    protected $fillable = [
        'model', 'brand', 'status', 'adder', 'editor'
    ];
}
