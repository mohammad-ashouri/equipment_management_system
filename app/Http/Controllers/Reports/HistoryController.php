<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\ChangeHistory;

class HistoryController extends Controller
{
    public function index($personnelId, $equipmentId)
    {
        $history = ChangeHistory::with('userInfo', 'equipmentInfo')
            ->where('equipment_id', $equipmentId)
            ->whereHas('equipmentInfo', function ($query) use ($personnelId) {
                $query->where('personnel', $personnelId);
            })
            ->orderByDesc('created_at')
            ->get();
        return view('Reports.ChangesHistory', compact('history'));
    }
}
