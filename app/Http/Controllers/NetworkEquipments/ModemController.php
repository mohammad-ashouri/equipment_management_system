<?php

namespace App\Http\Controllers\NetworkEquipments;

use App\Http\Controllers\Controller;
use App\Models\NetworkEquipments\Modem;
use Illuminate\Http\Request;

class ModemController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست مودم', ['only' => ['index']]);
        $this->middleware('permission:ایجاد مودم', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش مودم', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف مودم', ['only' => ['destroy']]);
    }

    public function index()
    {
        $modems = Modem::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->paginate(50);
        return view('NetworkEquipments.Modems.index', compact('modems'));
    }

    public function create()
    {
        return view('NetworkEquipments.Modems.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
            'connectivity_type' => 'required|string',
            'ports_number' => 'required|integer',
            'type' => 'required|string',
            'antennas_number' => 'required|integer',
        ]);

        $modem = Modem::create([
            'model' => $request->input('model'),
            'connectivity_type' => $request->input('connectivity_type'),
            'ports_number' => $request->input('ports_number'),
            'type' => $request->input('type'),
            'antennas_number' => $request->input('antennas_number'),
            'brand' => $request->input('brand'),
            'adder' => $this->getMyUserId()
        ]);

        if ($modem) {
            return redirect()->route('Modems.index')->with('success', 'مودم با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد مودم']);
    }

    public function edit($id)
    {
        $modem = Modem::findOrFail($id);

        return view('NetworkEquipments.Modems.edit', compact('modem'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:modems,id',
            'model' => 'required|string',
            'connectivity_type' => 'required|string',
            'ports_number' => 'required|integer',
            'type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
            'antennas_number' => 'required|integer',
        ]);

        $modem = Modem::findOrFail($id);
        $modem->brand = $request->input('brand');
        $modem->model = $request->input('model');
        $modem->status = $request->input('status');
        $modem->connectivity_type = $request->input('connectivity_type');
        $modem->ports_number = $request->input('ports_number');
        $modem->type = $request->input('type');
        $modem->antennas_number = $request->input('antennas_number');
        $modem->editor = $this->getMyUserId();
        $modem->save();

        return redirect()->route('Modems.index')->with('success', 'مودم با موفقیت ویرایش شد.');
    }
}
