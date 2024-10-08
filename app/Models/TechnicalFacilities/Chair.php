<?php

namespace App\Models\TechnicalFacilities;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chair extends Model
{
    use ModelRelations;

    protected $table = 'chairs';
    protected $fillable = [
        'model', 'material', 'desktop_type', 'brand', 'status', 'adder', 'editor'
    ];
}
