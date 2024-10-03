<?php

namespace App\Models\NetworkEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class Lantv extends Model
{
    use ModelRelations;

    protected $table = 'lantvs';
    protected $fillable = [
        'input_ports_number', 'output_ports_number', 'model', 'brand', 'status', 'adder', 'editor'
    ];
}
