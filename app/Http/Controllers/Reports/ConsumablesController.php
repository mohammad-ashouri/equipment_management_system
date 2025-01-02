<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\Reports\Consumable;
use Illuminate\Http\Request;

class ConsumablesController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست اقلام مصرفی', ['only' => ['index']]);
        $this->middleware('permission:ایجاد اقلام مصرفی', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش اقلام مصرفی', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف اقلام مصرفی', ['only' => ['destroy']]);
    }

    public function index()
    {
        $consumables = Consumable::with('adderInfo', 'editorInfo')->orderBy('name')->get();
        return view('Reports.Consumables', compact('consumables'));
    }

    public function store(Request $request)
    {
        $validatedData = $this->validate($request, [
            'name' => 'required|string|max:120|unique:consumables,name',
            'quantity' => 'required|integer',
        ]);
        Consumable::create([
            'name' => $validatedData['name'],
            'quantity' => $validatedData['quantity'],
            'adder' => auth()->user()->id
        ]);

        return response()->json(['message' => 'مصرفی با موفقیت اضافه شد.'], 200);
    }

    public function show($id)
    {
        $consumable = Consumable::with('adderInfo', 'editorInfo')->findOrFail($id);
        return response()->json(['data' => $consumable]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $this->validate($request, [
            'name' => 'required|string|max:120|unique:consumables,name,' . $id,
            'quantity' => 'required|integer',
        ]);
        Consumable::findOrFail($id)->update([
            'name' => $validatedData['name'],
            'quantity' => $validatedData['quantity'],
            'editor' => auth()->user()->id
        ]);

        return response()->json(['message' => 'اقلام مصرفی با موفقیت ویرایش شد.'], 200);
    }
}
