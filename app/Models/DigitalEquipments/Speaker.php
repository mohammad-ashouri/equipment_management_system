<?php

namespace App\Models\DigitalEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Speaker extends Model
{
    use ModelRelations;

    protected $table = 'speakers';
    protected $fillable = [
        'parts_number', 'model', 'brand', 'status', 'adder', 'editor'
    ];
}
