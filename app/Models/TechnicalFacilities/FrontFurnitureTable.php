<?php

namespace App\Models\TechnicalFacilities;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class FrontFurnitureTable extends Model
{
    use ModelRelations;

    protected $table = 'front_furniture_tables';
    protected $fillable = [
        'model', 'material', 'width', 'length', 'height', 'brand', 'status', 'adder', 'editor'
    ];
}
