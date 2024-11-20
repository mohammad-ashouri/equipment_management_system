<?php

namespace App\Http\Controllers\DigitalEquipments;

use App\Http\Controllers\Controller;
use App\Models\DigitalEquipments\Mobile;
use Illuminate\Http\Request;

class MobileController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست تلفن همراه', ['only' => ['index']]);
        $this->middleware('permission:ایجاد تلفن همراه', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش تلفن همراه', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف تلفن همراه', ['only' => ['destroy']]);
    }

    public function index()
    {
        $mobiles = Mobile::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('DigitalEquipments.Mobiles.index', compact('mobiles'));
    }

    public function create()
    {
        return view('DigitalEquipments.Mobiles.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'internal_memory' => 'required|string',
            'ram' => 'required|string',
            'simcard_number' => 'required|integer',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $mobiles = Mobile::create(['model' => $request->input('model'),
            'brand' => $request->input('brand'),
            'internal_memory' => $request->input('internal_memory'),
            'ram' => $request->input('ram'),
            'simcard_number' => $request->input('simcard_number'),
            'adder' => $this->getMyUserId()]);

        if ($mobiles) {
            return redirect()->route('Mobiles.index')->with('success', 'تلفن همراه با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد تلفن همراه']);
    }

    public function edit($id)
    {
        $mobile = Mobile::findOrFail($id);

        return view('DigitalEquipments.Mobiles.edit', compact('mobile'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:mobiles,id',
            'model' => 'required|string',
            'internal_memory' => 'required|string',
            'ram' => 'required|string',
            'simcard_number' => 'required|integer',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $mobiles = Mobile::findOrFail($id);
        $mobiles->brand = $request->input('brand');
        $mobiles->model = $request->input('model');
        $mobiles->internal_memory = $request->input('internal_memory');
        $mobiles->ram = $request->input('ram');
        $mobiles->simcard_number = $request->input('simcard_number');
        $mobiles->status = $request->input('status');
        $mobiles->editor = $this->getMyUserId();
        $mobiles->save();

        return redirect()->route('Mobiles.index')->with('success', 'تلفن همراه با موفقیت ویرایش شد.');
    }
}
