<?php

namespace App\Http\Controllers\TechnicalFacilities;

use App\Http\Controllers\Controller;
use App\Models\TechnicalFacilities\VaccumCleaner;
use Illuminate\Http\Request;

class VaccumCleanerController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست جاروبرقی', ['only' => ['index']]);
        $this->middleware('permission:ایجاد جاروبرقی', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش جاروبرقی', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف جاروبرقی', ['only' => ['destroy']]);
    }

    public function index()
    {
        $vaccumCleaners = VaccumCleaner::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('TechnicalFacilities.VaccumCleaners.index', compact('vaccumCleaners'));
    }

    public function create()
    {
        return view('TechnicalFacilities.VaccumCleaners.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $vaccumCleaner = VaccumCleaner::create([
            'model' => $request->input('model'),
            'type' => $request->input('type'),
            'brand' => $request->input('brand'),
            'adder' => $this->getMyUserId()
        ]);

        if ($vaccumCleaner) {
            return redirect()->route('VaccumCleaners.index')->with('success', 'جاروبرقی با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد جاروبرقی']);
    }

    public function edit($id)
    {
        $vaccumCleaner = VaccumCleaner::findOrFail($id);

        return view('TechnicalFacilities.VaccumCleaners.edit', compact('vaccumCleaner'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:vaccum_cleaners,id',
            'model' => 'required|string',
            'type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $vaccumCleaner = VaccumCleaner::findOrFail($id);
        $vaccumCleaner->brand = $request->input('brand');
        $vaccumCleaner->model = $request->input('model');
        $vaccumCleaner->type = $request->input('type');
        $vaccumCleaner->status = $request->input('status');
        $vaccumCleaner->editor = $this->getMyUserId();
        $vaccumCleaner->save();

        return redirect()->route('VaccumCleaners.index')->with('success', 'جاروبرقی با موفقیت ویرایش شد.');
    }
}
