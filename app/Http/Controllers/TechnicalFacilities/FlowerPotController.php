<?php

namespace App\Http\Controllers\TechnicalFacilities;

use App\Http\Controllers\Controller;
use App\Models\TechnicalFacilities\FlowerPot;
use Illuminate\Http\Request;

class FlowerPotController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست استند گلدان', ['only' => ['index']]);
        $this->middleware('permission:ایجاد استند گلدان', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش استند گلدان', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف استند گلدان', ['only' => ['destroy']]);
    }

    public function index()
    {
        $flowerPots = FlowerPot::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('TechnicalFacilities.FlowerPots.index', compact('flowerPots'));
    }

    public function create()
    {
        return view('TechnicalFacilities.FlowerPots.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'material' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $flowerPot = FlowerPot::create([
            'model' => $request->input('model'),
            'material' => $request->input('material'),
            'brand' => $request->input('brand'),
            'adder' => $this->getMyUserId()
        ]);

        if ($flowerPot) {
            return redirect()->route('FlowerPots.index')->with('success', 'استند گلدان با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد استند گلدان']);
    }

    public function edit($id)
    {
        $flowerPot = FlowerPot::findOrFail($id);

        return view('TechnicalFacilities.FlowerPots.edit', compact('flowerPot'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:flower_pots,id',
            'model' => 'required|string',
            'material' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $flowerPot = FlowerPot::findOrFail($id);
        $flowerPot->brand = $request->input('brand');
        $flowerPot->model = $request->input('model');
        $flowerPot->material = $request->input('material');
        $flowerPot->status = $request->input('status');
        $flowerPot->editor = $this->getMyUserId();
        $flowerPot->save();

        return redirect()->route('FlowerPots.index')->with('success', 'استند گلدان با موفقیت ویرایش شد.');
    }
}
