<?php

namespace App\Models\TechnicalFacilities;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class Whiteboard extends Model
{
    use ModelRelations;

    protected $table = 'whiteboards';
    protected $fillable = [
        'model', 'material', 'width', 'length', 'brand', 'status', 'adder', 'editor'
    ];
}
