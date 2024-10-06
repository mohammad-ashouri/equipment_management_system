<?php

namespace App\Models\DigitalEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoundCard extends Model
{
    use ModelRelations;

    protected $table = 'sound_cards';
    protected $fillable = [
        'model', 'brand', 'connectivity_type', 'status', 'adder', 'editor'
    ];
}
