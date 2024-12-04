<?php

namespace App\Models\TechnicalFacilities;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ladder extends Model
{
    use ModelRelations;

    protected $table = 'ladders';
    protected $fillable = [
        'model', 'material', 'stairs_number', 'brand', 'status', 'adder', 'editor'
    ];
}
