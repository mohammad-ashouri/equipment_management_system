<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\ChangeHistory;

class HistoryController extends Controller
{
    public function index()
    {
        $history = ChangeHistory::with('userInfo')->where('equipment_id', 1)->select('changes','created_at','user')->get();
        return view('Reports.ChangesHistory', compact('history'));
    }
}
