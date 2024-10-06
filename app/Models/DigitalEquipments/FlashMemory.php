<?php

namespace App\Models\DigitalEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlashMemory extends Model
{
    use ModelRelations;

    protected $table = 'flash_memories';
    protected $fillable = [
        'model', 'capacity', 'brand', 'status', 'adder', 'editor'
    ];
}
