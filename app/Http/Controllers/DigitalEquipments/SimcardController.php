<?php

namespace App\Http\Controllers\DigitalEquipments;

use App\Http\Controllers\Controller;
use App\Models\DigitalEquipments\Simcard;
use Illuminate\Http\Request;

class SimcardController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست سیمکارت', ['only' => ['index']]);
        $this->middleware('permission:ایجاد سیمکارت', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش سیمکارت', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف سیمکارت', ['only' => ['destroy']]);
    }

    public function index()
    {
        $simcards = Simcard::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('DigitalEquipments.Simcards.index', compact('simcards'));
    }

    public function create()
    {
        return view('DigitalEquipments.Simcards.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'type_use' => 'required|string',
            'number' => 'required|string|unique:simcards,number',
            'pin' => 'required|string',
            'puk' => 'required|string',
            'serial' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $simcards = Simcard::create([
            'number' => $request->input('number'),
            'type_use' => $request->input('type_use'),
            'brand' => $request->input('brand'),
            'pin' => $request->input('pin'),
            'puk' => $request->input('puk'),
            'serial' => $request->input('serial'),
            'adder' => $this->getMyUserId()]);

        if ($simcards) {
            return redirect()->route('Simcards.index')->with('success', 'سیمکارت با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد سیمکارت']);
    }

    public function edit($id)
    {
        $simcard = Simcard::findOrFail($id);

        return view('DigitalEquipments.Simcards.edit', compact('simcard'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'type_use' => 'required|string',
            'number' => 'required|string|unique:simcards,number,' . $id,
            'pin' => 'required|string',
            'puk' => 'required|string',
            'serial' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $simcards = Simcard::findOrFail($id);
        $simcards->brand = $request->input('brand');
        $simcards->type_use = $request->input('type_use');
        $simcards->number = $request->input('number');
        $simcards->pin = $request->input('pin');
        $simcards->puk = $request->input('puk');
        $simcards->serial = $request->input('serial');
        $simcards->status = $request->input('status');
        $simcards->editor = $this->getMyUserId();
        $simcards->save();

        return redirect()->route('Simcards.index')->with('success', 'سیمکارت با موفقیت ویرایش شد.');
    }
}
