<?php

namespace App\Models\HardwareEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class Cases extends Model
{
    use ModelRelations;

    protected $table = 'cases';
    protected $fillable = [
        'model', 'brand', 'status', 'adder', 'editor'
    ];
}
