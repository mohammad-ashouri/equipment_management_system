<?php

namespace App\Http\Controllers\TechnicalFacilities;

use App\Http\Controllers\Controller;
use App\Models\TechnicalFacilities\Television;
use Illuminate\Http\Request;

class TelevisionController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست تلوزیون', ['only' => ['index']]);
        $this->middleware('permission:ایجاد تلوزیون', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش تلوزیون', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف تلوزیون', ['only' => ['destroy']]);
    }

    public function index()
    {
        $televisions = Television::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('TechnicalFacilities.Televisions.index', compact('televisions'));
    }

    public function create()
    {
        return view('TechnicalFacilities.Televisions.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'size' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $television = Television::create(['model' => $request->input('model'), 'brand' => $request->input('brand'), 'size' => $request->input('size'), 'adder' => $this->getMyUserId()]);

        if ($television) {
            return redirect()->route('Televisions.index')->with('success', 'تلوزیون با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد تلوزیون']);
    }

    public function edit($id)
    {
        $television = Television::findOrFail($id);

        return view('TechnicalFacilities.Televisions.edit', compact('television'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:televisions,id',
            'model' => 'required|string',
            'size' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $television = Television::findOrFail($id);
        $television->brand = $request->input('brand');
        $television->model = $request->input('model');
        $television->size = $request->input('size');
        $television->status = $request->input('status');
        $television->editor = $this->getMyUserId();
        $television->save();

        return redirect()->route('Televisions.index')->with('success', 'تلوزیون با موفقیت ویرایش شد.');
    }
}
