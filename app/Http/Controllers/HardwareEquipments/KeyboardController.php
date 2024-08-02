<?php

namespace App\Http\Controllers\HardwareEquipments;

use App\Http\Controllers\Controller;
use App\Models\HardwareEquipments\Keyboard;
use Illuminate\Http\Request;

class KeyboardController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست صفحه کلید', ['only' => ['index']]);
        $this->middleware('permission:ایجاد صفحه کلید', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش صفحه کلید', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف صفحه کلید', ['only' => ['destroy']]);
    }

    public function index()
    {
        $keyboards = Keyboard::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->paginate(50);
        return view('HardwareEquipments.Keyboards.index', compact('keyboards'));
    }

    public function create()
    {
        return view('HardwareEquipments.Keyboards.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'connectivity_type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $keyboard = Keyboard::create(['model' => $request->input('model'), 'connectivity_type' => $request->input('connectivity_type'), 'brand' => $request->input('brand'), 'adder' => $this->getMyUserId()]);

        if ($keyboard) {
            return redirect()->route('Keyboards.index')->with('success', 'صفحه کلید با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد صفحه کلید']);
    }

    public function edit($id)
    {
        $keyboard = Keyboard::findOrFail($id);

        return view('HardwareEquipments.Keyboards.edit', compact('keyboard'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:keyboards,id',
            'model' => 'required|string',
            'connectivity_type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $keyboard = Keyboard::findOrFail($id);
        $keyboard->brand = $request->input('brand');
        $keyboard->model = $request->input('model');
        $keyboard->connectivity_type = $request->input('connectivity_type');
        $keyboard->status = $request->input('status');
        $keyboard->editor = $this->getMyUserId();
        $keyboard->save();

        return redirect()->route('Keyboards.index')->with('success', 'صفحه کلید با موفقیت ویرایش شد.');
    }
}
