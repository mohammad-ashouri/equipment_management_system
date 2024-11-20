<?php

namespace App\Http\Controllers\HardwareEquipments;

use App\Http\Controllers\Controller;
use App\Models\HardwareEquipments\Headset;
use Illuminate\Http\Request;

class HeadsetController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست هدست', ['only' => ['index']]);
        $this->middleware('permission:ایجاد هدست', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش هدست', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف هدست', ['only' => ['destroy']]);
    }

    public function index()
    {
        $headsets = Headset::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('HardwareEquipments.Headsets.index', compact('headsets'));
    }

    public function create()
    {
        return view('HardwareEquipments.Headsets.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'connectivity_type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $headset = Headset::create(['model' => $request->input('model'), 'brand' => $request->input('brand'),'connectivity_type' => $request->input('connectivity_type'), 'adder' => $this->getMyUserId()]);

        if ($headset) {
            return redirect()->route('Headsets.index')->with('success', 'هدست با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد هدست']);
    }

    public function edit($id)
    {
        $headset = Headset::findOrFail($id);

        return view('HardwareEquipments.Headsets.edit', compact('headset'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:headsets,id',
            'model' => 'required|string',
            'connectivity_type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $headset = Headset::findOrFail($id);
        $headset->brand = $request->input('brand');
        $headset->model = $request->input('model');
        $headset->connectivity_type = $request->input('connectivity_type');
        $headset->status = $request->input('status');
        $headset->editor = $this->getMyUserId();
        $headset->save();

        return redirect()->route('Headsets.index')->with('success', 'هدست با موفقیت ویرایش شد.');
    }
}
