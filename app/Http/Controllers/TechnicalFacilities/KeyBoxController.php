<?php

namespace App\Http\Controllers\TechnicalFacilities;

use App\Http\Controllers\Controller;
use App\Models\TechnicalFacilities\KeyBox;
use Illuminate\Http\Request;

class KeyBoxController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست جعبه کلید', ['only' => ['index']]);
        $this->middleware('permission:ایجاد جعبه کلید', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش جعبه کلید', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف جعبه کلید', ['only' => ['destroy']]);
    }

    public function index()
    {
        $keyBoxes = KeyBox::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('TechnicalFacilities.KeyBoxes.index', compact('keyBoxes'));
    }

    public function create()
    {
        return view('TechnicalFacilities.KeyBoxes.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'color' => 'required|string',
            'material' => 'required|string',
            'door_number' => 'required|integer',
            'key_number' => 'required|integer',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $keyBox = KeyBox::create([
            'model' => $request->input('model'),
            'color' => $request->input('color'),
            'material' => $request->input('material'),
            'door_number' => $request->input('door_number'),
            'key_number' => $request->input('key_number'),
            'brand' => $request->input('brand'),
            'adder' => $this->getMyUserId()
        ]);

        if ($keyBox) {
            return redirect()->route('KeyBoxes.index')->with('success', 'جعبه کلید با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد جعبه کلید']);
    }

    public function edit($id)
    {
        $keyBox = KeyBox::findOrFail($id);

        return view('TechnicalFacilities.KeyBoxes.edit', compact('keyBox'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:key_boxes,id',
            'model' => 'required|string',
            'color' => 'required|string',
            'material' => 'required|string',
            'door_number' => 'required|integer',
            'key_number' => 'required|integer',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $keyBox = KeyBox::findOrFail($id);
        $keyBox->brand = $request->input('brand');
        $keyBox->model = $request->input('model');
        $keyBox->color = $request->input('color');
        $keyBox->material = $request->input('material');
        $keyBox->door_number = $request->input('door_number');
        $keyBox->key_number = $request->input('key_number');
        $keyBox->status = $request->input('status');
        $keyBox->editor = $this->getMyUserId();
        $keyBox->save();

        return redirect()->route('KeyBoxes.index')->with('success', 'جعبه کلید با موفقیت ویرایش شد.');
    }
}
