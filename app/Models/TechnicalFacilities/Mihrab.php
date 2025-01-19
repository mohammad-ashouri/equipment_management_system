<?php

namespace App\Models\TechnicalFacilities;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class Mihrab extends Model
{
    use ModelRelations;

    protected $table = 'mihrabs';
    protected $fillable = [
        'model', 'material', 'width', 'height', 'brand', 'status', 'adder', 'editor'
    ];
}
