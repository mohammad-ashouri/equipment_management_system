<?php

namespace App\Models\TechnicalFacilities;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class WhiteboardHolder extends Model
{
    use ModelRelations;

    protected $table = 'whiteboard_holders';
    protected $fillable = [
        'model', 'material', 'brand', 'status', 'adder', 'editor'
    ];
}
