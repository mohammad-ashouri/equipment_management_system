<?php

namespace App\Http\Controllers\DigitalEquipments;

use App\Http\Controllers\Controller;
use App\Models\DigitalEquipments\CameraRam;
use Illuminate\Http\Request;

class CameraRamController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست رم دوربین', ['only' => ['index']]);
        $this->middleware('permission:ایجاد رم دوربین', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش رم دوربین', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف رم دوربین', ['only' => ['destroy']]);
    }

    public function index()
    {
        $cameraRams = CameraRam::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('DigitalEquipments.CameraRams.index', compact('cameraRams'));
    }

    public function create()
    {
        return view('DigitalEquipments.CameraRams.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
            'capacity' => 'required|string',
            'type' => 'required|string',
        ]);

        $cameraRam = CameraRam::create([
            'model' => $request->input('model'),
            'brand' => $request->input('brand'),
            'capacity' => $request->input('capacity'),
            'type' => $request->input('type'),
            'adder' => $this->getMyUserId()
        ]);

        if ($cameraRam) {
            return redirect()->route('CameraRams.index')->with('success', 'رم دوربین با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد رم دوربین']);
    }

    public function edit($id)
    {
        $cameraRam = CameraRam::findOrFail($id);

        return view('DigitalEquipments.CameraRams.edit', compact('cameraRam'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:camera_rams,id',
            'model' => 'required|string',
            'capacity' => 'required|string',
            'type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $cameraRam = CameraRam::findOrFail($id);
        $cameraRam->brand = $request->input('brand');
        $cameraRam->model = $request->input('model');
        $cameraRam->capacity = $request->input('capacity');
        $cameraRam->type = $request->input('type');
        $cameraRam->status = $request->input('status');
        $cameraRam->editor = $this->getMyUserId();
        $cameraRam->save();

        return redirect()->route('CameraRams.index')->with('success', 'رم دوربین با موفقیت ویرایش شد.');
    }
}
