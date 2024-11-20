<?php

namespace App\Http\Controllers\NetworkEquipments;

use App\Http\Controllers\Controller;
use App\Models\NetworkEquipments\SocketWrench;
use Illuminate\Http\Request;

class SocketWrenchController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست آچار سوکت', ['only' => ['index']]);
        $this->middleware('permission:ایجاد آچار سوکت', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش آچار سوکت', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف آچار سوکت', ['only' => ['destroy']]);
    }

    public function index()
    {
        $socketWrenches = SocketWrench::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('NetworkEquipments.SocketWrenches.index', compact('socketWrenches'));
    }

    public function create()
    {
        return view('NetworkEquipments.SocketWrenches.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $socketWrench = SocketWrench::create([
            'model' => $request->input('model'),
            'brand' => $request->input('brand'),
            'adder' => $this->getMyUserId()
        ]);

        if ($socketWrench) {
            return redirect()->route('SocketWrenches.index')->with('success', 'آچار سوکت با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد آچار سوکت']);
    }

    public function edit($id)
    {
        $socketWrench = SocketWrench::findOrFail($id);

        return view('NetworkEquipments.SocketWrenches.edit', compact('socketWrench'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:socket_wrenches,id',
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $socketWrench = SocketWrench::findOrFail($id);
        $socketWrench->brand = $request->input('brand');
        $socketWrench->model = $request->input('model');
        $socketWrench->status = $request->input('status');
        $socketWrench->editor = $this->getMyUserId();
        $socketWrench->save();

        return redirect()->route('SocketWrenches.index')->with('success', 'آچار سوکت با موفقیت ویرایش شد.');
    }
}
