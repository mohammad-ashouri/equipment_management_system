<?php

namespace App\Models\NetworkEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocketWrench extends Model
{
    use ModelRelations;

    protected $table = 'socket_wrenches';
    protected $fillable = [
        'model', 'brand', 'status', 'adder', 'editor'
    ];
}
