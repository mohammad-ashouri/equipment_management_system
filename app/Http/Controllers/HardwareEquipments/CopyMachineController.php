<?php

namespace App\Http\Controllers\HardwareEquipments;

use App\Http\Controllers\Controller;
use App\Models\HardwareEquipments\CopyMachine;
use Illuminate\Http\Request;

class CopyMachineController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست دستگاه کپی', ['only' => ['index']]);
        $this->middleware('permission:ایجاد دستگاه کپی', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش دستگاه کپی', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف دستگاه کپی', ['only' => ['destroy']]);
    }

    public function index()
    {
        $copyMachines = CopyMachine::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('HardwareEquipments.CopyMachines.index', compact('copyMachines'));
    }

    public function create()
    {
        return view('HardwareEquipments.CopyMachines.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $copyMachine = CopyMachine::create(['model' => $request->input('model'), 'brand' => $request->input('brand'), 'adder' => $this->getMyUserId()]);

        if ($copyMachine) {
            return redirect()->route('CopyMachines.index')->with('success', 'دستگاه کپی با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد دستگاه کپی']);
    }

    public function edit($id)
    {
        $copyMachine = CopyMachine::findOrFail($id);

        return view('HardwareEquipments.CopyMachines.edit', compact('copyMachine'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:copy_machines,id',
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $copyMachine = CopyMachine::findOrFail($id);
        $copyMachine->brand = $request->input('brand');
        $copyMachine->model = $request->input('model');
        $copyMachine->status = $request->input('status');
        $copyMachine->editor = $this->getMyUserId();
        $copyMachine->save();

        return redirect()->route('CopyMachines.index')->with('success', 'دستگاه کپی با موفقیت ویرایش شد.');
    }
}
