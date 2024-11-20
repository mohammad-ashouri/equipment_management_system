<?php

namespace App\Http\Controllers\TechnicalFacilities;

use App\Http\Controllers\Controller;
use App\Models\TechnicalFacilities\Blower;
use Illuminate\Http\Request;

class BlowerController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست دستگاه دمنده', ['only' => ['index']]);
        $this->middleware('permission:ایجاد دستگاه دمنده', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش دستگاه دمنده', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف دستگاه دمنده', ['only' => ['destroy']]);
    }

    public function index()
    {
        $blowers = Blower::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('TechnicalFacilities.Blowers.index', compact('blowers'));
    }

    public function create()
    {
        return view('TechnicalFacilities.Blowers.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'power_type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $blower = Blower::create([
            'model' => $request->input('model'),
            'power_type' => $request->input('power_type'),
            'brand' => $request->input('brand'),
            'adder' => $this->getMyUserId()
        ]);

        if ($blower) {
            return redirect()->route('Blowers.index')->with('success', 'دستگاه دمنده با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد دستگاه دمنده']);
    }

    public function edit($id)
    {
        $blower = Blower::findOrFail($id);

        return view('TechnicalFacilities.Blowers.edit', compact('blower'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:blowers,id',
            'model' => 'required|string',
            'power_type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $blower = Blower::findOrFail($id);
        $blower->brand = $request->input('brand');
        $blower->model = $request->input('model');
        $blower->power_type = $request->input('power_type');
        $blower->status = $request->input('status');
        $blower->editor = $this->getMyUserId();
        $blower->save();

        return redirect()->route('Blowers.index')->with('success', 'دستگاه دمنده با موفقیت ویرایش شد.');
    }
}
