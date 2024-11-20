<?php

namespace App\Http\Controllers\NetworkEquipments;

use App\Http\Controllers\Controller;
use App\Models\NetworkEquipments\PunchWrench;
use Illuminate\Http\Request;

class PunchWrenchController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست آچار پانچ', ['only' => ['index']]);
        $this->middleware('permission:ایجاد آچار پانچ', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش آچار پانچ', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف آچار پانچ', ['only' => ['destroy']]);
    }

    public function index()
    {
        $punchWrenches = PunchWrench::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('NetworkEquipments.PunchWrenches.index', compact('punchWrenches'));
    }

    public function create()
    {
        return view('NetworkEquipments.PunchWrenches.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $punchWrench = PunchWrench::create([
            'model' => $request->input('model'),
            'brand' => $request->input('brand'),
            'adder' => $this->getMyUserId()
        ]);

        if ($punchWrench) {
            return redirect()->route('PunchWrenches.index')->with('success', 'آچار پانچ با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد آچار پانچ']);
    }

    public function edit($id)
    {
        $punchWrench = PunchWrench::findOrFail($id);

        return view('NetworkEquipments.PunchWrenches.edit', compact('punchWrench'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:punch_wrenches,id',
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $punchWrench = PunchWrench::findOrFail($id);
        $punchWrench->brand = $request->input('brand');
        $punchWrench->model = $request->input('model');
        $punchWrench->status = $request->input('status');
        $punchWrench->editor = $this->getMyUserId();
        $punchWrench->save();

        return redirect()->route('PunchWrenches.index')->with('success', 'آچار پانچ با موفقیت ویرایش شد.');
    }
}
