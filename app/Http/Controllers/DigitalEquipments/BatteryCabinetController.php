<?php

namespace App\Http\Controllers\DigitalEquipments;

use App\Http\Controllers\Controller;
use App\Models\DigitalEquipments\BatteryCabinet;
use Illuminate\Http\Request;

class BatteryCabinetController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست کابینت باتری', ['only' => ['index']]);
        $this->middleware('permission:ایجاد کابینت باتری', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش کابینت باتری', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف کابینت باتری', ['only' => ['destroy']]);
    }

    public function index()
    {
        $batteryCabinets = BatteryCabinet::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('DigitalEquipments.BatteryCabinets.index', compact('batteryCabinets'));
    }

    public function create()
    {
        return view('DigitalEquipments.BatteryCabinets.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $batteryCabinet = BatteryCabinet::create([
            'model' => $request->input('model'),
            'brand' => $request->input('brand'),
            'adder' => $this->getMyUserId()
        ]);

        if ($batteryCabinet) {
            return redirect()->route('BatteryCabinets.index')->with('success', 'کابینت باتری با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد کابینت باتری']);
    }

    public function edit($id)
    {
        $batteryCabinet = BatteryCabinet::findOrFail($id);

        return view('DigitalEquipments.BatteryCabinets.edit', compact('batteryCabinet'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:battery_chargers,id',
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $batteryCabinet = BatteryCabinet::findOrFail($id);
        $batteryCabinet->brand = $request->input('brand');
        $batteryCabinet->model = $request->input('model');
        $batteryCabinet->status = $request->input('status');
        $batteryCabinet->editor = $this->getMyUserId();
        $batteryCabinet->save();

        return redirect()->route('BatteryCabinets.index')->with('success', 'کابینت باتری با موفقیت ویرایش شد.');
    }
}
