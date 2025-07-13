<?php

namespace App\Http\Controllers\HardwareEquipments;

use App\Http\Controllers\Controller;
use App\Models\HardwareEquipments\ExternalWriter;
use Illuminate\Http\Request;

class ExternalWriterController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست رایتر اکسترنال', ['only' => ['index']]);
        $this->middleware('permission:ایجاد رایتر اکسترنال', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش رایتر اکسترنال', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف رایتر اکسترنال', ['only' => ['destroy']]);
    }

    public function index()
    {
        $externalWriters = ExternalWriter::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('HardwareEquipments.ExternalWriters.index', compact('externalWriters'));
    }

    public function create()
    {
        return view('HardwareEquipments.ExternalWriters.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'connectivity_type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $externalWriter = ExternalWriter::create(['model' => $request->input('model'), 'connectivity_type' => $request->input('connectivity_type'), 'brand' => $request->input('brand'), 'adder' => $this->getMyUserId()]);

        if ($externalWriter) {
            return redirect()->route('ExternalWriters.index')->with('success', 'رایتر اکسترنال با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد رایتر اکسترنال']);
    }

    public function edit($id)
    {
        $externalWriter = ExternalWriter::findOrFail($id);

        return view('HardwareEquipments.ExternalWriters.edit', compact('externalWriter'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:external_writers,id',
            'model' => 'required|string',
            'connectivity_type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $externalWriter = ExternalWriter::findOrFail($id);
        $externalWriter->brand = $request->input('brand');
        $externalWriter->model = $request->input('model');
        $externalWriter->connectivity_type = $request->input('connectivity_type');
        $externalWriter->status = $request->input('status');
        $externalWriter->editor = $this->getMyUserId();
        $externalWriter->save();

        return redirect()->route('ExternalWriters.index')->with('success', 'رایتر اکسترنال با موفقیت ویرایش شد.');
    }
}
