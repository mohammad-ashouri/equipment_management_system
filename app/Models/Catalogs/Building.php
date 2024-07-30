<?php

namespace App\Models\Catalogs;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    use ModelRelations;

    protected $table = 'buildings';
    protected $fillable = [
        'name', 'status', 'address', 'adder', 'editor'
    ];
}
