<?php

namespace App\Http\Controllers\DigitalEquipments;

use App\Http\Controllers\Controller;
use App\Models\DigitalEquipments\Tripod;
use Illuminate\Http\Request;

class TripodController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست سه پایه دوربین', ['only' => ['index']]);
        $this->middleware('permission:ایجاد سه پایه دوربین', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش سه پایه دوربین', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف سه پایه دوربین', ['only' => ['destroy']]);
    }

    public function index()
    {
        $tripods = Tripod::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->paginate(50);
        return view('DigitalEquipments.Tripods.index', compact('tripods'));
    }

    public function create()
    {
        return view('DigitalEquipments.Tripods.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'color' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $tripod = Tripod::create([
            'model' => $request->input('model'),
            'color' => $request->input('color'),
            'brand' => $request->input('brand'),
            'adder' => $this->getMyUserId()
        ]);

        if ($tripod) {
            return redirect()->route('Tripods.index')->with('success', 'سه پایه دوربین با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد سه پایه دوربین']);
    }

    public function edit($id)
    {
        $tripod = Tripod::findOrFail($id);

        return view('DigitalEquipments.Tripods.edit', compact('tripod'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:tripods,id',
            'model' => 'required|string',
            'color' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $tripod = Tripod::findOrFail($id);
        $tripod->brand = $request->input('brand');
        $tripod->model = $request->input('model');
        $tripod->color = $request->input('color');
        $tripod->status = $request->input('status');
        $tripod->editor = $this->getMyUserId();
        $tripod->save();

        return redirect()->route('Tripods.index')->with('success', 'سه پایه دوربین با موفقیت ویرایش شد.');
    }
}
