<?php

namespace App\Http\Controllers\HardwareEquipments;

use App\Http\Controllers\Controller;
use App\Models\HardwareEquipments\Ram;
use Illuminate\Http\Request;

class RamController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست رم', ['only' => ['index']]);
        $this->middleware('permission:ایجاد رم', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش رم', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف رم', ['only' => ['destroy']]);
    }

    public function index()
    {
        $rams = Ram::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('HardwareEquipments.Rams.index', compact('rams'));
    }

    public function create()
    {
        return view('HardwareEquipments.Rams.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
            'type' => 'required|string',
            'size' => 'required|string',
            'frequency' => 'required|integer',
            'channels' => 'required|integer',
        ]);

        $ram = Ram::create(['model' => $request->input('model'),
            'type' => $request->input('type'),
            'size' => $request->input('size'),
            'frequency' => $request->input('frequency'),
            'channels' => $request->input('channels'),
            'brand' => $request->input('brand'),
            'adder' => $this->getMyUserId()]);

        if ($ram) {
            return redirect()->route('Rams.index')->with('success', 'رم با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد رم']);
    }

    public function edit($id)
    {
        $ram = Ram::findOrFail($id);

        return view('HardwareEquipments.Rams.edit', compact('ram'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:rams,id',
            'model' => 'required|string',
            'type' => 'required|string',
            'size' => 'required|string',
            'frequency' => 'required|integer',
            'channels' => 'required|integer',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $ram = Ram::findOrFail($id);
        $ram->brand = $request->input('brand');
        $ram->model = $request->input('model');
        $ram->type = $request->input('type');
        $ram->size = $request->input('size');
        $ram->frequency = $request->input('frequency');
        $ram->channels = $request->input('channels');
        $ram->status = $request->input('status');
        $ram->editor = $this->getMyUserId();
        $ram->save();

        return redirect()->route('Rams.index')->with('success', 'رم با موفقیت ویرایش شد.');
    }
}
