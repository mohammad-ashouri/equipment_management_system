<?php

namespace App\Http\Controllers\TechnicalFacilities;

use App\Http\Controllers\Controller;
use App\Models\TechnicalFacilities\TeaMaker;
use Illuminate\Http\Request;

class TeaMakerController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:لیست چای ساز', ['only' => ['index']]);
        $this->middleware('permission:ایجاد چای ساز', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش چای ساز', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف چای ساز', ['only' => ['destroy']]);
    }

    public function index()
    {
        $teaMakers = TeaMaker::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('TechnicalFacilities.TeaMakers.index', compact('teaMakers'));
    }

    public function create()
    {
        return view('TechnicalFacilities.TeaMakers.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $teaMakers = TeaMaker::create(['model' => $request->input('model'), 'brand' => $request->input('brand'), 'adder' => $this->getMyUserId()]);

        if ($teaMakers) {
            return redirect()->route('TeaMakers.index')->with('success', 'چای ساز با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد چای ساز']);
    }

    public function edit($id)
    {
        $teaMaker = TeaMaker::findOrFail($id);

        return view('TechnicalFacilities.TeaMakers.edit', compact('teaMaker'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:tea_makers,id',
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $teaMakers = TeaMaker::findOrFail($id);
        $teaMakers->brand = $request->input('brand');
        $teaMakers->model = $request->input('model');
        $teaMakers->status = $request->input('status');
        $teaMakers->editor = $this->getMyUserId();
        $teaMakers->save();

        return redirect()->route('TeaMakers.index')->with('success', 'چای ساز با موفقیت ویرایش شد.');
    }
}
