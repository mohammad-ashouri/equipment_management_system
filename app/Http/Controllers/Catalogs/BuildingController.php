<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\Building;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست ساختمان', ['only' => ['index']]);
        $this->middleware('permission:ایجاد ساختمان', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش ساختمان', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف ساختمان', ['only' => ['destroy']]);
    }

    public function index()
    {
        $buildings = building::orderBy('name', 'asc')->get();
        return view('Catalogs.Buildings.index', compact('buildings'));
    }

    public function create()
    {
        return view('Catalogs.Buildings.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:buildings,name',
        ]);

        $building = building::create(['name' => $request->input('name'), 'adder' => $this->getMyUserId()]);

        if ($building) {
            return redirect()->route('Buildings.index')->with('success', 'ساختمان با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد ساختمان']);
    }

    public function edit($id)
    {
        $building = building::findOrFail($id);

        return view('Catalogs.Buildings.edit', compact('building'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:buildings,id',
        ]);

        $building = building::findOrFail($id);
        $building->name = $request->input('name');
        $building->status = $request->input('status');
        $building->editor = $this->getMyUserId();
        $building->save();

        return redirect()->route('Buildings.index')->with('success', 'ساختمان با موفقیت ویرایش شد.');
    }
}
