<?php

namespace App\Http\Controllers\HardwareEquipments;

use App\Http\Controllers\Controller;
use App\Models\HardwareEquipments\Voip;
use Illuminate\Http\Request;

class VoipController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست VOIP', ['only' => ['index']]);
        $this->middleware('permission:ایجاد VOIP', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش VOIP', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف VOIP', ['only' => ['destroy']]);
    }

    public function index()
    {
        $voips = Voip::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->paginate(50);
        return view('HardwareEquipments.Voips.index', compact('voips'));
    }

    public function create()
    {
        return view('HardwareEquipments.Voips.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $voip = Voip::create(['model' => $request->input('model'), 'brand' => $request->input('brand'), 'adder' => $this->getMyUserId()]);

        if ($voip) {
            return redirect()->route('Voips.index')->with('success', 'VOIP با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد VOIP']);
    }

    public function edit($id)
    {
        $voip = Voip::findOrFail($id);

        return view('HardwareEquipments.Voips.edit', compact('voip'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:voips,id',
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $voip = Voip::findOrFail($id);
        $voip->brand = $request->input('brand');
        $voip->model = $request->input('model');
        $voip->status = $request->input('status');
        $voip->editor = $this->getMyUserId();
        $voip->save();

        return redirect()->route('Voips.index')->with('success', 'VOIP با موفقیت ویرایش شد.');
    }
}
