<?php

namespace App\Http\Controllers\TechnicalFacilities;

use App\Http\Controllers\Controller;
use App\Models\TechnicalFacilities\Safe;
use Illuminate\Http\Request;

class SafeController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست گاو صندوق', ['only' => ['index']]);
        $this->middleware('permission:ایجاد گاو صندوق', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش گاو صندوق', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف گاو صندوق', ['only' => ['destroy']]);
    }

    public function index()
    {
        $safes = Safe::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('TechnicalFacilities.Safes.index', compact('safes'));
    }

    public function create()
    {
        return view('TechnicalFacilities.Safes.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'type' => 'required|string',
            'floors_number' => 'required|integer',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $safe = Safe::create([
            'model' => $request->input('model'),
            'brand' => $request->input('brand'),
            'type' => $request->input('type'),
            'floors_number' => $request->input('floors_number'),
            'adder' => $this->getMyUserId()
        ]);

        if ($safe) {
            return redirect()->route('Safes.index')->with('success', 'گاو صندوق با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد گاو صندوق']);
    }

    public function edit($id)
    {
        $safe = Safe::findOrFail($id);

        return view('TechnicalFacilities.Safes.edit', compact('safe'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:safes,id',
            'model' => 'required|string',
            'type' => 'required|string',
            'floors_number' => 'required|integer',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $safe = Safe::findOrFail($id);
        $safe->brand = $request->input('brand');
        $safe->model = $request->input('model');
        $safe->type = $request->input('type');
        $safe->floors_number = $request->input('floors_number');
        $safe->status = $request->input('status');
        $safe->editor = $this->getMyUserId();
        $safe->save();

        return redirect()->route('Safes.index')->with('success', 'گاو صندوق با موفقیت ویرایش شد.');
    }
}
