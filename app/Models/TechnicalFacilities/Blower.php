<?php

namespace App\Models\TechnicalFacilities;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blower extends Model
{
    use ModelRelations;

    protected $table = 'blowers';
    protected $fillable = [
        'model', 'power_type', 'brand', 'status', 'adder', 'editor'
    ];
}
