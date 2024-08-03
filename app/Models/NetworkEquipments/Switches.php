<?php

namespace App\Models\NetworkEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Switches extends Model
{
    use ModelRelations;

    protected $table = 'switches';
    protected $fillable = [
        'ports_number', 'model', 'brand', 'status', 'adder', 'editor'
    ];
}
