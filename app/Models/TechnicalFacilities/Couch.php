<?php

namespace App\Models\TechnicalFacilities;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class Couch extends Model
{
    use ModelRelations;

    protected $table = 'couches';
    protected $fillable = [
        'model', 'color', 'brand', 'status', 'adder', 'editor'
    ];
}
