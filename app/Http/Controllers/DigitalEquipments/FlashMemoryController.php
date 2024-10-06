<?php

namespace App\Http\Controllers\DigitalEquipments;

use App\Http\Controllers\Controller;
use App\Models\DigitalEquipments\FlashMemory;
use Illuminate\Http\Request;

class FlashMemoryController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست فلش مموری', ['only' => ['index']]);
        $this->middleware('permission:ایجاد فلش مموری', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش فلش مموری', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف فلش مموری', ['only' => ['destroy']]);
    }

    public function index()
    {
        $flashMemories = FlashMemory::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->paginate(50);
        return view('DigitalEquipments.FlashMemories.index', compact('flashMemories'));
    }

    public function create()
    {
        return view('DigitalEquipments.FlashMemories.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'capacity' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $flashMemories = FlashMemory::create(['model' => $request->input('model'), 'brand' => $request->input('brand'), 'capacity' => $request->input('capacity'), 'adder' => $this->getMyUserId()]);

        if ($flashMemories) {
            return redirect()->route('FlashMemories.index')->with('success', 'فلش مموری با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد فلش مموری']);
    }

    public function edit($id)
    {
        $flashMemory = FlashMemory::findOrFail($id);

        return view('DigitalEquipments.FlashMemories.edit', compact('flashMemory'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:flash_memories,id',
            'model' => 'required|string',
            'capacity' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $flashMemories = FlashMemory::findOrFail($id);
        $flashMemories->brand = $request->input('brand');
        $flashMemories->model = $request->input('model');
        $flashMemories->capacity = $request->input('capacity');
        $flashMemories->status = $request->input('status');
        $flashMemories->editor = $this->getMyUserId();
        $flashMemories->save();

        return redirect()->route('FlashMemories.index')->with('success', 'فلش مموری با موفقیت ویرایش شد.');
    }
}
