<?php

namespace App\Http\Controllers\DigitalEquipments;

use App\Http\Controllers\Controller;
use App\Models\DigitalEquipments\Speaker;
use Illuminate\Http\Request;

class SpeakerController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست اسپیکر', ['only' => ['index']]);
        $this->middleware('permission:ایجاد اسپیکر', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش اسپیکر', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف اسپیکر', ['only' => ['destroy']]);
    }

    public function index()
    {
        $speakers = Speaker::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('DigitalEquipments.Speakers.index', compact('speakers'));
    }

    public function create()
    {
        return view('DigitalEquipments.Speakers.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
            'parts_number' => 'required|integer',
        ]);

        $speaker = Speaker::create([
            'model' => $request->input('model'),
            'parts_number' => $request->input('parts_number'),
            'brand' => $request->input('brand'),
            'adder' => $this->getMyUserId()
        ]);

        if ($speaker) {
            return redirect()->route('Speakers.index')->with('success', 'اسپیکر با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد اسپیکر']);
    }

    public function edit($id)
    {
        $speaker = Speaker::findOrFail($id);

        return view('DigitalEquipments.Speakers.edit', compact('speaker'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:speakers,id',
            'model' => 'required|string',
            'parts_number' => 'required|integer',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $speaker = Speaker::findOrFail($id);
        $speaker->brand = $request->input('brand');
        $speaker->model = $request->input('model');
        $speaker->parts_number = $request->input('parts_number');
        $speaker->status = $request->input('status');
        $speaker->editor = $this->getMyUserId();
        $speaker->save();

        return redirect()->route('Speakers.index')->with('success', 'اسپیکر با موفقیت ویرایش شد.');
    }
}
