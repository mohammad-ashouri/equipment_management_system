<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use App\Models\EquipmentType;
use App\Models\Personnel;

class EquipmentController extends Controller
{
    public function allEquipments()
    {
        $equipmentTypes = EquipmentType::whereJsonContains('accessible_roles', $this->getMyRoleId())
            ->orderBy('persian_name')
            ->whereNotIn('id',[1, 2, 3, 4, 5, 6, 7, 15])
            ->pluck('id')
            ->toArray();
        $allEquipments = Equipment::whereIn('equipment_type', $equipmentTypes)->get();
        return view('Reports.AllEquipments', compact('allEquipments'));
    }

    public function hardware()
    {
        $persons = Personnel::whereHas('equipments', function ($query) {
            $query->whereIn('equipment_type', [1, 2, 3, 4, 5, 6, 7, 15]);
        })
            ->with(['equipments' => function ($query) {
            $query->whereIn('equipment_type', [
                1, 2, 3, 4, 5, 6, 7, 15
            ]);
        }])
           ->get();
        return view('Reports.Hardware', compact('persons'));
    }
}
