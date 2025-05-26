<?php

namespace App\Http\Controllers\TechnicalFacilities;

use App\Http\Controllers\Controller;
use App\Models\TechnicalFacilities\IranianCooler;
use Illuminate\Http\Request;

class IranianCoolerController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست کولر آبی', ['only' => ['index']]);
        $this->middleware('permission:ایجاد کولر آبی', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش کولر آبی', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف کولر آبی', ['only' => ['destroy']]);
    }

    public function index()
    {
        $iranianCoolers = IranianCooler::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('TechnicalFacilities.IranianCoolers.index', compact('iranianCoolers'));
    }

    public function create()
    {
        return view('TechnicalFacilities.IranianCoolers.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'type' => 'required|string',
            'capacity' => 'required|integer',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $iranianCoolers = IranianCooler::create([
            'model' => $request->input('model'),
            'brand' => $request->input('brand'),
            'type' => $request->input('type'),
            'capacity' => $request->input('capacity'),
            'adder' => $this->getMyUserId()
        ]);

        if ($iranianCoolers) {
            return redirect()->route('IranianCoolers.index')->with('success', 'کولر آبی با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد کولر آبی']);
    }

    public function edit($id)
    {
        $iranianCooler = IranianCooler::findOrFail($id);

        return view('TechnicalFacilities.IranianCoolers.edit', compact('iranianCooler'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:iranian_coolers,id',
            'model' => 'required|string',
            'type' => 'required|string',
            'capacity' => 'required|integer',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $iranianCoolers = IranianCooler::findOrFail($id);
        $iranianCoolers->brand = $request->input('brand');
        $iranianCoolers->model = $request->input('model');
        $iranianCoolers->type = $request->input('type');
        $iranianCoolers->capacity = $request->input('capacity');
        $iranianCoolers->status = $request->input('status');
        $iranianCoolers->editor = $this->getMyUserId();
        $iranianCoolers->save();

        return redirect()->route('IranianCoolers.index')->with('success', 'کولر آبی با موفقیت ویرایش شد.');
    }
}
