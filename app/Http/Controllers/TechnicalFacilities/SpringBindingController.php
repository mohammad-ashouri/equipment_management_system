<?php

namespace App\Http\Controllers\TechnicalFacilities;

use App\Http\Controllers\Controller;
use App\Models\TechnicalFacilities\SpringBinding;
use Illuminate\Http\Request;

class SpringBindingController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست فنرزن کاغذ', ['only' => ['index']]);
        $this->middleware('permission:ایجاد فنرزن کاغذ', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش فنرزن کاغذ', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف فنرزن کاغذ', ['only' => ['destroy']]);
    }

    public function index()
    {
        $springBindings = SpringBinding::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('TechnicalFacilities.SpringBindings.index', compact('springBindings'));
    }

    public function create()
    {
        return view('TechnicalFacilities.SpringBindings.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $springBindings = SpringBinding::create(['model' => $request->input('model'), 'brand' => $request->input('brand'), 'type' => $request->input('type'), 'adder' => $this->getMyUserId()]);

        if ($springBindings) {
            return redirect()->route('SpringBindings.index')->with('success', 'فنرزن کاغذ با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد فنرزن کاغذ']);
    }

    public function edit($id)
    {
        $springBinding = SpringBinding::findOrFail($id);

        return view('TechnicalFacilities.SpringBindings.edit', compact('springBinding'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:spring_bindings,id',
            'model' => 'required|string',
            'type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $springBindings = SpringBinding::findOrFail($id);
        $springBindings->brand = $request->input('brand');
        $springBindings->model = $request->input('model');
        $springBindings->type = $request->input('type');
        $springBindings->status = $request->input('status');
        $springBindings->editor = $this->getMyUserId();
        $springBindings->save();

        return redirect()->route('SpringBindings.index')->with('success', 'فنرزن کاغذ با موفقیت ویرایش شد.');
    }
}
