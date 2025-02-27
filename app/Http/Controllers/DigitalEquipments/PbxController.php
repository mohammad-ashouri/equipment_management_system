<?php

namespace App\Http\Controllers\DigitalEquipments;

use App\Http\Controllers\Controller;
use App\Models\DigitalEquipments\Pbx;
use Illuminate\Http\Request;

class PbxController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست دستگاه سانترال', ['only' => ['index']]);
        $this->middleware('permission:ایجاد دستگاه سانترال', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش دستگاه سانترال', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف دستگاه سانترال', ['only' => ['destroy']]);
    }

    public function index()
    {
        $pbxes = Pbx::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('DigitalEquipments.Pbxes.index', compact('pbxes'));
    }

    public function create()
    {
        return view('DigitalEquipments.Pbxes.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $pbx = Pbx::create([
            'model' => $request->input('model'),
            'brand' => $request->input('brand'),
            'adder' => $this->getMyUserId()
        ]);

        if ($pbx) {
            return redirect()->route('Pbxes.index')->with('success', 'دستگاه سانترال با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد دستگاه سانترال']);
    }

    public function edit($id)
    {
        $pbx = Pbx::findOrFail($id);

        return view('DigitalEquipments.Pbxes.edit', compact('pbx'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:pbxes,id',
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $pbx = Pbx::findOrFail($id);
        $pbx->brand = $request->input('brand');
        $pbx->model = $request->input('model');
        $pbx->status = $request->input('status');
        $pbx->editor = $this->getMyUserId();
        $pbx->save();

        return redirect()->route('Pbxes.index')->with('success', 'دستگاه سانترال با موفقیت ویرایش شد.');
    }
}
