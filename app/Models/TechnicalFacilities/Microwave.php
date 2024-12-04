<?php

namespace App\Models\TechnicalFacilities;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Microwave extends Model
{
    use ModelRelations;

    protected $table = 'microwaves';
    protected $fillable = [
        'model', 'brand', 'status', 'adder', 'editor'
    ];
}
