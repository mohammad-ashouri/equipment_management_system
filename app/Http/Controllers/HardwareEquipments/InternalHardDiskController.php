<?php

namespace App\Http\Controllers\HardwareEquipments;

use App\Http\Controllers\Controller;
use App\Models\HardwareEquipments\InternalHardDisk;
use Illuminate\Http\Request;

class InternalHardDiskController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست هارد اینترنال', ['only' => ['index']]);
        $this->middleware('permission:ایجاد هارد اینترنال', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش هارد اینترنال', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف هارد اینترنال', ['only' => ['destroy']]);
    }

    public function index()
    {
        $internalHardDisks = InternalHardDisk::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('HardwareEquipments.InternalHardDisks.index', compact('internalHardDisks'));
    }

    public function create()
    {
        return view('HardwareEquipments.InternalHardDisks.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'capacity' => 'required|string',
            'connectivity_type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $internalHardDisks = InternalHardDisk::create(['model' => $request->input('model'), 'brand' => $request->input('brand'), 'capacity' => $request->input('capacity'), 'connectivity_type' => $request->input('connectivity_type'), 'adder' => $this->getMyUserId()]);

        if ($internalHardDisks) {
            return redirect()->route('InternalHardDisks.index')->with('success', 'هارد اینترنال با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد هارد اینترنال']);
    }

    public function edit($id)
    {
        $internalHardDisk = InternalHardDisk::findOrFail($id);

        return view('HardwareEquipments.InternalHardDisks.edit', compact('internalHardDisk'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:internal_hard_disks,id',
            'model' => 'required|string',
            'capacity' => 'required|string',
            'connectivity_type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $internalHardDisks = InternalHardDisk::findOrFail($id);
        $internalHardDisks->brand = $request->input('brand');
        $internalHardDisks->model = $request->input('model');
        $internalHardDisks->capacity = $request->input('capacity');
        $internalHardDisks->connectivity_type = $request->input('connectivity_type');
        $internalHardDisks->status = $request->input('status');
        $internalHardDisks->editor = $this->getMyUserId();
        $internalHardDisks->save();

        return redirect()->route('InternalHardDisks.index')->with('success', 'هارد اینترنال با موفقیت ویرایش شد.');
    }
}
