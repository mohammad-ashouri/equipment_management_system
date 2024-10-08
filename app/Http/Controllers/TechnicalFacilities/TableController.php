<?php

namespace App\Http\Controllers\TechnicalFacilities;

use App\Http\Controllers\Controller;
use App\Models\TechnicalFacilities\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست میز', ['only' => ['index']]);
        $this->middleware('permission:ایجاد میز', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش میز', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف میز', ['only' => ['destroy']]);
    }

    public function index()
    {
        $tables = Table::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->paginate(50);
        return view('TechnicalFacilities.Tables.index', compact('tables'));
    }

    public function create()
    {
        return view('TechnicalFacilities.Tables.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'material' => 'required|string',
            'height' => 'required|integer',
            'width' => 'required|integer',
            'length' => 'required|integer',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $tables = Table::create(['model' => $request->input('model'), 'brand' => $request->input('brand'), 'material' => $request->input('material'), 'height' => $request->input('height'), 'width' => $request->input('width'), 'length' => $request->input('length'), 'adder' => $this->getMyUserId()]);

        if ($tables) {
            return redirect()->route('Tables.index')->with('success', 'میز با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد میز']);
    }

    public function edit($id)
    {
        $table = Table::findOrFail($id);

        return view('TechnicalFacilities.Tables.edit', compact('table'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:tables,id',
            'model' => 'required|string',
            'material' => 'required|string',
            'height' => 'required|integer',
            'width' => 'required|integer',
            'length' => 'required|integer',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $tables = Table::findOrFail($id);
        $tables->brand = $request->input('brand');
        $tables->model = $request->input('model');
        $tables->material = $request->input('material');
        $tables->height = $request->input('height');
        $tables->width = $request->input('width');
        $tables->length = $request->input('length');
        $tables->status = $request->input('status');
        $tables->editor = $this->getMyUserId();
        $tables->save();

        return redirect()->route('Tables.index')->with('success', 'میز با موفقیت ویرایش شد.');
    }
}
