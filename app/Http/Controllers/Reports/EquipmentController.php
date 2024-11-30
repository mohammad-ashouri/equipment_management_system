<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function allEquipments()
    {
        $allEquipments = Equipment::get();
        return view('Reports.AllEquipments', compact('allEquipments'));
    }
}
