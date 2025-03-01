<?php

namespace App\Models;

use App\Models\Catalogs\Building;
use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Personnel extends Model
{
    use SoftDeletes, ModelRelations, HasFactory;

    protected $table = 'personnels';
    protected $fillable = [
        'id', 'personnel_code', 'first_name', 'last_name', 'building', 'room_number', 'adder', 'editor'
    ];

    public function buildingInfo()
    {
        return $this->belongsTo(Building::class, 'building', 'id');
    }

    public function equipments(): HasMany
    {
        return $this->hasMany(Equipment::class, 'personnel', 'id')->orderBy('equipment_type');
    }
}
