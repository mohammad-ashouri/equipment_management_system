<?php

namespace App\Http\Controllers\NetworkEquipments;

use App\Http\Controllers\Controller;
use App\Models\NetworkEquipments\StripperWrench;
use Illuminate\Http\Request;

class StripperWrenchController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست آچار استریپر', ['only' => ['index']]);
        $this->middleware('permission:ایجاد آچار استریپر', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش آچار استریپر', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف آچار استریپر', ['only' => ['destroy']]);
    }

    public function index()
    {
        $stripperWrenches = StripperWrench::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('NetworkEquipments.StripperWrenches.index', compact('stripperWrenches'));
    }

    public function create()
    {
        return view('NetworkEquipments.StripperWrenches.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $stripperWrench = StripperWrench::create([
            'model' => $request->input('model'),
            'brand' => $request->input('brand'),
            'adder' => $this->getMyUserId()
        ]);

        if ($stripperWrench) {
            return redirect()->route('StripperWrenches.index')->with('success', 'آچار استریپر با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد آچار استریپر']);
    }

    public function edit($id)
    {
        $stripperWrench = StripperWrench::findOrFail($id);

        return view('NetworkEquipments.StripperWrenches.edit', compact('stripperWrench'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:stripper_wrenches,id',
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $stripperWrench = StripperWrench::findOrFail($id);
        $stripperWrench->brand = $request->input('brand');
        $stripperWrench->model = $request->input('model');
        $stripperWrench->status = $request->input('status');
        $stripperWrench->editor = $this->getMyUserId();
        $stripperWrench->save();

        return redirect()->route('StripperWrenches.index')->with('success', 'آچار استریپر با موفقیت ویرایش شد.');
    }
}
