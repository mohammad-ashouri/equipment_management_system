<?php

namespace App\Http\Controllers\HardwareEquipments;

use App\Http\Controllers\Controller;
use App\Models\HardwareEquipments\Printer;
use Illuminate\Http\Request;

class PrinterController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست پرینتر', ['only' => ['index']]);
        $this->middleware('permission:ایجاد پرینتر', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش پرینتر', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف پرینتر', ['only' => ['destroy']]);
    }

    public function index()
    {
        $printers = Printer::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('HardwareEquipments.Printers.index', compact('printers'));
    }

    public function create()
    {
        return view('HardwareEquipments.Printers.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'function_type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $printer = Printer::create(['model' => $request->input('model'), 'brand' => $request->input('brand'),'function_type' => $request->input('function_type'), 'adder' => $this->getMyUserId()]);

        if ($printer) {
            return redirect()->route('Printers.index')->with('success', 'پرینتر با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد پرینتر']);
    }

    public function edit($id)
    {
        $printer = Printer::findOrFail($id);

        return view('HardwareEquipments.Printers.edit', compact('printer'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:printers,id',
            'model' => 'required|string',
            'function_type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $printer = Printer::findOrFail($id);
        $printer->brand = $request->input('brand');
        $printer->model = $request->input('model');
        $printer->function_type = $request->input('function_type');
        $printer->status = $request->input('status');
        $printer->editor = $this->getMyUserId();
        $printer->save();

        return redirect()->route('Printers.index')->with('success', 'پرینتر با موفقیت ویرایش شد.');
    }
}
