<?php

namespace App\Http\Controllers\TechnicalFacilities;

use App\Http\Controllers\Controller;
use App\Models\TechnicalFacilities\WaterPurifier;
use Illuminate\Http\Request;

class WaterPurifierController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:لیست تصفیه کننده آب', ['only' => ['index']]);
        $this->middleware('permission:ایجاد تصفیه کننده آب', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش تصفیه کننده آب', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف تصفیه کننده آب', ['only' => ['destroy']]);
    }

    public function index()
    {
        $waterPurifiers = WaterPurifier::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('TechnicalFacilities.WaterPurifiers.index', compact('waterPurifiers'));
    }

    public function create()
    {
        return view('TechnicalFacilities.WaterPurifiers.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $waterPurifiers = WaterPurifier::create(['model' => $request->input('model'), 'brand' => $request->input('brand'), 'type' => $request->input('type'), 'adder' => $this->getMyUserId()]);

        if ($waterPurifiers) {
            return redirect()->route('WaterPurifiers.index')->with('success', 'تصفیه کننده آب با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد تصفیه کننده آب']);
    }

    public function edit($id)
    {
        $waterPurifier = WaterPurifier::findOrFail($id);

        return view('TechnicalFacilities.WaterPurifiers.edit', compact('waterPurifier'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:water_purifiers,id',
            'model' => 'required|string',
            'type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $waterPurifiers = WaterPurifier::findOrFail($id);
        $waterPurifiers->brand = $request->input('brand');
        $waterPurifiers->model = $request->input('model');
        $waterPurifiers->type = $request->input('type');
        $waterPurifiers->status = $request->input('status');
        $waterPurifiers->editor = $this->getMyUserId();
        $waterPurifiers->save();

        return redirect()->route('WaterPurifiers.index')->with('success', 'تصفیه کننده آب با موفقیت ویرایش شد.');
    }
}
