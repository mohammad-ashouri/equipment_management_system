<?php

namespace App\Http\Controllers\TechnicalFacilities;

use App\Http\Controllers\Controller;
use App\Models\TechnicalFacilities\ServingTrolley;
use Illuminate\Http\Request;

class ServingTrolleyController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست ترولی پذیرایی', ['only' => ['index']]);
        $this->middleware('permission:ایجاد ترولی پذیرایی', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش ترولی پذیرایی', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف ترولی پذیرایی', ['only' => ['destroy']]);
    }

    public function index()
    {
        $servingTrolleys = ServingTrolley::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('TechnicalFacilities.ServingTrolleys.index', compact('servingTrolleys'));
    }

    public function create()
    {
        return view('TechnicalFacilities.ServingTrolleys.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'material' => 'required|string',
            'floors_number' => 'required|integer',
            'color' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $servingTrolleys = ServingTrolley::create([
            'model' => $request->input('model'),
            'brand' => $request->input('brand'),
            'material' => $request->input('material'),
            'floors_number' => $request->input('floors_number'),
            'color' => $request->input('color'),
            'adder' => $this->getMyUserId()
        ]);

        if ($servingTrolleys) {
            return redirect()->route('ServingTrolleys.index')->with('success', 'ترولی پذیرایی با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد ترولی پذیرایی']);
    }

    public function edit($id)
    {
        $servingTrolley = ServingTrolley::findOrFail($id);

        return view('TechnicalFacilities.ServingTrolleys.edit', compact('servingTrolley'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:serving_trolleys,id',
            'model' => 'required|string',
            'material' => 'required|string',
            'floors_number' => 'required|integer',
            'color' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $servingTrolleys = ServingTrolley::findOrFail($id);
        $servingTrolleys->brand = $request->input('brand');
        $servingTrolleys->model = $request->input('model');
        $servingTrolleys->material = $request->input('material');
        $servingTrolleys->floors_number = $request->input('floors_number');
        $servingTrolleys->color = $request->input('color');
        $servingTrolleys->status = $request->input('status');
        $servingTrolleys->editor = $this->getMyUserId();
        $servingTrolleys->save();

        return redirect()->route('ServingTrolleys.index')->with('success', 'ترولی پذیرایی با موفقیت ویرایش شد.');
    }
}
