<?php

namespace App\Models\TechnicalFacilities;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class CoatHanger extends Model
{
    use ModelRelations;

    protected $table = 'coat_hangers';
    protected $fillable = [
        'model', 'pendants_number', 'brand', 'status', 'adder', 'editor'
    ];
}
