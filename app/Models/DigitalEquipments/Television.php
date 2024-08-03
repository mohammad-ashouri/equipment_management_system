<?php

namespace App\Models\DigitalEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Television extends Model
{
    use ModelRelations;

    protected $table = 'televisions';
    protected $fillable = [
        'model', 'size', 'brand', 'status', 'adder', 'editor'
    ];
}
