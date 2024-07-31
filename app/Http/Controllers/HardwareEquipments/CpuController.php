<?php

namespace App\Http\Controllers\HardwareEquipments;

use App\Http\Controllers\Controller;
use App\Models\HardwareEquipments\Cpu;
use Illuminate\Http\Request;

class CpuController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست پردازنده', ['only' => ['index']]);
        $this->middleware('permission:ایجاد پردازنده', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش پردازنده', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف پردازنده', ['only' => ['destroy']]);
    }

    public function index()
    {
        $cpus = Cpu::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->paginate(50);
        return view('HardwareEquipments.Cpus.index', compact('cpus'));
    }

    public function create()
    {
        return view('HardwareEquipments.Cpus.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'generation' => 'required|integer',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $cpu = Cpu::create(['model' => $request->input('model'), 'brand' => $request->input('brand'), 'generation' => $request->input('generation'), 'adder' => $this->getMyUserId()]);

        if ($cpu) {
            return redirect()->route('Cpus.index')->with('success', 'پردازنده با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد پردازنده']);
    }

    public function edit($id)
    {
        $cpu = Cpu::findOrFail($id);

        return view('HardwareEquipments.Cpus.edit', compact('cpu'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:cpus,id',
            'model' => 'required|string',
            'generation' => 'required|integer',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $cpu = Cpu::findOrFail($id);
        $cpu->brand = $request->input('brand');
        $cpu->model = $request->input('model');
        $cpu->generation = $request->input('generation');
        $cpu->status = $request->input('status');
        $cpu->editor = $this->getMyUserId();
        $cpu->save();

        return redirect()->route('Cpus.index')->with('success', 'پردازنده با موفقیت ویرایش شد.');
    }
}
