<?php

namespace App\Http\Controllers\NetworkEquipments;

use App\Http\Controllers\Controller;
use App\Models\NetworkEquipments\CableTester;
use Illuminate\Http\Request;

class CableTesterController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست تستر شبکه', ['only' => ['index']]);
        $this->middleware('permission:ایجاد تستر شبکه', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش تستر شبکه', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف تستر شبکه', ['only' => ['destroy']]);
    }

    public function index()
    {
        $cableTesters = CableTester::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->paginate(50);
        return view('NetworkEquipments.CableTesters.index', compact('cableTesters'));
    }

    public function create()
    {
        return view('NetworkEquipments.CableTesters.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $cableTester = CableTester::create([
            'model' => $request->input('model'),
            'brand' => $request->input('brand'),
            'adder' => $this->getMyUserId()
        ]);

        if ($cableTester) {
            return redirect()->route('CableTesters.index')->with('success', 'تستر شبکه با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد تستر شبکه']);
    }

    public function edit($id)
    {
        $cableTester = CableTester::findOrFail($id);

        return view('NetworkEquipments.CableTesters.edit', compact('cableTester'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:cable_testers,id',
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $cableTester = CableTester::findOrFail($id);
        $cableTester->brand = $request->input('brand');
        $cableTester->model = $request->input('model');
        $cableTester->status = $request->input('status');
        $cableTester->editor = $this->getMyUserId();
        $cableTester->save();

        return redirect()->route('CableTesters.index')->with('success', 'تستر شبکه با موفقیت ویرایش شد.');
    }
}
