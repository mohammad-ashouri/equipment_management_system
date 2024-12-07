<?php

namespace App\Models\TechnicalFacilities;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class SuggestionBox extends Model
{
    use ModelRelations;

    protected $table = 'suggestion_boxes';
    protected $fillable = [
        'model', 'material', 'brand', 'status', 'adder', 'editor'
    ];
}
