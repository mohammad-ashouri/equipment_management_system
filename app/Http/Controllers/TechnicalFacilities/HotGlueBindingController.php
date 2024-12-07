<?php

namespace App\Http\Controllers\TechnicalFacilities;

use App\Http\Controllers\Controller;
use App\Models\TechnicalFacilities\HotGlueBinding;
use Illuminate\Http\Request;

class HotGlueBindingController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست فنرزن کاغذ', ['only' => ['index']]);
        $this->middleware('permission:ایجاد فنرزن کاغذ', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش فنرزن کاغذ', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف فنرزن کاغذ', ['only' => ['destroy']]);
    }

    public function index()
    {
        $hotGlueBindings = HotGlueBinding::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('TechnicalFacilities.HotGlueBindings.index', compact('hotGlueBindings'));
    }

    public function create()
    {
        return view('TechnicalFacilities.HotGlueBindings.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $hotGlueBindings = HotGlueBinding::create(['model' => $request->input('model'), 'brand' => $request->input('brand'), 'type' => $request->input('type'), 'adder' => $this->getMyUserId()]);

        if ($hotGlueBindings) {
            return redirect()->route('HotGlueBindings.index')->with('success', 'فنرزن کاغذ با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد فنرزن کاغذ']);
    }

    public function edit($id)
    {
        $hotGlueBinding = HotGlueBinding::findOrFail($id);

        return view('TechnicalFacilities.HotGlueBindings.edit', compact('hotGlueBinding'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:hot_glue_bindings,id',
            'model' => 'required|string',
            'type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $hotGlueBindings = HotGlueBinding::findOrFail($id);
        $hotGlueBindings->brand = $request->input('brand');
        $hotGlueBindings->model = $request->input('model');
        $hotGlueBindings->type = $request->input('type');
        $hotGlueBindings->status = $request->input('status');
        $hotGlueBindings->editor = $this->getMyUserId();
        $hotGlueBindings->save();

        return redirect()->route('HotGlueBindings.index')->with('success', 'فنرزن کاغذ با موفقیت ویرایش شد.');
    }
}
