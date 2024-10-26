<?php

namespace App\Models\DigitalEquipments;

use App\Models\HardwareEquipments\Cpu;
use App\Models\HardwareEquipments\GraphicCard;
use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class Laptop extends Model
{
    use ModelRelations;

    protected $table = 'laptops';
    protected $fillable = [
        'monitor_size', 'cpu', 'graphic_card', 'monitor_size', 'odd', 'model', 'brand', 'status', 'adder', 'editor'
    ];

    public function cpuInfo()
    {
        return $this->belongsTo(Cpu::class, 'cpu', 'id');
    }

    public function graphicCardInfo()
    {
        return $this->belongsTo(GraphicCard::class, 'graphic_card', 'id');
    }
}
