<?php

namespace App\Http\Controllers\TechnicalFacilities;

use App\Http\Controllers\Controller;
use App\Models\TechnicalFacilities\Samovar;
use Illuminate\Http\Request;

class SamovarController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:لیست سماور', ['only' => ['index']]);
        $this->middleware('permission:ایجاد سماور', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش سماور', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف سماور', ['only' => ['destroy']]);
    }

    public function index()
    {
        $samovars = Samovar::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('TechnicalFacilities.Samovars.index', compact('samovars'));
    }

    public function create()
    {
        return view('TechnicalFacilities.Samovars.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'type' => 'required|string',
            'liter_capacity' => 'required|integer',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $samovars = Samovar::create(['model' => $request->input('model'), 'brand' => $request->input('brand'), 'type' => $request->input('type'), 'liter_capacity' => $request->input('liter_capacity'), 'adder' => $this->getMyUserId()]);

        if ($samovars) {
            return redirect()->route('Samovars.index')->with('success', 'سماور با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد سماور']);
    }

    public function edit($id)
    {
        $samovar = Samovar::findOrFail($id);

        return view('TechnicalFacilities.Samovars.edit', compact('samovar'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:samovars,id',
            'model' => 'required|string',
            'type' => 'required|string',
            'liter_capacity' => 'required|integer',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $samovars = Samovar::findOrFail($id);
        $samovars->brand = $request->input('brand');
        $samovars->model = $request->input('model');
        $samovars->type = $request->input('type');
        $samovars->liter_capacity = $request->input('liter_capacity');
        $samovars->status = $request->input('status');
        $samovars->editor = $this->getMyUserId();
        $samovars->save();

        return redirect()->route('Samovars.index')->with('success', 'سماور با موفقیت ویرایش شد.');
    }
}
