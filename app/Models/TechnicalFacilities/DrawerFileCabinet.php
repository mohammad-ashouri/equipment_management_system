<?php

namespace App\Models\TechnicalFacilities;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrawerFileCabinet extends Model
{
    use ModelRelations;

    protected $table = 'drawer_file_cabinets';
    protected $fillable = [
        'model', 'material', 'drawer_number', 'lock', 'brand', 'status', 'adder', 'editor'
    ];
}
