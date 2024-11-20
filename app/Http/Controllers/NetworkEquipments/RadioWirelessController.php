<?php

namespace App\Http\Controllers\NetworkEquipments;

use App\Http\Controllers\Controller;
use App\Models\NetworkEquipments\RadioWireless;
use Illuminate\Http\Request;

class RadioWirelessController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست رادیو وایرلس', ['only' => ['index']]);
        $this->middleware('permission:ایجاد رادیو وایرلس', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش رادیو وایرلس', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف رادیو وایرلس', ['only' => ['destroy']]);
    }

    public function index()
    {
        $radioWirelesses = RadioWireless::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('NetworkEquipments.RadioWirelesses.index', compact('radioWirelesses'));
    }

    public function create()
    {
        return view('NetworkEquipments.RadioWirelesses.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $radioWireless = RadioWireless::create([
            'model' => $request->input('model'),
            'brand' => $request->input('brand'),
            'adder' => $this->getMyUserId()
        ]);

        if ($radioWireless) {
            return redirect()->route('RadioWirelesses.index')->with('success', 'رادیو وایرلس با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد رادیو وایرلس']);
    }

    public function edit($id)
    {
        $radioWireless = RadioWireless::findOrFail($id);

        return view('NetworkEquipments.RadioWirelesses.edit', compact('radioWireless'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:radio_wirelesses,id',
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $radioWireless = RadioWireless::findOrFail($id);
        $radioWireless->brand = $request->input('brand');
        $radioWireless->model = $request->input('model');
        $radioWireless->status = $request->input('status');
        $radioWireless->editor = $this->getMyUserId();
        $radioWireless->save();

        return redirect()->route('RadioWirelesses.index')->with('success', 'رادیو وایرلس با موفقیت ویرایش شد.');
    }
}
