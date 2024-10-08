<?php

namespace App\Http\Controllers\TechnicalFacilities;

use App\Http\Controllers\Controller;
use App\Models\TechnicalFacilities\Chair;
use Illuminate\Http\Request;

class ChairController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست صندلی', ['only' => ['index']]);
        $this->middleware('permission:ایجاد صندلی', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش صندلی', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف صندلی', ['only' => ['destroy']]);
    }

    public function index()
    {
        $chairs = Chair::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->paginate(50);
        return view('TechnicalFacilities.Chairs.index', compact('chairs'));
    }

    public function create()
    {
        return view('TechnicalFacilities.Chairs.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'material' => 'required|string',
            'desktop_type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $chairs = Chair::create(['model' => $request->input('model'), 'brand' => $request->input('brand'), 'material' => $request->input('material'), 'desktop_type' => $request->input('desktop_type'), 'adder' => $this->getMyUserId()]);

        if ($chairs) {
            return redirect()->route('Chairs.index')->with('success', 'صندلی با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد صندلی']);
    }

    public function edit($id)
    {
        $chair = Chair::findOrFail($id);

        return view('TechnicalFacilities.Chairs.edit', compact('chair'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:chairs,id',
            'model' => 'required|string',
            'material' => 'required|string',
            'desktop_type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $chairs = Chair::findOrFail($id);
        $chairs->brand = $request->input('brand');
        $chairs->model = $request->input('model');
        $chairs->material = $request->input('material');
        $chairs->desktop_type = $request->input('desktop_type');
        $chairs->status = $request->input('status');
        $chairs->editor = $this->getMyUserId();
        $chairs->save();

        return redirect()->route('Chairs.index')->with('success', 'صندلی با موفقیت ویرایش شد.');
    }
}
