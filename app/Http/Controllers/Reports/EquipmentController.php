<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use App\Models\EquipmentType;

class EquipmentController extends Controller
{
    public function allEquipments()
    {
        $equipmentTypes = EquipmentType::whereJsonContains('accessible_roles', $this->getMyRoleId())->orderBy('persian_name')->pluck('id')->toArray();
        $allEquipments = Equipment::whereIn('equipment_type', $equipmentTypes)->get();
        return view('Reports.AllEquipments', compact('allEquipments'));
    }
}
