<?php

namespace App\Http\Controllers\TechnicalFacilities;

use App\Http\Controllers\Controller;
use App\Models\TechnicalFacilities\Oven;
use Illuminate\Http\Request;

class OvenController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست کاغذ خردکن', ['only' => ['index']]);
        $this->middleware('permission:ایجاد کاغذ خردکن', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش کاغذ خردکن', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف کاغذ خردکن', ['only' => ['destroy']]);
    }

    public function index()
    {
        $ovens = Oven::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('TechnicalFacilities.Ovens.index', compact('ovens'));
    }

    public function create()
    {
        return view('TechnicalFacilities.Ovens.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'type' => 'required|string',
            'flames_number' => 'required|integer',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $ovens = Oven::create(['model' => $request->input('model'), 'brand' => $request->input('brand'), 'type' => $request->input('type'), 'flames_number' => $request->input('flames_number'), 'adder' => $this->getMyUserId()]);

        if ($ovens) {
            return redirect()->route('Ovens.index')->with('success', 'کاغذ خردکن با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد کاغذ خردکن']);
    }

    public function edit($id)
    {
        $oven = Oven::findOrFail($id);

        return view('TechnicalFacilities.Ovens.edit', compact('oven'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:ovens,id',
            'model' => 'required|string',
            'type' => 'required|string',
            'flames_number' => 'required|integer',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $ovens = Oven::findOrFail($id);
        $ovens->brand = $request->input('brand');
        $ovens->model = $request->input('model');
        $ovens->type = $request->input('type');
        $ovens->flames_number = $request->input('flames_number');
        $ovens->status = $request->input('status');
        $ovens->editor = $this->getMyUserId();
        $ovens->save();

        return redirect()->route('Ovens.index')->with('success', 'کاغذ خردکن با موفقیت ویرایش شد.');
    }
}
