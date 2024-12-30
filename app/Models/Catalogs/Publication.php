<?php

namespace App\Models\Catalogs;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    use ModelRelations;

    protected $table = 'publications';
    protected $fillable = [
        'name', 'status', 'address', 'adder', 'editor'
    ];
}
