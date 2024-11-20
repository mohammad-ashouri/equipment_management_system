<?php

namespace App\Http\Controllers\HardwareEquipments;

use App\Http\Controllers\Controller;
use App\Models\HardwareEquipments\Odd;
use Illuminate\Http\Request;

class OddController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست درایو نوری', ['only' => ['index']]);
        $this->middleware('permission:ایجاد درایو نوری', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش درایو نوری', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف درایو نوری', ['only' => ['destroy']]);
    }

    public function index()
    {
        $odds = Odd::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('HardwareEquipments.Odds.index', compact('odds'));
    }

    public function create()
    {
        return view('HardwareEquipments.Odds.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
            'connectivity_type' => 'required|string',
        ]);

        $odd = Odd::create(['model' => $request->input('model'), 'connectivity_type' => $request->input('connectivity_type'), 'brand' => $request->input('brand'), 'adder' => $this->getMyUserId()]);

        if ($odd) {
            return redirect()->route('Odds.index')->with('success', 'درایو نوری با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد درایو نوری']);
    }

    public function edit($id)
    {
        $odd = Odd::findOrFail($id);

        return view('HardwareEquipments.Odds.edit', compact('odd'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:odds,id',
            'model' => 'required|string',
            'connectivity_type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $odd = Odd::findOrFail($id);
        $odd->brand = $request->input('brand');
        $odd->model = $request->input('model');
        $odd->status = $request->input('status');
        $odd->connectivity_type = $request->input('connectivity_type');
        $odd->editor = $this->getMyUserId();
        $odd->save();

        return redirect()->route('Odds.index')->with('success', 'درایو نوری با موفقیت ویرایش شد.');
    }
}
