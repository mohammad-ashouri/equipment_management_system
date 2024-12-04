<?php

namespace App\Models\TechnicalFacilities;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use ModelRelations;

    protected $table = 'tables';
    protected $fillable = [
        'model', 'material', 'type', 'height', 'width', 'length', 'brand', 'status', 'adder', 'editor'
    ];
}
