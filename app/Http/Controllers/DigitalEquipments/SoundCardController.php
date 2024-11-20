<?php

namespace App\Http\Controllers\DigitalEquipments;

use App\Http\Controllers\Controller;
use App\Models\DigitalEquipments\SoundCard;
use Illuminate\Http\Request;

class SoundCardController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست کارت صدا', ['only' => ['index']]);
        $this->middleware('permission:ایجاد کارت صدا', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش کارت صدا', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف کارت صدا', ['only' => ['destroy']]);
    }

    public function index()
    {
        $soundCards = SoundCard::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('DigitalEquipments.SoundCards.index', compact('soundCards'));
    }

    public function create()
    {
        return view('DigitalEquipments.SoundCards.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
            'connectivity_type' => 'required|string',
        ]);

        $soundCard = SoundCard::create([
            'model' => $request->input('model'),
            'connectivity_type' => $request->input('connectivity_type'),
            'brand' => $request->input('brand'),
            'adder' => $this->getMyUserId()
        ]);

        if ($soundCard) {
            return redirect()->route('SoundCards.index')->with('success', 'کارت صدا با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد کارت صدا']);
    }

    public function edit($id)
    {
        $soundCard = SoundCard::findOrFail($id);

        return view('DigitalEquipments.SoundCards.edit', compact('soundCard'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:sound_cards,id',
            'model' => 'required|string',
            'connectivity_type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $soundCard = SoundCard::findOrFail($id);
        $soundCard->brand = $request->input('brand');
        $soundCard->model = $request->input('model');
        $soundCard->connectivity_type = $request->input('connectivity_type');
        $soundCard->status = $request->input('status');
        $soundCard->editor = $this->getMyUserId();
        $soundCard->save();

        return redirect()->route('SoundCards.index')->with('success', 'کارت صدا با موفقیت ویرایش شد.');
    }
}
