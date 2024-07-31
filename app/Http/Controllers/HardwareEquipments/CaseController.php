<?php

namespace App\Http\Controllers\HardwareEquipments;

use App\Http\Controllers\Controller;
use App\Models\HardwareEquipments\Cases;
use Illuminate\Http\Request;

class CaseController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست کیس', ['only' => ['index']]);
        $this->middleware('permission:ایجاد کیس', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش کیس', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف کیس', ['only' => ['destroy']]);
    }

    public function index()
    {
        $cases = Cases::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->paginate(50);
        return view('HardwareEquipments.Cases.index', compact('cases'));
    }

    public function create()
    {
        return view('HardwareEquipments.Cases.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $case = Cases::create(['model' => $request->input('model'), 'brand' => $request->input('brand'), 'adder' => $this->getMyUserId()]);

        if ($case) {
            return redirect()->route('Cases.index')->with('success', 'کیس با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد کیس']);
    }

    public function edit($id)
    {
        $case = Cases::findOrFail($id);

        return view('HardwareEquipments.Cases.edit', compact('case'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:cases,id',
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $case = Cases::findOrFail($id);
        $case->brand = $request->input('brand');
        $case->model = $request->input('model');
        $case->status = $request->input('status');
        $case->editor = $this->getMyUserId();
        $case->save();

        return redirect()->route('Cases.index')->with('success', 'کیس با موفقیت ویرایش شد.');
    }
}
