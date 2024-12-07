<?php

namespace App\Http\Controllers\TechnicalFacilities;

use App\Http\Controllers\Controller;
use App\Models\TechnicalFacilities\PaperCutter;
use Illuminate\Http\Request;

class PaperCutterController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست برش دهنده کاغذ', ['only' => ['index']]);
        $this->middleware('permission:ایجاد برش دهنده کاغذ', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش برش دهنده کاغذ', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف برش دهنده کاغذ', ['only' => ['destroy']]);
    }

    public function index()
    {
        $paperCutters = PaperCutter::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('TechnicalFacilities.PaperCutters.index', compact('paperCutters'));
    }

    public function create()
    {
        return view('TechnicalFacilities.PaperCutters.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $paperCutters = PaperCutter::create(['model' => $request->input('model'), 'brand' => $request->input('brand'), 'type' => $request->input('type'), 'adder' => $this->getMyUserId()]);

        if ($paperCutters) {
            return redirect()->route('PaperCutters.index')->with('success', 'برش دهنده کاغذ با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد برش دهنده کاغذ']);
    }

    public function edit($id)
    {
        $paperCutter = PaperCutter::findOrFail($id);

        return view('TechnicalFacilities.PaperCutters.edit', compact('paperCutter'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:paper_cutters,id',
            'model' => 'required|string',
            'type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $paperCutters = PaperCutter::findOrFail($id);
        $paperCutters->brand = $request->input('brand');
        $paperCutters->model = $request->input('model');
        $paperCutters->type = $request->input('type');
        $paperCutters->status = $request->input('status');
        $paperCutters->editor = $this->getMyUserId();
        $paperCutters->save();

        return redirect()->route('PaperCutters.index')->with('success', 'برش دهنده کاغذ با موفقیت ویرایش شد.');
    }
}
