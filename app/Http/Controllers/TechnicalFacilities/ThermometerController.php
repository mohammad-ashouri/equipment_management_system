<?php

namespace App\Http\Controllers\TechnicalFacilities;

use App\Http\Controllers\Controller;
use App\Models\TechnicalFacilities\Thermometer;
use Illuminate\Http\Request;

class ThermometerController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست تب سنج', ['only' => ['index']]);
        $this->middleware('permission:ایجاد تب سنج', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش تب سنج', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف تب سنج', ['only' => ['destroy']]);
    }

    public function index()
    {
        $thermometers = Thermometer::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('TechnicalFacilities.Thermometers.index', compact('thermometers'));
    }

    public function create()
    {
        return view('TechnicalFacilities.Thermometers.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $thermometer = Thermometer::create([
            'model' => $request->input('model'),
            'brand' => $request->input('brand'),
            'type' => $request->input('type'),
            'adder' => $this->getMyUserId()
        ]);

        if ($thermometer) {
            return redirect()->route('Thermometers.index')->with('success', 'تب سنج با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد تب سنج']);
    }

    public function edit($id)
    {
        $thermometer = Thermometer::findOrFail($id);

        return view('TechnicalFacilities.Thermometers.edit', compact('thermometer'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:thermometers,id',
            'model' => 'required|string',
            'type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $thermometer = Thermometer::findOrFail($id);
        $thermometer->brand = $request->input('brand');
        $thermometer->model = $request->input('model');
        $thermometer->type = $request->input('type');
        $thermometer->status = $request->input('status');
        $thermometer->editor = $this->getMyUserId();
        $thermometer->save();

        return redirect()->route('Thermometers.index')->with('success', 'تب سنج با موفقیت ویرایش شد.');
    }
}
