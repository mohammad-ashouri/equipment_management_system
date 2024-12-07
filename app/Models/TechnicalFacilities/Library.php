<?php

namespace App\Models\TechnicalFacilities;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class Library extends Model
{
    use ModelRelations;

    protected $table = 'libraries';
    protected $fillable = [
        'model', 'material', 'floors_number', 'doors_number', 'closets_number', 'brand', 'status', 'adder', 'editor'
    ];
}
