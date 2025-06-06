<?php

namespace App\Models\DigitalEquipments;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceSystem extends Model
{
    use ModelRelations;

    protected $table = 'attendance_systems';
    protected $fillable = [
        'model', 'brand', 'status', 'adder', 'editor'
    ];
}
