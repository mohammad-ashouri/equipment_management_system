<?php

namespace App\Http\Controllers\NetworkEquipments;

use App\Http\Controllers\Controller;
use App\Models\NetworkEquipments\Lantv;
use Illuminate\Http\Request;

class LantvController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست lantv', ['only' => ['index']]);
        $this->middleware('permission:ایجاد lantv', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش lantv', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف lantv', ['only' => ['destroy']]);
    }

    public function index()
    {
        $Lantvs = Lantv::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->paginate(50);
        return view('NetworkEquipments.Lantvs.index', compact('Lantvs'));
    }

    public function create()
    {
        return view('NetworkEquipments.Lantvs.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
            'input_ports_number' => 'required|integer',
            'output_ports_number' => 'required|integer',
        ]);

        $Lantv = Lantv::create([
            'model' => $request->input('model'),
            'input_ports_number' => $request->input('input_ports_number'),
            'output_ports_number' => $request->input('output_ports_number'),
            'brand' => $request->input('brand'),
            'adder' => $this->getMyUserId()
        ]);

        if ($Lantv) {
            return redirect()->route('Lantvs.index')->with('success', 'lantv با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد lantv']);
    }

    public function edit($id)
    {
        $Lantv = Lantv::findOrFail($id);

        return view('NetworkEquipments.Lantvs.edit', compact('Lantv'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:lantvs,id',
            'model' => 'required|string',
            'input_ports_number' => 'required|integer',
            'output_ports_number' => 'required|integer',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $Lantv = Lantv::findOrFail($id);
        $Lantv->brand = $request->input('brand');
        $Lantv->model = $request->input('model');
        $Lantv->status = $request->input('status');
        $Lantv->input_ports_number = $request->input('input_ports_number');
        $Lantv->output_ports_number = $request->input('output_ports_number');
        $Lantv->editor = $this->getMyUserId();
        $Lantv->save();

        return redirect()->route('Lantvs.index')->with('success', 'lantv با موفقیت ویرایش شد.');
    }
}
