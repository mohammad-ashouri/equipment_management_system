<?php

namespace App\Http\Controllers\TechnicalFacilities;

use App\Http\Controllers\Controller;
use App\Models\TechnicalFacilities\LaminatingMachine;
use Illuminate\Http\Request;

class LaminatingMachineController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست کاغذ خردکن', ['only' => ['index']]);
        $this->middleware('permission:ایجاد کاغذ خردکن', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش کاغذ خردکن', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف کاغذ خردکن', ['only' => ['destroy']]);
    }

    public function index()
    {
        $laminatingMachines = LaminatingMachine::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('TechnicalFacilities.LaminatingMachines.index', compact('laminatingMachines'));
    }

    public function create()
    {
        return view('TechnicalFacilities.LaminatingMachines.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $laminatingMachines = LaminatingMachine::create(['model' => $request->input('model'), 'brand' => $request->input('brand'), 'type' => $request->input('type'), 'adder' => $this->getMyUserId()]);

        if ($laminatingMachines) {
            return redirect()->route('LaminatingMachines.index')->with('success', 'کاغذ خردکن با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد کاغذ خردکن']);
    }

    public function edit($id)
    {
        $laminatingMachine = LaminatingMachine::findOrFail($id);

        return view('TechnicalFacilities.LaminatingMachines.edit', compact('laminatingMachine'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:laminating_machines,id',
            'model' => 'required|string',
            'type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $laminatingMachines = LaminatingMachine::findOrFail($id);
        $laminatingMachines->brand = $request->input('brand');
        $laminatingMachines->model = $request->input('model');
        $laminatingMachines->type = $request->input('type');
        $laminatingMachines->status = $request->input('status');
        $laminatingMachines->editor = $this->getMyUserId();
        $laminatingMachines->save();

        return redirect()->route('LaminatingMachines.index')->with('success', 'کاغذ خردکن با موفقیت ویرایش شد.');
    }
}
