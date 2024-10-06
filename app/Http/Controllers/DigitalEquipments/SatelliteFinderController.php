<?php

namespace App\Http\Controllers\DigitalEquipments;

use App\Http\Controllers\Controller;
use App\Models\DigitalEquipments\SatelliteFinder;
use Illuminate\Http\Request;

class SatelliteFinderController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست فایندر ماهواره', ['only' => ['index']]);
        $this->middleware('permission:ایجاد فایندر ماهواره', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش فایندر ماهواره', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف فایندر ماهواره', ['only' => ['destroy']]);
    }

    public function index()
    {
        $satelliteFinders = SatelliteFinder::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->paginate(50);
        return view('DigitalEquipments.SatelliteFinders.index', compact('satelliteFinders'));
    }

    public function create()
    {
        return view('DigitalEquipments.SatelliteFinders.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
            'type' => 'required|string',
        ]);

        $satelliteFinder = SatelliteFinder::create([
            'model' => $request->input('model'),
            'type' => $request->input('type'),
            'brand' => $request->input('brand'),
            'adder' => $this->getMyUserId()
        ]);

        if ($satelliteFinder) {
            return redirect()->route('SatelliteFinders.index')->with('success', 'فایندر ماهواره با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد فایندر ماهواره']);
    }

    public function edit($id)
    {
        $satelliteFinder = SatelliteFinder::findOrFail($id);

        return view('DigitalEquipments.SatelliteFinders.edit', compact('satelliteFinder'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:satellite_finders,id',
            'model' => 'required|string',
            'type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $satelliteFinder = SatelliteFinder::findOrFail($id);
        $satelliteFinder->brand = $request->input('brand');
        $satelliteFinder->model = $request->input('model');
        $satelliteFinder->type = $request->input('type');
        $satelliteFinder->status = $request->input('status');
        $satelliteFinder->editor = $this->getMyUserId();
        $satelliteFinder->save();

        return redirect()->route('SatelliteFinders.index')->with('success', 'فایندر ماهواره با موفقیت ویرایش شد.');
    }
}
