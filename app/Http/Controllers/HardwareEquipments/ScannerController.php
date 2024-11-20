<?php

namespace App\Http\Controllers\HardwareEquipments;

use App\Http\Controllers\Controller;
use App\Models\HardwareEquipments\Scanner;
use Illuminate\Http\Request;

class ScannerController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست اسکنر', ['only' => ['index']]);
        $this->middleware('permission:ایجاد اسکنر', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش اسکنر', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف اسکنر', ['only' => ['destroy']]);
    }

    public function index()
    {
        $scanners = Scanner::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('HardwareEquipments.Scanners.index', compact('scanners'));
    }

    public function create()
    {
        return view('HardwareEquipments.Scanners.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $scanner = Scanner::create(['model' => $request->input('model'), 'brand' => $request->input('brand'), 'adder' => $this->getMyUserId()]);

        if ($scanner) {
            return redirect()->route('Scanners.index')->with('success', 'اسکنر با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد اسکنر']);
    }

    public function edit($id)
    {
        $scanner = Scanner::findOrFail($id);

        return view('HardwareEquipments.Scanners.edit', compact('scanner'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:scanners,id',
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $scanner = Scanner::findOrFail($id);
        $scanner->brand = $request->input('brand');
        $scanner->model = $request->input('model');
        $scanner->status = $request->input('status');
        $scanner->editor = $this->getMyUserId();
        $scanner->save();

        return redirect()->route('Scanners.index')->with('success', 'اسکنر با موفقیت ویرایش شد.');
    }
}
