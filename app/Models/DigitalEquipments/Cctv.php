<?php

namespace App\Models\DigitalEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cctv extends Model
{
    use ModelRelations;

    protected $table = 'cctvs';
    protected $fillable = [
        'model', 'type', 'connectivity_type', 'brand', 'status', 'adder', 'editor'
    ];
}
