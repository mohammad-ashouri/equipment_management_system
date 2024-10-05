<?php

namespace App\Http\Controllers\DigitalEquipments;

use App\Http\Controllers\Controller;
use App\Models\DigitalEquipments\Cctv;
use Illuminate\Http\Request;

class CctvController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست دوربین مدار بسته', ['only' => ['index']]);
        $this->middleware('permission:ایجاد دوربین مدار بسته', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش دوربین مدار بسته', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف دوربین مدار بسته', ['only' => ['destroy']]);
    }

    public function index()
    {
        $cctvs = Cctv::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->paginate(50);
        return view('DigitalEquipments.Cctvs.index', compact('cctvs'));
    }

    public function create()
    {
        return view('DigitalEquipments.Cctvs.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
            'connectivity_type' => 'required|string',
            'type' => 'required|string',
        ]);

        $cctv = Cctv::create([
            'model' => $request->input('model'),
            'type' => $request->input('type'),
            'connectivity_type' => $request->input('connectivity_type'),
            'brand' => $request->input('brand'),
            'adder' => $this->getMyUserId()
        ]);

        if ($cctv) {
            return redirect()->route('Cctvs.index')->with('success', 'دوربین مدار بسته با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد دوربین مدار بسته']);
    }

    public function edit($id)
    {
        $cctv = Cctv::findOrFail($id);

        return view('DigitalEquipments.Cctvs.edit', compact('cctv'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:cctvs,id',
            'model' => 'required|string',
            'connectivity_type' => 'required|string',
            'type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $cctv = Cctv::findOrFail($id);
        $cctv->brand = $request->input('brand');
        $cctv->model = $request->input('model');
        $cctv->status = $request->input('status');
        $cctv->connectivity_type = $request->input('connectivity_type');
        $cctv->type = $request->input('type');
        $cctv->editor = $this->getMyUserId();
        $cctv->save();

        return redirect()->route('Cctvs.index')->with('success', 'دوربین مدار بسته با موفقیت ویرایش شد.');
    }
}
