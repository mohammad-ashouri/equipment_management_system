<?php

namespace App\Http\Controllers\DigitalEquipments;

use App\Http\Controllers\Controller;
use App\Models\DigitalEquipments\CameraLens;
use Illuminate\Http\Request;

class CameraLensController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست لنز دوربین', ['only' => ['index']]);
        $this->middleware('permission:ایجاد لنز دوربین', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش لنز دوربین', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف لنز دوربین', ['only' => ['destroy']]);
    }

    public function index()
    {
        $cameraLenses = CameraLens::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->paginate(50);
        return view('DigitalEquipments.CameraLenses.index', compact('cameraLenses'));
    }

    public function create()
    {
        return view('DigitalEquipments.CameraLenses.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $cameraLens = CameraLens::create([
            'model' => $request->input('model'),
            'brand' => $request->input('brand'),
            'adder' => $this->getMyUserId()
        ]);

        if ($cameraLens) {
            return redirect()->route('CameraLenses.index')->with('success', 'لنز دوربین با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد لنز دوربین']);
    }

    public function edit($id)
    {
        $cameraLens = CameraLens::findOrFail($id);

        return view('DigitalEquipments.CameraLenses.edit', compact('cameraLens'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:camera_lenses,id',
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $cameraLens = CameraLens::findOrFail($id);
        $cameraLens->brand = $request->input('brand');
        $cameraLens->model = $request->input('model');
        $cameraLens->status = $request->input('status');
        $cameraLens->editor = $this->getMyUserId();
        $cameraLens->save();

        return redirect()->route('CameraLenses.index')->with('success', 'لنز دوربین با موفقیت ویرایش شد.');
    }
}
