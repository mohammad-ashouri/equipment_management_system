<?php

namespace App\Http\Controllers\TechnicalFacilities;

use App\Http\Controllers\Controller;
use App\Models\TechnicalFacilities\ShoeCabinet;
use Illuminate\Http\Request;

class ShoeCabinetController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست جاکفشی', ['only' => ['index']]);
        $this->middleware('permission:ایجاد جاکفشی', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش جاکفشی', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف جاکفشی', ['only' => ['destroy']]);
    }

    public function index()
    {
        $shoeCabinets = ShoeCabinet::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('TechnicalFacilities.ShoeCabinets.index', compact('shoeCabinets'));
    }

    public function create()
    {
        return view('TechnicalFacilities.ShoeCabinets.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'color' => 'required|string',
            'doors_number' => 'required|string',
            'floors_number' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $shoeCabinets = ShoeCabinet::create([
            'model' => $request->input('model'),
            'brand' => $request->input('brand'),
            'color' => $request->input('color'),
            'doors_number' => $request->input('doors_number'),
            'floors_number' => $request->input('floors_number'),
            'adder' => $this->getMyUserId()
        ]);

        if ($shoeCabinets) {
            return redirect()->route('ShoeCabinets.index')->with('success', 'جاکفشی با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد جاکفشی']);
    }

    public function edit($id)
    {
        $shoeCabinet = ShoeCabinet::findOrFail($id);

        return view('TechnicalFacilities.ShoeCabinets.edit', compact('shoeCabinet'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:shoe_cabinet,id',
            'model' => 'required|string',
            'color' => 'required|string',
            'doors_number' => 'required|string',
            'floors_number' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $shoeCabinets = ShoeCabinet::findOrFail($id);
        $shoeCabinets->brand = $request->input('brand');
        $shoeCabinets->model = $request->input('model');
        $shoeCabinets->color = $request->input('color');
        $shoeCabinets->doors_number = $request->input('doors_number');
        $shoeCabinets->floors_number = $request->input('floors_number');
        $shoeCabinets->status = $request->input('status');
        $shoeCabinets->editor = $this->getMyUserId();
        $shoeCabinets->save();

        return redirect()->route('ShoeCabinets.index')->with('success', 'جاکفشی با موفقیت ویرایش شد.');
    }
}
