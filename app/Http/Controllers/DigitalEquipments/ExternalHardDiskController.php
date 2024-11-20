<?php

namespace App\Http\Controllers\DigitalEquipments;

use App\Http\Controllers\Controller;
use App\Models\DigitalEquipments\ExternalHardDisk;
use Illuminate\Http\Request;

class ExternalHardDiskController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست هارد اکسترنال', ['only' => ['index']]);
        $this->middleware('permission:ایجاد هارد اکسترنال', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش هارد اکسترنال', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف هارد اکسترنال', ['only' => ['destroy']]);
    }

    public function index()
    {
        $externalHardDisks = ExternalHardDisk::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('DigitalEquipments.ExternalHardDisks.index', compact('externalHardDisks'));
    }

    public function create()
    {
        return view('DigitalEquipments.ExternalHardDisks.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'capacity' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $externalHardDisks = ExternalHardDisk::create(['model' => $request->input('model'), 'brand' => $request->input('brand'), 'capacity' => $request->input('capacity'), 'adder' => $this->getMyUserId()]);

        if ($externalHardDisks) {
            return redirect()->route('ExternalHardDisks.index')->with('success', 'هارد اکسترنال با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد هارد اکسترنال']);
    }

    public function edit($id)
    {
        $externalHardDisk = ExternalHardDisk::findOrFail($id);

        return view('DigitalEquipments.ExternalHardDisks.edit', compact('externalHardDisk'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:external_hard_disks,id',
            'model' => 'required|string',
            'capacity' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $externalHardDisks = ExternalHardDisk::findOrFail($id);
        $externalHardDisks->brand = $request->input('brand');
        $externalHardDisks->model = $request->input('model');
        $externalHardDisks->capacity = $request->input('capacity');
        $externalHardDisks->status = $request->input('status');
        $externalHardDisks->editor = $this->getMyUserId();
        $externalHardDisks->save();

        return redirect()->route('ExternalHardDisks.index')->with('success', 'هارد اکسترنال با موفقیت ویرایش شد.');
    }
}
