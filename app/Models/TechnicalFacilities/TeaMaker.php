<?php

namespace App\Models\TechnicalFacilities;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class TeaMaker extends Model
{
    use ModelRelations;

    protected $table = 'tea_makers';
    protected $fillable = [
        'model', 'brand', 'status', 'adder', 'editor'
    ];
}
