<?php

namespace App\Http\Controllers\HardwareEquipments;

use App\Http\Controllers\Controller;
use App\Models\HardwareEquipments\Mouse;
use Illuminate\Http\Request;

class MouseController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست موس', ['only' => ['index']]);
        $this->middleware('permission:ایجاد موس', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش موس', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف موس', ['only' => ['destroy']]);
    }

    public function index()
    {
        $mouses = Mouse::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('HardwareEquipments.Mouses.index', compact('mouses'));
    }

    public function create()
    {
        return view('HardwareEquipments.Mouses.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'connectivity_type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $mouse = Mouse::create(['model' => $request->input('model'), 'brand' => $request->input('brand'),'connectivity_type' => $request->input('connectivity_type'), 'adder' => $this->getMyUserId()]);

        if ($mouse) {
            return redirect()->route('Mouses.index')->with('success', 'موس با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد موس']);
    }

    public function edit($id)
    {
        $mouse = Mouse::findOrFail($id);

        return view('HardwareEquipments.Mouses.edit', compact('mouse'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:mouses,id',
            'model' => 'required|string',
            'connectivity_type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $mouse = Mouse::findOrFail($id);
        $mouse->brand = $request->input('brand');
        $mouse->model = $request->input('model');
        $mouse->connectivity_type = $request->input('connectivity_type');
        $mouse->status = $request->input('status');
        $mouse->editor = $this->getMyUserId();
        $mouse->save();

        return redirect()->route('Mouses.index')->with('success', 'موس با موفقیت ویرایش شد.');
    }
}
