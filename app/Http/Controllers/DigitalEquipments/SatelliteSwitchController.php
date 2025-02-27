<?php

namespace App\Http\Controllers\DigitalEquipments;

use App\Http\Controllers\Controller;
use App\Models\DigitalEquipments\SatelliteSwitch;
use Illuminate\Http\Request;

class SatelliteSwitchController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست سوییچ ماهواره', ['only' => ['index']]);
        $this->middleware('permission:ایجاد سوییچ ماهواره', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش سوییچ ماهواره', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف سوییچ ماهواره', ['only' => ['destroy']]);
    }

    public function index()
    {
        $satelliteSwitches = SatelliteSwitch::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('DigitalEquipments.SatelliteSwitches.index', compact('satelliteSwitches'));
    }

    public function create()
    {
        return view('DigitalEquipments.SatelliteSwitches.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $satelliteSwitch = SatelliteSwitch::create([
            'model' => $request->input('model'),
            'brand' => $request->input('brand'),
            'adder' => $this->getMyUserId()
        ]);

        if ($satelliteSwitch) {
            return redirect()->route('SatelliteSwitches.index')->with('success', 'سوییچ ماهواره با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد سوییچ ماهواره']);
    }

    public function edit($id)
    {
        $satelliteSwitch = SatelliteSwitch::findOrFail($id);

        return view('DigitalEquipments.SatelliteSwitches.edit', compact('satelliteSwitch'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:satellite_switches,id',
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $satelliteSwitch = SatelliteSwitch::findOrFail($id);
        $satelliteSwitch->brand = $request->input('brand');
        $satelliteSwitch->model = $request->input('model');
        $satelliteSwitch->status = $request->input('status');
        $satelliteSwitch->editor = $this->getMyUserId();
        $satelliteSwitch->save();

        return redirect()->route('SatelliteSwitches.index')->with('success', 'سوییچ ماهواره با موفقیت ویرایش شد.');
    }
}
