<?php

namespace App\Http\Controllers\NetworkEquipments;

use App\Http\Controllers\Controller;
use App\Models\NetworkEquipments\Switches;
use Illuminate\Http\Request;

class SwitchController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست سوییچ', ['only' => ['index']]);
        $this->middleware('permission:ایجاد سوییچ', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش سوییچ', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف سوییچ', ['only' => ['destroy']]);
    }

    public function index()
    {
        $switches = Switches::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->paginate(50);
        return view('NetworkEquipments.Switches.index', compact('switches'));
    }

    public function create()
    {
        return view('NetworkEquipments.Switches.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
            'ports_number' => 'required|integer',
        ]);

        $switch = Switches::create([
            'model' => $request->input('model'),
            'ports_number' => $request->input('ports_number'),
            'brand' => $request->input('brand'),
            'adder' => $this->getMyUserId()
        ]);

        if ($switch) {
            return redirect()->route('Switches.index')->with('success', 'سوییچ با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد سوییچ']);
    }

    public function edit($id)
    {
        $switch = Switches::findOrFail($id);

        return view('NetworkEquipments.Switches.edit', compact('switch'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:switches,id',
            'model' => 'required|string',
            'ports_number' => 'required|integer',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $switch = Switches::findOrFail($id);
        $switch->brand = $request->input('brand');
        $switch->model = $request->input('model');
        $switch->status = $request->input('status');
        $switch->ports_number = $request->input('ports_number');
        $switch->editor = $this->getMyUserId();
        $switch->save();

        return redirect()->route('Switches.index')->with('success', 'سوییچ با موفقیت ویرایش شد.');
    }
}
