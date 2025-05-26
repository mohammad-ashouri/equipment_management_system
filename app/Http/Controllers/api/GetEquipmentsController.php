<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Personnel;
use App\Models\User;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;

class GetEquipmentsController extends Controller
{
    public function getEquipments(string $personnel_id)
    {
        $user = Personnel::with('equipments')->where('personnel_code', $personnel_id)->firstOrFail();
        $equipments = [];
        foreach ($user->equipments as $equipment) {
            $equipments[] = [
                'property_code' => $equipment->property_code,
                'equipment_type' => $equipment->equipmentType->persian_name,
                'building_info' => $equipment->buildingInfo->name,
                'delivery_date' => $equipment->delivery_date,
            ];
        }

        return response()->json($equipments);
    }
}
