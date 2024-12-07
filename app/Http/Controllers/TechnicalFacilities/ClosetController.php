<?php

namespace App\Http\Controllers\TechnicalFacilities;

use App\Http\Controllers\Controller;
use App\Models\TechnicalFacilities\Closet;
use Illuminate\Http\Request;

class ClosetController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست کمد', ['only' => ['index']]);
        $this->middleware('permission:ایجاد کمد', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش کمد', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف کمد', ['only' => ['destroy']]);
    }

    public function index()
    {
        $closets = Closet::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('TechnicalFacilities.Closets.index', compact('closets'));
    }

    public function create()
    {
        return view('TechnicalFacilities.Closets.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'material' => 'required|string',
            'floors_number' => 'required|integer',
            'doors_number' => 'required|integer',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $closets = Closet::create([
            'model' => $request->input('model'),
            'brand' => $request->input('brand'),
            'material' => $request->input('material'),
            'floors_number' => $request->input('floors_number'),
            'doors_number' => $request->input('doors_number'),
            'adder' => $this->getMyUserId()
        ]);

        if ($closets) {
            return redirect()->route('Closets.index')->with('success', 'کمد با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد کمد']);
    }

    public function edit($id)
    {
        $closet = Closet::findOrFail($id);

        return view('TechnicalFacilities.Closets.edit', compact('closet'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:closets,id',
            'model' => 'required|string',
            'material' => 'required|string',
            'floors_number' => 'required|integer',
            'doors_number' => 'required|integer',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $closets = Closet::findOrFail($id);
        $closets->brand = $request->input('brand');
        $closets->model = $request->input('model');
        $closets->material = $request->input('material');
        $closets->floors_number = $request->input('floors_number');
        $closets->doors_number = $request->input('doors_number');
        $closets->status = $request->input('status');
        $closets->editor = $this->getMyUserId();
        $closets->save();

        return redirect()->route('Closets.index')->with('success', 'کمد با موفقیت ویرایش شد.');
    }
}
