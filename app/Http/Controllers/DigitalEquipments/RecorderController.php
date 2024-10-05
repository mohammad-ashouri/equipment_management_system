<?php

namespace App\Http\Controllers\DigitalEquipments;

use App\Http\Controllers\Controller;
use App\Models\DigitalEquipments\Recorder;
use Illuminate\Http\Request;

class RecorderController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست رکوردر', ['only' => ['index']]);
        $this->middleware('permission:ایجاد رکوردر', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش رکوردر', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف رکوردر', ['only' => ['destroy']]);
    }

    public function index()
    {
        $recorders = Recorder::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->paginate(50);
        return view('DigitalEquipments.Recorders.index', compact('recorders'));
    }

    public function create()
    {
        return view('DigitalEquipments.Recorders.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $recorder = Recorder::create([
            'model' => $request->input('model'),
            'brand' => $request->input('brand'),
            'adder' => $this->getMyUserId()
        ]);

        if ($recorder) {
            return redirect()->route('Recorders.index')->with('success', 'رکوردر با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد رکوردر']);
    }

    public function edit($id)
    {
        $recorder = Recorder::findOrFail($id);

        return view('DigitalEquipments.Recorders.edit', compact('recorder'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:recorders,id',
            'model' => 'required|string',
            'type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $recorder = Recorder::findOrFail($id);
        $recorder->brand = $request->input('brand');
        $recorder->model = $request->input('model');
        $recorder->status = $request->input('status');
        $recorder->type = $request->input('type');
        $recorder->editor = $this->getMyUserId();
        $recorder->save();

        return redirect()->route('Recorders.index')->with('success', 'رکوردر با موفقیت ویرایش شد.');
    }
}
