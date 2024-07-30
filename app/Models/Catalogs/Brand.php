<?php

namespace App\Models\Catalogs;

use App\Models\User;
use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use ModelRelations;

    protected $table = 'brands';
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    protected $fillable = ['name', 'status', 'adder', 'editor'];
}
