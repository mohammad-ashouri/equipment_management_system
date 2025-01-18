<?php

namespace App\Http\Controllers\TechnicalFacilities;

use App\Http\Controllers\Controller;
use App\Models\TechnicalFacilities\Heater;
use Illuminate\Http\Request;

class HeaterController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست بخاری', ['only' => ['index']]);
        $this->middleware('permission:ایجاد بخاری', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش بخاری', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف بخاری', ['only' => ['destroy']]);
    }

    public function index()
    {
        $heaters = Heater::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('TechnicalFacilities.Heaters.index', compact('heaters'));
    }

    public function create()
    {
        return view('TechnicalFacilities.Heaters.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'fan' => 'required|boolean',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $heater = Heater::create([
            'model' => $request->input('model'),
            'fan' => $request->input('fan'),
            'brand' => $request->input('brand'),
            'adder' => $this->getMyUserId()
        ]);

        if ($heater) {
            return redirect()->route('Heaters.index')->with('success', 'بخاری با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد بخاری']);
    }

    public function edit($id)
    {
        $heater = Heater::findOrFail($id);

        return view('TechnicalFacilities.Heaters.edit', compact('heater'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:heaters,id',
            'model' => 'required|string',
            'fan' => 'required|boolean',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $heater = Heater::findOrFail($id);
        $heater->brand = $request->input('brand');
        $heater->model = $request->input('model');
        $heater->fan = $request->input('fan');
        $heater->status = $request->input('status');
        $heater->editor = $this->getMyUserId();
        $heater->save();

        return redirect()->route('Heaters.index')->with('success', 'بخاری با موفقیت ویرایش شد.');
    }
}
