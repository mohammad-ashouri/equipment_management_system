<?php

namespace App\Models\NetworkEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kvm extends Model
{
    use ModelRelations;

    protected $table = 'kvms';
    protected $fillable = [
        'ports_number', 'type', 'model', 'brand', 'status', 'adder', 'editor'
    ];
}
