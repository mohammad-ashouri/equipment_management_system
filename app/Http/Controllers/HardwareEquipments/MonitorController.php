<?php

namespace App\Http\Controllers\HardwareEquipments;

use App\Http\Controllers\Controller;
use App\Models\HardwareEquipments\Monitor;
use Illuminate\Http\Request;

class MonitorController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست مانیتور', ['only' => ['index']]);
        $this->middleware('permission:ایجاد مانیتور', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش مانیتور', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف مانیتور', ['only' => ['destroy']]);
    }

    public function index()
    {
        $monitors = Monitor::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->paginate(50);
        return view('HardwareEquipments.Monitors.index', compact('monitors'));
    }

    public function create()
    {
        return view('HardwareEquipments.Monitors.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
            'size' => 'required|numeric',
        ]);

        $monitor = Monitor::create(['model' => $request->input('model'), 'size' => $request->input('size'), 'brand' => $request->input('brand'), 'adder' => $this->getMyUserId()]);

        if ($monitor) {
            return redirect()->route('Monitors.index')->with('success', 'مانیتور با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد مانیتور']);
    }

    public function edit($id)
    {
        $monitor = Monitor::find($id);

        return view('HardwareEquipments.Monitors.edit', compact('monitor'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:monitors,id',
            'model' => 'required|string',
            'size' => 'required|numeric',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $monitor = Monitor::find($id);
        $monitor->brand = $request->input('brand');
        $monitor->model = $request->input('model');
        $monitor->status = $request->input('status');
        $monitor->size = $request->input('size');
        $monitor->editor = $this->getMyUserId();
        $monitor->save();

        return redirect()->route('Monitors.index')->with('success', 'مانیتور با موفقیت ویرایش شد.');
    }
}
