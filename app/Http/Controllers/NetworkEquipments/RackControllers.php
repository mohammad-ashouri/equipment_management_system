<?php

namespace App\Http\Controllers\NetworkEquipments;

use App\Http\Controllers\Controller;
use App\Models\NetworkEquipments\Rack;
use Illuminate\Http\Request;

class RackControllers extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست رک', ['only' => ['index']]);
        $this->middleware('permission:ایجاد رک', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش رک', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف رک', ['only' => ['destroy']]);
    }

    public function index()
    {
        $racks = Rack::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->paginate(50);
        return view('NetworkEquipments.Racks.index', compact('racks'));
    }

    public function create()
    {
        return view('NetworkEquipments.Racks.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
            'units_number' => 'required|integer',
            'type' => 'required|string',
        ]);

        $rack = Rack::create([
            'model' => $request->input('model'),
            'units_number' => $request->input('units_number'),
            'type' => $request->input('type'),
            'brand' => $request->input('brand'),
            'adder' => $this->getMyUserId()
        ]);

        if ($rack) {
            return redirect()->route('Racks.index')->with('success', 'رک با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد رک']);
    }

    public function edit($id)
    {
        $rack = Rack::findOrFail($id);

        return view('NetworkEquipments.Racks.edit', compact('rack'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:racks,id',
            'model' => 'required|string',
            'units_number' => 'required|integer',
            'type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $rack = Rack::findOrFail($id);
        $rack->brand = $request->input('brand');
        $rack->model = $request->input('model');
        $rack->status = $request->input('status');
        $rack->units_number = $request->input('units_number');
        $rack->type = $request->input('type');
        $rack->editor = $this->getMyUserId();
        $rack->save();

        return redirect()->route('Racks.index')->with('success', 'رک با موفقیت ویرایش شد.');
    }
}
