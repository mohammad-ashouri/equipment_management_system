<?php

namespace App\Models\TechnicalFacilities;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use ModelRelations;

    protected $table = 'books';
    protected $fillable = [
        'name', 'publication', 'writer', 'size', 'status', 'adder', 'editor'
    ];
}