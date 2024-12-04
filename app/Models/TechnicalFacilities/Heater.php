<?php

namespace App\Models\TechnicalFacilities;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Heater extends Model
{
    use ModelRelations;

    protected $table = 'heaters';
    protected $fillable = [
        'model', 'fan', 'brand', 'status', 'adder', 'editor'
    ];
}
