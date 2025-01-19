<?php

namespace App\Http\Controllers\TechnicalFacilities;

use App\Http\Controllers\Controller;
use App\Models\TechnicalFacilities\Flashlight;
use Illuminate\Http\Request;

class FlashlightController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست چراغ قوه', ['only' => ['index']]);
        $this->middleware('permission:ایجاد چراغ قوه', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش چراغ قوه', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف چراغ قوه', ['only' => ['destroy']]);
    }

    public function index()
    {
        $flashlights = Flashlight::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('TechnicalFacilities.Flashlights.index', compact('flashlights'));
    }

    public function create()
    {
        return view('TechnicalFacilities.Flashlights.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'type' => 'required|string',
            'battery_type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $flashlight = Flashlight::create([
            'model' => $request->input('model'),
            'type' => $request->input('type'),
            'battery_type' => $request->input('battery_type'),
            'brand' => $request->input('brand'),
            'adder' => $this->getMyUserId()
        ]);

        if ($flashlight) {
            return redirect()->route('Flashlights.index')->with('success', 'چراغ قوه با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد چراغ قوه']);
    }

    public function edit($id)
    {
        $flashlight = Flashlight::findOrFail($id);

        return view('TechnicalFacilities.Flashlights.edit', compact('flashlight'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:flashlights,id',
            'model' => 'required|string',
            'type' => 'required|string',
            'battery_type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $flashlight = Flashlight::findOrFail($id);
        $flashlight->brand = $request->input('brand');
        $flashlight->model = $request->input('model');
        $flashlight->type = $request->input('type');
        $flashlight->battery_type = $request->input('battery_type');
        $flashlight->status = $request->input('status');
        $flashlight->editor = $this->getMyUserId();
        $flashlight->save();

        return redirect()->route('Flashlights.index')->with('success', 'چراغ قوه با موفقیت ویرایش شد.');
    }
}
