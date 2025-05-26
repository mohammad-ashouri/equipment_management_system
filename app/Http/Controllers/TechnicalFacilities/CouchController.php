<?php

namespace App\Http\Controllers\TechnicalFacilities;

use App\Http\Controllers\Controller;
use App\Models\TechnicalFacilities\Couch;
use Illuminate\Http\Request;

class CouchController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست مبلمان', ['only' => ['index']]);
        $this->middleware('permission:ایجاد مبلمان', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش مبلمان', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف مبلمان', ['only' => ['destroy']]);
    }

    public function index()
    {
        $couches = Couch::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('TechnicalFacilities.Couches.index', compact('couches'));
    }

    public function create()
    {
        return view('TechnicalFacilities.Couches.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'color' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $couches = Couch::create([
            'model' => $request->input('model'),
            'brand' => $request->input('brand'),
            'color' => $request->input('color'),
            'adder' => $this->getMyUserId()
        ]);

        if ($couches) {
            return redirect()->route('Couches.index')->with('success', 'مبلمان با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد مبلمان']);
    }

    public function edit($id)
    {
        $couch = Couch::findOrFail($id);

        return view('TechnicalFacilities.Couches.edit', compact('couch'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:couches,id',
            'model' => 'required|string',
            'color' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $couches = Couch::findOrFail($id);
        $couches->brand = $request->input('brand');
        $couches->model = $request->input('model');
        $couches->color = $request->input('color');
        $couches->status = $request->input('status');
        $couches->editor = $this->getMyUserId();
        $couches->save();

        return redirect()->route('Couches.index')->with('success', 'مبلمان با موفقیت ویرایش شد.');
    }
}
