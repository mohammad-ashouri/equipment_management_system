<?php

namespace App\Http\Controllers\DigitalEquipments;

use App\Http\Controllers\Controller;
use App\Models\DigitalEquipments\LightHolder;
use Illuminate\Http\Request;

class LightHolderController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست پایه نور', ['only' => ['index']]);
        $this->middleware('permission:ایجاد پایه نور', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش پایه نور', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف پایه نور', ['only' => ['destroy']]);
    }

    public function index()
    {
        $lightHolders = LightHolder::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('DigitalEquipments.LightHolders.index', compact('lightHolders'));
    }

    public function create()
    {
        return view('DigitalEquipments.LightHolders.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $lightHolder = LightHolder::create([
            'model' => $request->input('model'),
            'brand' => $request->input('brand'),
            'adder' => $this->getMyUserId()
        ]);

        if ($lightHolder) {
            return redirect()->route('LightHolders.index')->with('success', 'پایه نور با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد پایه نور']);
    }

    public function edit($id)
    {
        $lightHolder = LightHolder::findOrFail($id);

        return view('DigitalEquipments.LightHolders.edit', compact('lightHolder'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:light_holders,id',
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $lightHolder = LightHolder::findOrFail($id);
        $lightHolder->brand = $request->input('brand');
        $lightHolder->model = $request->input('model');
        $lightHolder->status = $request->input('status');
        $lightHolder->editor = $this->getMyUserId();
        $lightHolder->save();

        return redirect()->route('LightHolders.index')->with('success', 'پایه نور با موفقیت ویرایش شد.');
    }
}
