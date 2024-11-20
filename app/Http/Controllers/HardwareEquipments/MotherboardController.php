<?php

namespace App\Http\Controllers\HardwareEquipments;

use App\Http\Controllers\Controller;
use App\Models\HardwareEquipments\Motherboard;
use Illuminate\Http\Request;

class MotherboardController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست مادربورد', ['only' => ['index']]);
        $this->middleware('permission:ایجاد مادربورد', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش مادربورد', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف مادربورد', ['only' => ['destroy']]);
    }

    public function index()
    {
        $motherboards = Motherboard::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('HardwareEquipments.Motherboards.index', compact('motherboards'));
    }

    public function create()
    {
        return view('HardwareEquipments.Motherboards.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
            'generation' => 'required|string',
            'cpu_slot_type' => 'required|string',
            'ram_slot_type' => 'required|string',
            'cpu_slots_number' => 'required|integer',
            'ram_slots_number' => 'required|integer',
        ]);

        $motherboard = Motherboard::create([
            'model' => $request->input('model'),
            'brand' => $request->input('brand'),
            'generation' => $request->input('generation'),
            'cpu_slot_type' => $request->input('cpu_slot_type'),
            'ram_slot_type' => $request->input('ram_slot_type'),
            'cpu_slots_number' => $request->input('cpu_slots_number'),
            'ram_slots_number' => $request->input('ram_slots_number'),
            'adder' => $this->getMyUserId()]);

        if ($motherboard) {
            return redirect()->route('Motherboards.index')->with('success', 'مادربورد با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد مادربورد']);
    }

    public function edit($id)
    {
        $motherboard = Motherboard::findOrFail($id);

        return view('HardwareEquipments.Motherboards.edit', compact('motherboard'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:motherboards,id',
            'model' => 'required|string',
            'generation' => 'required|string',
            'cpu_slot_type' => 'required|string',
            'ram_slot_type' => 'required|string',
            'cpu_slots_number' => 'required|integer',
            'ram_slots_number' => 'required|integer',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $motherboard = Motherboard::findOrFail($id);
        $motherboard->brand = $request->input('brand');
        $motherboard->model = $request->input('model');
        $motherboard->generation = $request->input('generation');
        $motherboard->cpu_slot_type = $request->input('cpu_slot_type');
        $motherboard->ram_slot_type = $request->input('ram_slot_type');
        $motherboard->cpu_slots_number = $request->input('cpu_slots_number');
        $motherboard->ram_slots_number = $request->input('ram_slots_number');
        $motherboard->status = $request->input('status');
        $motherboard->editor = $this->getMyUserId();
        $motherboard->save();

        return redirect()->route('Motherboards.index')->with('success', 'مادربورد با موفقیت ویرایش شد.');
    }
}
