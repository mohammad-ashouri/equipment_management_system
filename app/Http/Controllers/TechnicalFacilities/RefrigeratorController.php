<?php

namespace App\Http\Controllers\TechnicalFacilities;

use App\Http\Controllers\Controller;
use App\Models\TechnicalFacilities\Refrigerator;
use Illuminate\Http\Request;

class RefrigeratorController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست یخچال', ['only' => ['index']]);
        $this->middleware('permission:ایجاد یخچال', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش یخچال', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف یخچال', ['only' => ['destroy']]);
    }

    public function index()
    {
        $refrigerators = Refrigerator::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('TechnicalFacilities.Refrigerators.index', compact('refrigerators'));
    }

    public function create()
    {
        return view('TechnicalFacilities.Refrigerators.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $refrigerators = Refrigerator::create(['model' => $request->input('model'), 'brand' => $request->input('brand'), 'type' => $request->input('type'), 'adder' => $this->getMyUserId()]);

        if ($refrigerators) {
            return redirect()->route('Refrigerators.index')->with('success', 'یخچال با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد یخچال']);
    }

    public function edit($id)
    {
        $refrigerator = Refrigerator::findOrFail($id);

        return view('TechnicalFacilities.Refrigerators.edit', compact('refrigerator'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:refrigerators,id',
            'model' => 'required|string',
            'type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $refrigerators = Refrigerator::findOrFail($id);
        $refrigerators->brand = $request->input('brand');
        $refrigerators->model = $request->input('model');
        $refrigerators->type = $request->input('type');
        $refrigerators->status = $request->input('status');
        $refrigerators->editor = $this->getMyUserId();
        $refrigerators->save();

        return redirect()->route('Refrigerators.index')->with('success', 'یخچال با موفقیت ویرایش شد.');
    }
}
