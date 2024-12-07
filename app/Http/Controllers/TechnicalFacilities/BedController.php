<?php

namespace App\Http\Controllers\TechnicalFacilities;

use App\Http\Controllers\Controller;
use App\Models\TechnicalFacilities\Bed;
use Illuminate\Http\Request;

class BedController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست تخت خواب', ['only' => ['index']]);
        $this->middleware('permission:ایجاد تخت خواب', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش تخت خواب', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف تخت خواب', ['only' => ['destroy']]);
    }

    public function index()
    {
        $beds = Bed::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('TechnicalFacilities.Beds.index', compact('beds'));
    }

    public function create()
    {
        return view('TechnicalFacilities.Beds.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'material' => 'required|string',
            'capacity' => 'required|integer',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $beds = Bed::create([
            'model' => $request->input('model'),
            'brand' => $request->input('brand'),
            'material' => $request->input('material'),
            'capacity' => $request->input('capacity'),
            'adder' => $this->getMyUserId()
        ]);

        if ($beds) {
            return redirect()->route('Beds.index')->with('success', 'تخت خواب با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد تخت خواب']);
    }

    public function edit($id)
    {
        $bed = Bed::findOrFail($id);

        return view('TechnicalFacilities.Beds.edit', compact('bed'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:beds,id',
            'model' => 'required|string',
            'material' => 'required|string',
            'capacity' => 'required|integer',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $beds = Bed::findOrFail($id);
        $beds->brand = $request->input('brand');
        $beds->model = $request->input('model');
        $beds->material = $request->input('material');
        $beds->capacity = $request->input('capacity');
        $beds->status = $request->input('status');
        $beds->editor = $this->getMyUserId();
        $beds->save();

        return redirect()->route('Beds.index')->with('success', 'تخت خواب با موفقیت ویرایش شد.');
    }
}
