<?php

namespace App\Http\Controllers\DigitalEquipments;

use App\Http\Controllers\Controller;
use App\Models\DigitalEquipments\Ups;
use Illuminate\Http\Request;

class UpsController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:لیست ups', ['only' => ['index']]);
        $this->middleware('permission:ایجاد ups', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش ups', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف ups', ['only' => ['destroy']]);
    }

    public function index()
    {
        $ups = Ups::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->paginate(50);
        return view('DigitalEquipments.Ups.index', compact('ups'));
    }

    public function create()
    {
        return view('DigitalEquipments.Ups.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'capacity' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $ups = Ups::create(['model' => $request->input('model'), 'brand' => $request->input('brand'), 'capacity' => $request->input('capacity'), 'adder' => $this->getMyUserId()]);

        if ($ups) {
            return redirect()->route('Ups.index')->with('success', 'ups با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد ups']);
    }

    public function edit($id)
    {
        $ups = Ups::findOrFail($id);

        return view('DigitalEquipments.Ups.edit', compact('ups'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:ups,id',
            'model' => 'required|string',
            'capacity' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $ups = Ups::findOrFail($id);
        $ups->brand = $request->input('brand');
        $ups->model = $request->input('model');
        $ups->capacity = $request->input('capacity');
        $ups->status = $request->input('status');
        $ups->editor = $this->getMyUserId();
        $ups->save();

        return redirect()->route('Ups.index')->with('success', 'ups با موفقیت ویرایش شد.');
    }
}
