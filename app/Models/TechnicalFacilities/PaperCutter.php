<?php

namespace App\Models\TechnicalFacilities;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class PaperCutter extends Model
{
    use ModelRelations;

    protected $table = 'paper_cutters';
    protected $fillable = [
        'model', 'type', 'brand', 'status', 'adder', 'editor'
    ];
}
