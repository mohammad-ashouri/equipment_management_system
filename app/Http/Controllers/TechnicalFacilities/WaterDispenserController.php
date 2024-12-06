<?php

namespace App\Http\Controllers\TechnicalFacilities;

use App\Http\Controllers\Controller;
use App\Models\TechnicalFacilities\WaterDispenser;
use Illuminate\Http\Request;

class WaterDispenserController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست آبسردکن', ['only' => ['index']]);
        $this->middleware('permission:ایجاد آبسردکن', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش آبسردکن', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف آبسردکن', ['only' => ['destroy']]);
    }

    public function index()
    {
        $waterDispensers = WaterDispenser::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('TechnicalFacilities.WaterDispensers.index', compact('waterDispensers'));
    }

    public function create()
    {
        return view('TechnicalFacilities.WaterDispensers.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'refrigerator' => 'required|boolean',
            'tank' => 'required|boolean',
            'cold_water_tap' => 'required|integer',
            'warm_water_tap' => 'required|boolean',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $waterDispensers = WaterDispenser::create([
            'model' => $request->input('model'),
            'brand' => $request->input('brand'),
            'refrigerator' => $request->input('refrigerator'),
            'tank' => $request->input('tank'),
            'cold_water_tap' => $request->input('cold_water_tap'),
            'warm_water_tap' => $request->input('warm_water_tap'),
            'adder' => $this->getMyUserId()
        ]);

        if ($waterDispensers) {
            return redirect()->route('WaterDispensers.index')->with('success', 'آبسردکن با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد آبسردکن']);
    }

    public function edit($id)
    {
        $waterDispenser = WaterDispenser::findOrFail($id);

        return view('TechnicalFacilities.WaterDispensers.edit', compact('waterDispenser'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:water_purifiers,id',
            'model' => 'required|string',
            'refrigerator' => 'required|boolean',
            'tank' => 'required|boolean',
            'cold_water_tap' => 'required|integer',
            'warm_water_tap' => 'required|boolean',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $waterDispensers = WaterDispenser::findOrFail($id);
        $waterDispensers->brand = $request->input('brand');
        $waterDispensers->model = $request->input('model');
        $waterDispensers->refrigerator = $request->input('refrigerator');
        $waterDispensers->tank = $request->input('tank');
        $waterDispensers->cold_water_tap = $request->input('cold_water_tap');
        $waterDispensers->warm_water_tap = $request->input('warm_water_tap');
        $waterDispensers->status = $request->input('status');
        $waterDispensers->editor = $this->getMyUserId();
        $waterDispensers->save();

        return redirect()->route('WaterDispensers.index')->with('success', 'آبسردکن با موفقیت ویرایش شد.');
    }
}
