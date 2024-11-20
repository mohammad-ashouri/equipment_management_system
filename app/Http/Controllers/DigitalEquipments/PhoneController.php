<?php

namespace App\Http\Controllers\DigitalEquipments;

use App\Http\Controllers\Controller;
use App\Models\DigitalEquipments\Phone;
use Illuminate\Http\Request;

class PhoneController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست تلفن رومیزی', ['only' => ['index']]);
        $this->middleware('permission:ایجاد تلفن رومیزی', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش تلفن رومیزی', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف تلفن رومیزی', ['only' => ['destroy']]);
    }

    public function index()
    {
        $phones = Phone::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('DigitalEquipments.Phones.index', compact('phones'));
    }

    public function create()
    {
        return view('DigitalEquipments.Phones.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $phones = Phone::create(['model' => $request->input('model'), 'brand' => $request->input('brand'), 'type' => $request->input('type'), 'adder' => $this->getMyUserId()]);

        if ($phones) {
            return redirect()->route('Phones.index')->with('success', 'تلفن رومیزی با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد تلفن رومیزی']);
    }

    public function edit($id)
    {
        $phone = Phone::findOrFail($id);

        return view('DigitalEquipments.Phones.edit', compact('phone'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:phones,id',
            'model' => 'required|string',
            'type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $phones = Phone::findOrFail($id);
        $phones->brand = $request->input('brand');
        $phones->model = $request->input('model');
        $phones->type = $request->input('type');
        $phones->status = $request->input('status');
        $phones->editor = $this->getMyUserId();
        $phones->save();

        return redirect()->route('Phones.index')->with('success', 'تلفن رومیزی با موفقیت ویرایش شد.');
    }
}
