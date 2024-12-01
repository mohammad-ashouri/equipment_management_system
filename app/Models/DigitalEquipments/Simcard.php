<?php

namespace App\Models\DigitalEquipments;

use App\Models\Equipment;
use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class Simcard extends Model
{
    use ModelRelations;

    protected $table = 'simcards';
    protected $fillable = [
        'type_use', 'number', 'puk', 'pin', 'serial', 'brand', 'status', 'adder', 'editor'
    ];
    public static function getAvailableSimcards($equipment)
    {
        $allSimcards = Equipment::whereEquipmentType(21)->pluck('info')->toArray();
        $simcards = [];
        foreach ($allSimcards as $simcard) {
            $decoded = json_decode($simcard, true);
            if ($decoded['simcard'] == json_decode($equipment->info, true)['simcard']) {
                continue;
            }
            $simcards[] = $decoded['simcard'];
        }
        return self::whereNotIn('id', $simcards)->get();
    }
}
