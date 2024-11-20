<?php

namespace App\Http\Controllers\DigitalEquipments;

use App\Http\Controllers\Controller;
use App\Models\DigitalEquipments\BatteryCharger;
use Illuminate\Http\Request;

class BatteryChargerController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست شارژر باتری', ['only' => ['index']]);
        $this->middleware('permission:ایجاد شارژر باتری', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش شارژر باتری', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف شارژر باتری', ['only' => ['destroy']]);
    }

    public function index()
    {
        $batteryChargers = BatteryCharger::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('DigitalEquipments.BatteryChargers.index', compact('batteryChargers'));
    }

    public function create()
    {
        return view('DigitalEquipments.BatteryChargers.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $batteryCharger = BatteryCharger::create([
            'model' => $request->input('model'),
            'brand' => $request->input('brand'),
            'adder' => $this->getMyUserId()
        ]);

        if ($batteryCharger) {
            return redirect()->route('BatteryChargers.index')->with('success', 'شارژر باتری با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد شارژر باتری']);
    }

    public function edit($id)
    {
        $batteryCharger = BatteryCharger::findOrFail($id);

        return view('DigitalEquipments.BatteryChargers.edit', compact('batteryCharger'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:battery_chargers,id',
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $batteryCharger = BatteryCharger::findOrFail($id);
        $batteryCharger->brand = $request->input('brand');
        $batteryCharger->model = $request->input('model');
        $batteryCharger->status = $request->input('status');
        $batteryCharger->editor = $this->getMyUserId();
        $batteryCharger->save();

        return redirect()->route('BatteryChargers.index')->with('success', 'شارژر باتری با موفقیت ویرایش شد.');
    }
}
