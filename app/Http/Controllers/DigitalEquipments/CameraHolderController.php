<?php

namespace App\Http\Controllers\DigitalEquipments;

use App\Http\Controllers\Controller;
use App\Models\DigitalEquipments\CameraHolder;
use Illuminate\Http\Request;

class CameraHolderController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست پایه دوربین', ['only' => ['index']]);
        $this->middleware('permission:ایجاد پایه دوربین', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش پایه دوربین', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف پایه دوربین', ['only' => ['destroy']]);
    }

    public function index()
    {
        $cameraHolders = CameraHolder::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->paginate(50);
        return view('DigitalEquipments.CameraHolders.index', compact('cameraHolders'));
    }

    public function create()
    {
        return view('DigitalEquipments.CameraHolders.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'type' => 'required|string',
            'parts_number' => 'required|integer',
            'head_type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $cameraHolders = CameraHolder::create(['model' => $request->input('model'),
            'brand' => $request->input('brand'),
            'type' => $request->input('type'),
            'parts_number' => $request->input('parts_number'),
            'head_type' => $request->input('head_type'),
            'adder' => $this->getMyUserId()]);

        if ($cameraHolders) {
            return redirect()->route('CameraHolders.index')->with('success', 'پایه دوربین با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد پایه دوربین']);
    }

    public function edit($id)
    {
        $cameraHolder = CameraHolder::findOrFail($id);

        return view('DigitalEquipments.CameraHolders.edit', compact('cameraHolder'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:camera_holders,id',
            'model' => 'required|string',
            'type' => 'required|string',
            'parts_number' => 'required|integer',
            'head_type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $cameraHolders = CameraHolder::findOrFail($id);
        $cameraHolders->brand = $request->input('brand');
        $cameraHolders->model = $request->input('model');
        $cameraHolders->type = $request->input('type');
        $cameraHolders->parts_number = $request->input('parts_number');
        $cameraHolders->head_type = $request->input('head_type');
        $cameraHolders->status = $request->input('status');
        $cameraHolders->editor = $this->getMyUserId();
        $cameraHolders->save();

        return redirect()->route('CameraHolders.index')->with('success', 'پایه دوربین با موفقیت ویرایش شد.');
    }
}
