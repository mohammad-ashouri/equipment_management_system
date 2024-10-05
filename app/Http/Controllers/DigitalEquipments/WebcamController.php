<?php

namespace App\Http\Controllers\DigitalEquipments;

use App\Http\Controllers\Controller;
use App\Models\DigitalEquipments\Webcam;
use Illuminate\Http\Request;

class WebcamController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست وبکم', ['only' => ['index']]);
        $this->middleware('permission:ایجاد وبکم', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش وبکم', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف وبکم', ['only' => ['destroy']]);
    }

    public function index()
    {
        $webcams = Webcam::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->paginate(50);
        return view('DigitalEquipments.Webcams.index', compact('webcams'));
    }

    public function create()
    {
        return view('DigitalEquipments.Webcams.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $webcam = Webcam::create([
            'model' => $request->input('model'),
            'brand' => $request->input('brand'),
            'adder' => $this->getMyUserId()
        ]);

        if ($webcam) {
            return redirect()->route('Webcams.index')->with('success', 'وبکم با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد وبکم']);
    }

    public function edit($id)
    {
        $webcam = Webcam::findOrFail($id);

        return view('DigitalEquipments.Webcams.edit', compact('webcam'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:webcams,id',
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $webcam = Webcam::findOrFail($id);
        $webcam->brand = $request->input('brand');
        $webcam->model = $request->input('model');
        $webcam->status = $request->input('status');
        $webcam->editor = $this->getMyUserId();
        $webcam->save();

        return redirect()->route('Webcams.index')->with('success', 'وبکم با موفقیت ویرایش شد.');
    }
}
