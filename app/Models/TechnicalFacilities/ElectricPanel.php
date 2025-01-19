<?php

namespace App\Models\TechnicalFacilities;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class ElectricPanel extends Model
{
    use ModelRelations;

    protected $table = 'electric_panels';
    protected $fillable = [
        'model', 'type', 'material', 'mode', 'brand', 'status', 'adder', 'editor'
    ];
}
