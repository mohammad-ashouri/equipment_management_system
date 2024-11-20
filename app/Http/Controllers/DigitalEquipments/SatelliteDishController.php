<?php

namespace App\Http\Controllers\DigitalEquipments;

use App\Http\Controllers\Controller;
use App\Models\DigitalEquipments\SatelliteDish;
use Illuminate\Http\Request;

class SatelliteDishController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست دیش ماهواره', ['only' => ['index']]);
        $this->middleware('permission:ایجاد دیش ماهواره', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش دیش ماهواره', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف دیش ماهواره', ['only' => ['destroy']]);
    }

    public function index()
    {
        $satelliteDishes = SatelliteDish::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('DigitalEquipments.SatelliteDishes.index', compact('satelliteDishes'));
    }

    public function create()
    {
        return view('DigitalEquipments.SatelliteDishes.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $satelliteDish = SatelliteDish::create([
            'model' => $request->input('model'),
            'brand' => $request->input('brand'),
            'adder' => $this->getMyUserId()
        ]);

        if ($satelliteDish) {
            return redirect()->route('SatelliteDishes.index')->with('success', 'دیش ماهواره با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد دیش ماهواره']);
    }

    public function edit($id)
    {
        $satelliteDish = SatelliteDish::findOrFail($id);

        return view('DigitalEquipments.SatelliteDishes.edit', compact('satelliteDish'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:satellite_dishes,id',
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $satelliteDish = SatelliteDish::findOrFail($id);
        $satelliteDish->brand = $request->input('brand');
        $satelliteDish->model = $request->input('model');
        $satelliteDish->status = $request->input('status');
        $satelliteDish->editor = $this->getMyUserId();
        $satelliteDish->save();

        return redirect()->route('SatelliteDishes.index')->with('success', 'دیش ماهواره با موفقیت ویرایش شد.');
    }
}
