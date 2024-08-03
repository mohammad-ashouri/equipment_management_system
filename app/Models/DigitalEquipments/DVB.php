<?php

namespace App\Models\DigitalEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DVB extends Model
{
    use ModelRelations;

    protected $table = 'dvbs';
    protected $fillable = [
        'model', 'tuner_numbers', 'brand', 'status', 'adder', 'editor'
    ];
}
