<?php

namespace App\Http\Controllers\TechnicalFacilities;

use App\Http\Controllers\Controller;
use App\Models\TechnicalFacilities\SuggestionBox;
use Illuminate\Http\Request;

class SuggestionBoxController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست صندوق پیشنهادات', ['only' => ['index']]);
        $this->middleware('permission:ایجاد صندوق پیشنهادات', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش صندوق پیشنهادات', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف صندوق پیشنهادات', ['only' => ['destroy']]);
    }

    public function index()
    {
        $suggestionBoxes = SuggestionBox::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('TechnicalFacilities.SuggestionBoxes.index', compact('suggestionBoxes'));
    }

    public function create()
    {
        return view('TechnicalFacilities.SuggestionBoxes.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'material' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $suggestionBox = SuggestionBox::create(['model' => $request->input('model'), 'brand' => $request->input('brand'), 'material' => $request->input('material'), 'adder' => $this->getMyUserId()]);

        if ($suggestionBox) {
            return redirect()->route('SuggestionBoxes.index')->with('success', 'صندوق پیشنهادات با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد صندوق پیشنهادات']);
    }

    public function edit($id)
    {
        $suggestionBox = SuggestionBox::findOrFail($id);

        return view('TechnicalFacilities.SuggestionBoxes.edit', compact('suggestionBox'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:suggestion_boxes,id',
            'model' => 'required|string',
            'material' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $suggestionBox = SuggestionBox::findOrFail($id);
        $suggestionBox->brand = $request->input('brand');
        $suggestionBox->model = $request->input('model');
        $suggestionBox->material = $request->input('material');
        $suggestionBox->status = $request->input('status');
        $suggestionBox->editor = $this->getMyUserId();
        $suggestionBox->save();

        return redirect()->route('SuggestionBoxes.index')->with('success', 'صندوق پیشنهادات با موفقیت ویرایش شد.');
    }
}
