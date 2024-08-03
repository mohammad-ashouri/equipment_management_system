<?php

namespace App\Http\Controllers\DigitalEquipments;

use App\Http\Controllers\Controller;
use App\Models\DigitalEquipments\DVB;
use Illuminate\Http\Request;

class DVBController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست کارت DVB', ['only' => ['index']]);
        $this->middleware('permission:ایجاد کارت DVB', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش کارت DVB', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف کارت DVB', ['only' => ['destroy']]);
    }

    public function index()
    {
        $dvbs = DVB::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->paginate(50);
        return view('DigitalEquipments.DVBs.index', compact('dvbs'));
    }

    public function create()
    {
        return view('DigitalEquipments.DVBs.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'tuner_numbers' => 'required|integer',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $dvbs = DVB::create(['model' => $request->input('model'),
            'brand' => $request->input('brand'),
            'tuner_numbers' => $request->input('tuner_numbers'),
            'adder' => $this->getMyUserId()]);

        if ($dvbs) {
            return redirect()->route('DVBs.index')->with('success', 'کارت DVB با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد کارت DVB']);
    }

    public function edit($id)
    {
        $dvb = DVB::findOrFail($id);

        return view('DigitalEquipments.DVBs.edit', compact('dvb'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:dvbs,id',
            'model' => 'required|string',
            'tuner_numbers' => 'required|integer',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $dvbs = DVB::findOrFail($id);
        $dvbs->brand = $request->input('brand');
        $dvbs->model = $request->input('model');
        $dvbs->tuner_numbers = $request->input('tuner_numbers');
        $dvbs->status = $request->input('status');
        $dvbs->editor = $this->getMyUserId();
        $dvbs->save();

        return redirect()->route('DVBs.index')->with('success', 'کارت DVB با موفقیت ویرایش شد.');
    }
}
