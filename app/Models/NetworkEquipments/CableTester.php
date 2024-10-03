<?php

namespace App\Models\NetworkEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CableTester extends Model
{
    use ModelRelations;

    protected $table = 'cable_testers';
    protected $fillable = [
        'type', 'model', 'brand', 'status', 'adder', 'editor'
    ];
}
