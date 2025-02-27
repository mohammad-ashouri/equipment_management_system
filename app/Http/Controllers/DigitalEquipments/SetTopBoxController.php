<?php

namespace App\Http\Controllers\DigitalEquipments;

use App\Http\Controllers\Controller;
use App\Models\DigitalEquipments\SetTopBox;
use Illuminate\Http\Request;

class SetTopBoxController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست گیرنده دیجیتال', ['only' => ['index']]);
        $this->middleware('permission:ایجاد گیرنده دیجیتال', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش گیرنده دیجیتال', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف گیرنده دیجیتال', ['only' => ['destroy']]);
    }

    public function index()
    {
        $setTopBoxes = SetTopBox::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('DigitalEquipments.SetTopBoxes.index', compact('setTopBoxes'));
    }

    public function create()
    {
        return view('DigitalEquipments.SetTopBoxes.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $setTopBoxs = SetTopBox::create([
            'model' => $request->input('model'),
            'brand' => $request->input('brand'),
            'adder' => $this->getMyUserId()]);

        if ($setTopBoxs) {
            return redirect()->route('SetTopBoxes.index')->with('success', 'گیرنده دیجیتال با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد گیرنده دیجیتال']);
    }

    public function edit($id)
    {
        $setTopBox = SetTopBox::findOrFail($id);

        return view('DigitalEquipments.SetTopBoxes.edit', compact('setTopBox'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'model' => 'required|string',
            'id' => 'required|integer|exists:set_top_boxes,id',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $setTopBox = SetTopBox::findOrFail($id);
        $setTopBox->brand = $request->input('brand');
        $setTopBox->model = $request->input('model');
        $setTopBox->status = $request->input('status');
        $setTopBox->editor = $this->getMyUserId();
        $setTopBox->save();

        return redirect()->route('SetTopBoxes.index')->with('success', 'گیرنده دیجیتال با موفقیت ویرایش شد.');
    }
}
