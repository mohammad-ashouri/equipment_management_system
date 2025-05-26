<?php

namespace App\Http\Controllers\DigitalEquipments;

use App\Http\Controllers\Controller;
use App\Models\DigitalEquipments\DigitalPen;
use Illuminate\Http\Request;

class DigitalPenController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست قلم نوری', ['only' => ['index']]);
        $this->middleware('permission:ایجاد قلم نوری', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش قلم نوری', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف قلم نوری', ['only' => ['destroy']]);
    }

    public function index()
    {
        $digitalPens = DigitalPen::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('DigitalEquipments.DigitalPens.index', compact('digitalPens'));
    }

    public function create()
    {
        return view('DigitalEquipments.DigitalPens.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
            'connectivity_type' => 'required|string',
        ]);

        $digitalPen = DigitalPen::create([
            'model' => $request->input('model'),
            'connectivity_type' => $request->input('connectivity_type'),
            'brand' => $request->input('brand'),
            'adder' => $this->getMyUserId()
        ]);

        if ($digitalPen) {
            return redirect()->route('DigitalPens.index')->with('success', 'قلم نوری با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد قلم نوری']);
    }

    public function edit($id)
    {
        $digitalPen = DigitalPen::findOrFail($id);

        return view('DigitalEquipments.DigitalPens.edit', compact('digitalPen'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:digital_pens,id',
            'model' => 'required|string',
            'connectivity_type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $digitalPen = DigitalPen::findOrFail($id);
        $digitalPen->brand = $request->input('brand');
        $digitalPen->model = $request->input('model');
        $digitalPen->connectivity_type = $request->input('connectivity_type');
        $digitalPen->status = $request->input('status');
        $digitalPen->editor = $this->getMyUserId();
        $digitalPen->save();

        return redirect()->route('DigitalPens.index')->with('success', 'قلم نوری با موفقیت ویرایش شد.');
    }
}
