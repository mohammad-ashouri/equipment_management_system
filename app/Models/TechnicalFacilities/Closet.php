<?php

namespace App\Models\TechnicalFacilities;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class Closet extends Model
{
    use ModelRelations;

    protected $table = 'closets';
    protected $fillable = [
        'model', 'material', 'floors_number', 'doors_number', 'brand', 'status', 'adder', 'editor'
    ];
}
