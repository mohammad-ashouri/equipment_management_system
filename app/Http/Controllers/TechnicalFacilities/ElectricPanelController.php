<?php

namespace App\Http\Controllers\TechnicalFacilities;

use App\Http\Controllers\Controller;
use App\Models\TechnicalFacilities\ElectricPanel;
use Illuminate\Http\Request;

class ElectricPanelController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست تابلو برق', ['only' => ['index']]);
        $this->middleware('permission:ایجاد تابلو برق', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش تابلو برق', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف تابلو برق', ['only' => ['destroy']]);
    }

    public function index()
    {
        $electricPanels = ElectricPanel::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('TechnicalFacilities.ElectricPanels.index', compact('electricPanels'));
    }

    public function create()
    {
        return view('TechnicalFacilities.ElectricPanels.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'type' => 'required|string',
            'material' => 'required|string',
            'mode' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $electricPanels = ElectricPanel::create([
            'model' => $request->input('model'),
            'brand' => $request->input('brand'),
            'type' => $request->input('type'),
            'material' => $request->input('material'),
            'mode' => $request->input('mode'),
            'adder' => $this->getMyUserId()
        ]);

        if ($electricPanels) {
            return redirect()->route('ElectricPanels.index')->with('success', 'تابلو برق با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد تابلو برق']);
    }

    public function edit($id)
    {
        $electricPanel = ElectricPanel::findOrFail($id);

        return view('TechnicalFacilities.ElectricPanels.edit', compact('electricPanel'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:electric_panels,id',
            'model' => 'required|string',
            'type' => 'required|string',
            'material' => 'required|string',
            'mode' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $electricPanel = ElectricPanel::findOrFail($id);
        $electricPanel->brand = $request->input('brand');
        $electricPanel->model = $request->input('model');
        $electricPanel->type = $request->input('type');
        $electricPanel->material = $request->input('material');
        $electricPanel->mode = $request->input('mode');
        $electricPanel->status = $request->input('status');
        $electricPanel->editor = $this->getMyUserId();
        $electricPanel->save();

        return redirect()->route('ElectricPanels.index')->with('success', 'تابلو برق با موفقیت ویرایش شد.');
    }
}
