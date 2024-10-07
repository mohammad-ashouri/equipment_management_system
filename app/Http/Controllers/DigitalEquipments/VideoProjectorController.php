<?php

namespace App\Http\Controllers\DigitalEquipments;

use App\Http\Controllers\Controller;
use App\Models\DigitalEquipments\VideoProjector;
use Illuminate\Http\Request;

class VideoProjectorController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست ویدئو پروژکتور', ['only' => ['index']]);
        $this->middleware('permission:ایجاد ویدئو پروژکتور', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش ویدئو پروژکتور', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف ویدئو پروژکتور', ['only' => ['destroy']]);
    }

    public function index()
    {
        $videoProjectors = VideoProjector::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->paginate(50);
        return view('DigitalEquipments.VideoProjectors.index', compact('videoProjectors'));
    }

    public function create()
    {
        return view('DigitalEquipments.VideoProjectors.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $videoProjector = VideoProjector::create([
            'model' => $request->input('model'),
            'brand' => $request->input('brand'),
            'adder' => $this->getMyUserId()
        ]);

        if ($videoProjector) {
            return redirect()->route('VideoProjectors.index')->with('success', 'ویدئو پروژکتور با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد ویدئو پروژکتور']);
    }

    public function edit($id)
    {
        $videoProjector = VideoProjector::findOrFail($id);

        return view('DigitalEquipments.VideoProjectors.edit', compact('videoProjector'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:video_projectors,id',
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $videoProjector = VideoProjector::findOrFail($id);
        $videoProjector->brand = $request->input('brand');
        $videoProjector->model = $request->input('model');
        $videoProjector->status = $request->input('status');
        $videoProjector->editor = $this->getMyUserId();
        $videoProjector->save();

        return redirect()->route('VideoProjectors.index')->with('success', 'ویدئو پروژکتور با موفقیت ویرایش شد.');
    }
}
