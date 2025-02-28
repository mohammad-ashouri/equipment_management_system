<?php

namespace App\Http\Controllers\DigitalEquipments;

use App\Http\Controllers\Controller;
use App\Models\DigitalEquipments\Light;
use Illuminate\Http\Request;

class LightController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست نور', ['only' => ['index']]);
        $this->middleware('permission:ایجاد نور', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش نور', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف نور', ['only' => ['destroy']]);
    }

    public function index()
    {
        $lights = Light::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('DigitalEquipments.Lights.index', compact('lights'));
    }

    public function create()
    {
        return view('DigitalEquipments.Lights.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $light = Light::create([
            'model' => $request->input('model'),
            'brand' => $request->input('brand'),
            'adder' => $this->getMyUserId()
        ]);

        if ($light) {
            return redirect()->route('Lights.index')->with('success', 'نور با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد نور']);
    }

    public function edit($id)
    {
        $light = Light::findOrFail($id);

        return view('DigitalEquipments.Lights.edit', compact('light'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:light_holders,id',
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $light = Light::findOrFail($id);
        $light->brand = $request->input('brand');
        $light->model = $request->input('model');
        $light->status = $request->input('status');
        $light->editor = $this->getMyUserId();
        $light->save();

        return redirect()->route('Lights.index')->with('success', 'نور با موفقیت ویرایش شد.');
    }
}
