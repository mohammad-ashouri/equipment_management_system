<?php

namespace App\Http\Controllers\TechnicalFacilities;

use App\Http\Controllers\Controller;
use App\Models\TechnicalFacilities\Bracket;
use Illuminate\Http\Request;

class BracketController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست براکت', ['only' => ['index']]);
        $this->middleware('permission:ایجاد براکت', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش براکت', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف براکت', ['only' => ['destroy']]);
    }

    public function index()
    {
        $brackets = Bracket::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('TechnicalFacilities.Brackets.index', compact('brackets'));
    }

    public function create()
    {
        return view('TechnicalFacilities.Brackets.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'suitable_for' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $brackets = Bracket::create([
            'model' => $request->input('model'),
            'brand' => $request->input('brand'),
            'suitable_for' => $request->input('suitable_for'),
            'adder' => $this->getMyUserId()
        ]);

        if ($brackets) {
            return redirect()->route('Brackets.index')->with('success', 'براکت با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد براکت']);
    }

    public function edit($id)
    {
        $bracket = Bracket::findOrFail($id);

        return view('TechnicalFacilities.Brackets.edit', compact('bracket'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:brackets,id',
            'model' => 'required|string',
            'suitable_for' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $bracket = Bracket::findOrFail($id);
        $bracket->brand = $request->input('brand');
        $bracket->model = $request->input('model');
        $bracket->suitable_for = $request->input('suitable_for');
        $bracket->status = $request->input('status');
        $bracket->editor = $this->getMyUserId();
        $bracket->save();

        return redirect()->route('Brackets.index')->with('success', 'براکت با موفقیت ویرایش شد.');
    }
}
