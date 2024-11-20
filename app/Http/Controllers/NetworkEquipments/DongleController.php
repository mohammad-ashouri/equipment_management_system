<?php

namespace App\Http\Controllers\NetworkEquipments;

use App\Http\Controllers\Controller;
use App\Models\NetworkEquipments\Dongle;
use Illuminate\Http\Request;

class DongleController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست دانگل', ['only' => ['index']]);
        $this->middleware('permission:ایجاد دانگل', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش دانگل', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف دانگل', ['only' => ['destroy']]);
    }

    public function index()
    {
        $dongles = Dongle::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('NetworkEquipments.Dongles.index', compact('dongles'));
    }

    public function create()
    {
        return view('NetworkEquipments.Dongles.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
            'type' => 'required|string',
        ]);

        $dongle = Dongle::create([
            'model' => $request->input('model'),
            'type' => $request->input('type'),
            'brand' => $request->input('brand'),
            'adder' => $this->getMyUserId()
        ]);

        if ($dongle) {
            return redirect()->route('Dongles.index')->with('success', 'دانگل با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد دانگل']);
    }

    public function edit($id)
    {
        $dongle = Dongle::findOrFail($id);

        return view('NetworkEquipments.Dongles.edit', compact('dongle'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:dongles,id',
            'model' => 'required|string',
            'type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $dongle = Dongle::findOrFail($id);
        $dongle->brand = $request->input('brand');
        $dongle->model = $request->input('model');
        $dongle->status = $request->input('status');
        $dongle->type = $request->input('type');
        $dongle->editor = $this->getMyUserId();
        $dongle->save();

        return redirect()->route('Dongles.index')->with('success', 'دانگل با موفقیت ویرایش شد.');
    }
}
