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
        $whiteboards = FrontFurnitureTable::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('TechnicalFacilities.FrontFurnitureTables.index', compact('whiteboards'));
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

        $whiteboards = FrontFurnitureTable::create(['model' => $request->input('model'), 'brand' => $request->input('brand'), 'material' => $request->input('material'), 'width' => $request->input('width'), 'length' => $request->input('length'), 'height' => $request->input('height'), 'adder' => $this->getMyUserId()]);

        if ($whiteboards) {
            return redirect()->route('FrontFurnitureTables.index')->with('success', 'جلومبلی/میز عسلی با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد جلومبلی/میز عسلی']);
    }

    public function edit($id)
    {
        $whiteboard = FrontFurnitureTable::findOrFail($id);

        return view('TechnicalFacilities.FrontFurnitureTables.edit', compact('whiteboard'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:whiteboards,id',
            'model' => 'required|string',
            'material' => 'required|string',
            'width' => 'required|integer',
            'length' => 'required|integer',
            'height' => 'required|integer',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $whiteboards = FrontFurnitureTable::findOrFail($id);
        $whiteboards->brand = $request->input('brand');
        $whiteboards->model = $request->input('model');
        $whiteboards->material = $request->input('material');
        $whiteboards->width = $request->input('width');
        $whiteboards->length = $request->input('length');
        $whiteboards->height = $request->input('height');
        $whiteboards->status = $request->input('status');
        $whiteboards->editor = $this->getMyUserId();
        $whiteboards->save();

        return redirect()->route('FrontFurnitureTables.index')->with('success', 'جلومبلی/میز عسلی با موفقیت ویرایش شد.');
    }
}
