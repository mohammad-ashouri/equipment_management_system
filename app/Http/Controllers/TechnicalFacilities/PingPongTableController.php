<?php

namespace App\Http\Controllers\TechnicalFacilities;

use App\Http\Controllers\Controller;
use App\Models\TechnicalFacilities\PingPongTable;
use Illuminate\Http\Request;

class PingPongTableController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست میز پینگ پنگ', ['only' => ['index']]);
        $this->middleware('permission:ایجاد میز پینگ پنگ', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش میز پینگ پنگ', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف میز پینگ پنگ', ['only' => ['destroy']]);
    }

    public function index()
    {
        $pingPongTables = PingPongTable::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('TechnicalFacilities.PingPongTables.index', compact('pingPongTables'));
    }

    public function create()
    {
        return view('TechnicalFacilities.PingPongTables.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'material' => 'required|string',
            'type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $pingPongTable = PingPongTable::create([
            'model' => $request->input('model'),
            'material' => $request->input('material'),
            'type' => $request->input('type'),
            'brand' => $request->input('brand'),
            'adder' => $this->getMyUserId()
        ]);

        if ($pingPongTable) {
            return redirect()->route('PingPongTables.index')->with('success', 'میز پینگ پنگ با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد میز پینگ پنگ']);
    }

    public function edit($id)
    {
        $pingPongTable = PingPongTable::findOrFail($id);

        return view('TechnicalFacilities.PingPongTables.edit', compact('pingPongTable'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:ping_pong_tables,id',
            'model' => 'required|string',
            'material' => 'required|string',
            'type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $pingPongTable = PingPongTable::findOrFail($id);
        $pingPongTable->brand = $request->input('brand');
        $pingPongTable->model = $request->input('model');
        $pingPongTable->material = $request->input('material');
        $pingPongTable->type = $request->input('type');
        $pingPongTable->status = $request->input('status');
        $pingPongTable->editor = $this->getMyUserId();
        $pingPongTable->save();

        return redirect()->route('PingPongTables.index')->with('success', 'میز پینگ پنگ با موفقیت ویرایش شد.');
    }
}
