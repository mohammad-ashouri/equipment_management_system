<?php

namespace App\Models\TechnicalFacilities;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class Television extends Model
{
    use ModelRelations;

    protected $table = 'televisions';
    protected $fillable = [
        'model', 'size', 'brand', 'status', 'adder', 'editor'
    ];
}
