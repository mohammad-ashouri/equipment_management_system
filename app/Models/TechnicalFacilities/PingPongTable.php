<?php

namespace App\Models\TechnicalFacilities;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PingPongTable extends Model
{
    use ModelRelations;

    protected $table = 'ping_pong_tables';
    protected $fillable = [
        'model', 'material', 'type', 'brand', 'status', 'adder', 'editor'
    ];
}
