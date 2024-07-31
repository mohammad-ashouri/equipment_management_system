<?php

namespace App\Http\Controllers\HardwareEquipments;

use App\Http\Controllers\Controller;
use App\Models\HardwareEquipments\Power;
use Illuminate\Http\Request;

class PowerController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست منبع تغذیه', ['only' => ['index']]);
        $this->middleware('permission:ایجاد منبع تغذیه', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش منبع تغذیه', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف منبع تغذیه', ['only' => ['destroy']]);
    }

    public function index()
    {
        $powers = Power::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->paginate(50);
        return view('HardwareEquipments.Powers.index', compact('powers'));
    }

    public function create()
    {
        return view('HardwareEquipments.Powers.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
            'voltage' => 'required|numeric',
        ]);

        $power = Power::create(['model' => $request->input('model'), 'voltage' => $request->input('voltage'), 'brand' => $request->input('brand'), 'adder' => $this->getMyUserId()]);

        if ($power) {
            return redirect()->route('Powers.index')->with('success', 'منبع تغذیه با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد منبع تغذیه']);
    }

    public function edit($id)
    {
        $power = Power::findOrFail($id);

        return view('HardwareEquipments.Powers.edit', compact('power'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:powers,id',
            'model' => 'required|string',
            'voltage' => 'required|numeric',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $power = Power::findOrFail($id);
        $power->brand = $request->input('brand');
        $power->model = $request->input('model');
        $power->status = $request->input('status');
        $power->voltage = $request->input('voltage');
        $power->editor = $this->getMyUserId();
        $power->save();

        return redirect()->route('Powers.index')->with('success', 'منبع تغذیه با موفقیت ویرایش شد.');
    }
}
