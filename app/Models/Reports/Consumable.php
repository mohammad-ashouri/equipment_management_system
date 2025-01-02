<?php

namespace App\Models\Reports;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Consumable extends Model
{
    use ModelRelations, SoftDeletes;

    protected $table = 'consumables';
    protected $fillable = [
        'name', 'quantity', 'adder', 'editor'
    ];
}
