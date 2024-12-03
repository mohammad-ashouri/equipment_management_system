<?php

namespace App\Http\Controllers\TechnicalFacilities;

use App\Http\Controllers\Controller;
use App\Models\TechnicalFacilities\AirConditioner;
use Illuminate\Http\Request;

class AirConditionerController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست کولر گازی', ['only' => ['index']]);
        $this->middleware('permission:ایجاد کولر گازی', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش کولر گازی', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف کولر گازی', ['only' => ['destroy']]);
    }

    public function index()
    {
        $airConditioners = AirConditioner::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('TechnicalFacilities.AirConditioners.index', compact('airConditioners'));
    }

    public function create()
    {
        return view('TechnicalFacilities.AirConditioners.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'capacity' => 'required|integer',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $airConditioner = AirConditioner::create([
            'model' => $request->input('model'),
            'capacity' => $request->input('capacity'),
            'brand' => $request->input('brand'),
            'adder' => $this->getMyUserId()
        ]);

        if ($airConditioner) {
            return redirect()->route('AirConditioners.index')->with('success', 'کولر گازی با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد کولر گازی']);
    }

    public function edit($id)
    {
        $airConditioner = AirConditioner::findOrFail($id);

        return view('TechnicalFacilities.AirConditioners.edit', compact('airConditioner'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:air_conditioners,id',
            'model' => 'required|string',
            'capacity' => 'required|integer',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $blower = AirConditioner::findOrFail($id);
        $blower->brand = $request->input('brand');
        $blower->model = $request->input('model');
        $blower->power_type = $request->input('power_type');
        $blower->status = $request->input('status');
        $blower->editor = $this->getMyUserId();
        $blower->save();

        return redirect()->route('AirConditioners.index')->with('success', 'کولر گازی با موفقیت ویرایش شد.');
    }
}
