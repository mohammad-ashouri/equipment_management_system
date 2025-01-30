<?php

namespace App\Models\TechnicalFacilities;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class Bracket extends Model
{
    use ModelRelations;

    protected $table = 'brackets';
    protected $fillable = [
        'model', 'suitable_for', 'brand', 'status', 'adder', 'editor'
    ];
}
