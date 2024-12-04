<?php

namespace App\Http\Controllers\TechnicalFacilities;

use App\Http\Controllers\Controller;
use App\Models\TechnicalFacilities\CoatHanger;
use Illuminate\Http\Request;

class CoatHangerController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:لیست جالباسی', ['only' => ['index']]);
        $this->middleware('permission:ایجاد جالباسی', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش جالباسی', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف جالباسی', ['only' => ['destroy']]);
    }

    public function index()
    {
        $coatHangers = CoatHanger::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('TechnicalFacilities.CoatHangers.index', compact('coatHangers'));
    }

    public function create()
    {
        return view('TechnicalFacilities.CoatHangers.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'pendants_number' => 'required|integer',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $coatHanger = CoatHanger::create([
            'model' => $request->input('model'),
            'brand' => $request->input('brand'),
            'pendants_number' => $request->input('pendants_number'),
            'adder' => $this->getMyUserId()
        ]);

        if ($coatHanger) {
            return redirect()->route('CoatHangers.index')->with('success', 'جالباسی با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد جالباسی']);
    }

    public function edit($id)
    {
        $coatHanger = CoatHanger::findOrFail($id);

        return view('TechnicalFacilities.CoatHangers.edit', compact('coatHanger'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:coat_hangers,id',
            'model' => 'required|string',
            'pendants_number' => 'required|integer',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $coatHanger = CoatHanger::findOrFail($id);
        $coatHanger->brand = $request->input('brand');
        $coatHanger->model = $request->input('model');
        $coatHanger->pendants_number = $request->input('pendants_number');
        $coatHanger->status = $request->input('status');
        $coatHanger->editor = $this->getMyUserId();
        $coatHanger->save();

        return redirect()->route('CoatHangers.index')->with('success', 'جالباسی با موفقیت ویرایش شد.');
    }
}
