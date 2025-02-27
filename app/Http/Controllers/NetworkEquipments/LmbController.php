<?php

namespace App\Http\Controllers\NetworkEquipments;

use App\Http\Controllers\Controller;
use App\Models\NetworkEquipments\Lmb;
use Illuminate\Http\Request;

class LmbController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست lmb', ['only' => ['index']]);
        $this->middleware('permission:ایجاد lmb', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش lmb', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف lmb', ['only' => ['destroy']]);
    }

    public function index()
    {
        $lmbs = Lmb::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('NetworkEquipments.Lmbs.index', compact('lmbs'));
    }

    public function create()
    {
        return view('NetworkEquipments.Lmbs.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $lmb = Lmb::create([
            'model' => $request->input('model'),
            'brand' => $request->input('brand'),
            'adder' => $this->getMyUserId()
        ]);

        if ($lmb) {
            return redirect()->route('Lmbs.index')->with('success', 'lmb با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد lmb']);
    }

    public function edit($id)
    {
        $lmb = Lmb::findOrFail($id);

        return view('NetworkEquipments.Lmbs.edit', compact('lmb'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:lmbs,id',
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $lmb = Lmb::findOrFail($id);
        $lmb->brand = $request->input('brand');
        $lmb->model = $request->input('model');
        $lmb->status = $request->input('status');
        $lmb->editor = $this->getMyUserId();
        $lmb->save();

        return redirect()->route('Lmbs.index')->with('success', 'lmb با موفقیت ویرایش شد.');
    }
}
