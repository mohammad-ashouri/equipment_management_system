<?php

namespace App\Models\TechnicalFacilities;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VaccumCleaner extends Model
{
    use ModelRelations;

    protected $table = 'vaccum_cleaners';
    protected $fillable = [
        'model', 'type', 'brand', 'status', 'adder', 'editor'
    ];
}
