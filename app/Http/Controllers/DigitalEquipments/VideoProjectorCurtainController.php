<?php

namespace App\Http\Controllers\DigitalEquipments;

use App\Http\Controllers\Controller;
use App\Models\DigitalEquipments\VideoProjectorCurtain;
use Illuminate\Http\Request;

class VideoProjectorCurtainController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست پرده ویدئو پروژکتور', ['only' => ['index']]);
        $this->middleware('permission:ایجاد پرده ویدئو پروژکتور', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش پرده ویدئو پروژکتور', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف پرده ویدئو پروژکتور', ['only' => ['destroy']]);
    }

    public function index()
    {
        $videoProjectorCurtains = VideoProjectorCurtain::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->paginate(50);
        return view('DigitalEquipments.VideoProjectorCurtains.index', compact('videoProjectorCurtains'));
    }

    public function create()
    {
        return view('DigitalEquipments.VideoProjectorCurtains.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'height' => 'required|integer',
            'width' => 'required|integer',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $videoProjectorCurtain = VideoProjectorCurtain::create([
            'model' => $request->input('model'),
            'width' => $request->input('width'),
            'height' => $request->input('height'),
            'brand' => $request->input('brand'),
            'adder' => $this->getMyUserId()
        ]);

        if ($videoProjectorCurtain) {
            return redirect()->route('VideoProjectorCurtains.index')->with('success', 'پرده ویدئو پروژکتور با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد پرده ویدئو پروژکتور']);
    }

    public function edit($id)
    {
        $videoProjectorCurtain = VideoProjectorCurtain::findOrFail($id);

        return view('DigitalEquipments.VideoProjectorCurtains.edit', compact('videoProjectorCurtain'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:video_projector_curtains,id',
            'model' => 'required|string',
            'width' => 'required|integer',
            'height' => 'required|integer',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $videoProjectorCurtain = VideoProjectorCurtain::findOrFail($id);
        $videoProjectorCurtain->brand = $request->input('brand');
        $videoProjectorCurtain->model = $request->input('model');
        $videoProjectorCurtain->width = $request->input('width');
        $videoProjectorCurtain->height = $request->input('height');
        $videoProjectorCurtain->status = $request->input('status');
        $videoProjectorCurtain->editor = $this->getMyUserId();
        $videoProjectorCurtain->save();

        return redirect()->route('VideoProjectorCurtains.index')->with('success', 'پرده ویدئو پروژکتور با موفقیت ویرایش شد.');
    }
}
