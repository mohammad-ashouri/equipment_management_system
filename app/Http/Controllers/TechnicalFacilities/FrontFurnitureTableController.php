<?php

namespace App\Http\Controllers\TechnicalFacilities;

use App\Http\Controllers\Controller;
use App\Models\TechnicalFacilities\FrontFurnitureTable;
use Illuminate\Http\Request;

class FrontFurnitureTableController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست جلومبلی/میز عسلی', ['only' => ['index']]);
        $this->middleware('permission:ایجاد جلومبلی/میز عسلی', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش جلومبلی/میز عسلی', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف جلومبلی/میز عسلی', ['only' => ['destroy']]);
    }

    public function index()
    {
        $frontFurnitureTables = FrontFurnitureTable::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('TechnicalFacilities.FrontFurnitureTables.index', compact('frontFurnitureTables'));
    }

    public function create()
    {
        return view('TechnicalFacilities.FrontFurnitureTables.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'material' => 'required|string',
            'width' => 'required|integer',
            'length' => 'required|integer',
            'height' => 'required|integer',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $frontFurnitureTables = FrontFurnitureTable::create(['model' => $request->input('model'), 'brand' => $request->input('brand'), 'material' => $request->input('material'), 'width' => $request->input('width'), 'length' => $request->input('length'), 'height' => $request->input('height'), 'adder' => $this->getMyUserId()]);

        if ($frontFurnitureTables) {
            return redirect()->route('FrontFurnitureTables.index')->with('success', 'جلومبلی/میز عسلی با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد جلومبلی/میز عسلی']);
    }

    public function edit($id)
    {
        $frontFurnitureTable = FrontFurnitureTable::findOrFail($id);

        return view('TechnicalFacilities.FrontFurnitureTables.edit', compact('frontFurnitureTable'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:frontFurnitureTables,id',
            'model' => 'required|string',
            'material' => 'required|string',
            'width' => 'required|integer',
            'length' => 'required|integer',
            'height' => 'required|integer',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $frontFurnitureTables = FrontFurnitureTable::findOrFail($id);
        $frontFurnitureTables->brand = $request->input('brand');
        $frontFurnitureTables->model = $request->input('model');
        $frontFurnitureTables->material = $request->input('material');
        $frontFurnitureTables->width = $request->input('width');
        $frontFurnitureTables->length = $request->input('length');
        $frontFurnitureTables->height = $request->input('height');
        $frontFurnitureTables->status = $request->input('status');
        $frontFurnitureTables->editor = $this->getMyUserId();
        $frontFurnitureTables->save();

        return redirect()->route('FrontFurnitureTables.index')->with('success', 'جلومبلی/میز عسلی با موفقیت ویرایش شد.');
    }
}
