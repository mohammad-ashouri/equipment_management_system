<?php

namespace App\Models\HardwareEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GraphicCard extends Model
{
    use ModelRelations;

    protected $table = 'graphic_cards';
    protected $fillable = [
        'model', 'ram_size', 'brand', 'status', 'adder', 'editor'
    ];
}
