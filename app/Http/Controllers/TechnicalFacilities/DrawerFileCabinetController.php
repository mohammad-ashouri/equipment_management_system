<?php

namespace App\Http\Controllers\TechnicalFacilities;

use App\Http\Controllers\Controller;
use App\Models\TechnicalFacilities\DrawerFileCabinet;
use Illuminate\Http\Request;

class DrawerFileCabinetController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست فایل کشویی', ['only' => ['index']]);
        $this->middleware('permission:ایجاد فایل کشویی', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش فایل کشویی', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف فایل کشویی', ['only' => ['destroy']]);
    }

    public function index()
    {
        $drawerFileCabinets = DrawerFileCabinet::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->paginate(50);
        return view('TechnicalFacilities.DrawerFileCabinets.index', compact('drawerFileCabinets'));
    }

    public function create()
    {
        return view('TechnicalFacilities.DrawerFileCabinets.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'material' => 'required|string',
            'drawer_number' => 'required|integer',
            'lock' => 'required|boolean',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $drawerFileCabinets = DrawerFileCabinet::create(['brand' => $request->input('brand'), 'drawer_number' => $request->input('drawer_number'), 'material' => $request->input('material'), 'lock' => $request->input('lock'), 'adder' => $this->getMyUserId()]);

        if ($drawerFileCabinets) {
            return redirect()->route('DrawerFileCabinets.index')->with('success', 'فایل کشویی با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد فایل کشویی']);
    }

    public function edit($id)
    {
        $drawerFileCabinet = DrawerFileCabinet::findOrFail($id);

        return view('TechnicalFacilities.DrawerFileCabinets.edit', compact('drawerFileCabinet'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:drawer_file_cabinets,id',
            'material' => 'required|string',
            'drawer_number' => 'required|integer',
            'lock' => 'required|boolean',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $drawerFileCabinets = DrawerFileCabinet::findOrFail($id);
        $drawerFileCabinets->brand = $request->input('brand');
        $drawerFileCabinets->drawer_number = $request->input('drawer_number');
        $drawerFileCabinets->material = $request->input('material');
        $drawerFileCabinets->lock = $request->input('lock');
        $drawerFileCabinets->status = $request->input('status');
        $drawerFileCabinets->editor = $this->getMyUserId();
        $drawerFileCabinets->save();

        return redirect()->route('DrawerFileCabinets.index')->with('success', 'فایل کشویی با موفقیت ویرایش شد.');
    }
}
