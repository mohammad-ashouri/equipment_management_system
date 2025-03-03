<?php

namespace App\Http\Controllers\DigitalEquipments;

use App\Http\Controllers\Controller;
use App\Models\DigitalEquipments\CameraSlider;
use Illuminate\Http\Request;

class CameraSliderController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست اسلایدر دوربین', ['only' => ['index']]);
        $this->middleware('permission:ایجاد اسلایدر دوربین', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش اسلایدر دوربین', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف اسلایدر دوربین', ['only' => ['destroy']]);
    }

    public function index()
    {
        $cameraSliders = CameraSlider::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('DigitalEquipments.CameraSliders.index', compact('cameraSliders'));
    }

    public function create()
    {
        return view('DigitalEquipments.CameraSliders.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $cameraSlider = CameraSlider::create([
            'model' => $request->input('model'),
            'brand' => $request->input('brand'),
            'adder' => $this->getMyUserId()
        ]);

        if ($cameraSlider) {
            return redirect()->route('CameraSliders.index')->with('success', 'اسلایدر دوربین با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد اسلایدر دوربین']);
    }

    public function edit($id)
    {
        $cameraSlider = CameraSlider::findOrFail($id);

        return view('DigitalEquipments.CameraSliders.edit', compact('cameraSlider'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:camera_lenses,id',
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $cameraSlider = CameraSlider::findOrFail($id);
        $cameraSlider->brand = $request->input('brand');
        $cameraSlider->model = $request->input('model');
        $cameraSlider->status = $request->input('status');
        $cameraSlider->editor = $this->getMyUserId();
        $cameraSlider->save();

        return redirect()->route('CameraSliders.index')->with('success', 'اسلایدر دوربین با موفقیت ویرایش شد.');
    }
}
