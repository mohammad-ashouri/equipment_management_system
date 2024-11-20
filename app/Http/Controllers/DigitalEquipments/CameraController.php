<?php

namespace App\Http\Controllers\DigitalEquipments;

use App\Http\Controllers\Controller;
use App\Models\DigitalEquipments\Camera;
use Illuminate\Http\Request;

class CameraController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست دوربین', ['only' => ['index']]);
        $this->middleware('permission:ایجاد دوربین', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش دوربین', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف دوربین', ['only' => ['destroy']]);
    }

    public function index()
    {
        $cameras = Camera::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('DigitalEquipments.Cameras.index', compact('cameras'));
    }

    public function create()
    {
        return view('DigitalEquipments.Cameras.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $cameras = Camera::create(['model' => $request->input('model'), 'brand' => $request->input('brand'), 'type' => $request->input('type'), 'adder' => $this->getMyUserId()]);

        if ($cameras) {
            return redirect()->route('Cameras.index')->with('success', 'دوربین با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد دوربین']);
    }

    public function edit($id)
    {
        $camera = Camera::findOrFail($id);

        return view('DigitalEquipments.Cameras.edit', compact('camera'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:cameras,id',
            'model' => 'required|string',
            'type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $cameras = Camera::findOrFail($id);
        $cameras->brand = $request->input('brand');
        $cameras->model = $request->input('model');
        $cameras->type = $request->input('type');
        $cameras->status = $request->input('status');
        $cameras->editor = $this->getMyUserId();
        $cameras->save();

        return redirect()->route('Cameras.index')->with('success', 'دوربین با موفقیت ویرایش شد.');
    }
}
