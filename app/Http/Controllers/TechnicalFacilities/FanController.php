<?php

namespace App\Http\Controllers\TechnicalFacilities;

use App\Http\Controllers\Controller;
use App\Models\TechnicalFacilities\Fan;
use Illuminate\Http\Request;

class FanController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست پنکه', ['only' => ['index']]);
        $this->middleware('permission:ایجاد پنکه', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش پنکه', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف پنکه', ['only' => ['destroy']]);
    }

    public function index()
    {
        $fans = Fan::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('TechnicalFacilities.Fans.index', compact('fans'));
    }

    public function create()
    {
        return view('TechnicalFacilities.Fans.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $fans = Fan::create(['model' => $request->input('model'), 'brand' => $request->input('brand'), 'type' => $request->input('type'), 'adder' => $this->getMyUserId()]);

        if ($fans) {
            return redirect()->route('Fans.index')->with('success', 'پنکه با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد پنکه']);
    }

    public function edit($id)
    {
        $fan = Fan::findOrFail($id);

        return view('TechnicalFacilities.Fans.edit', compact('fan'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:fans,id',
            'model' => 'required|string',
            'type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $fans = Fan::findOrFail($id);
        $fans->brand = $request->input('brand');
        $fans->model = $request->input('model');
        $fans->type = $request->input('type');
        $fans->status = $request->input('status');
        $fans->editor = $this->getMyUserId();
        $fans->save();

        return redirect()->route('Fans.index')->with('success', 'پنکه با موفقیت ویرایش شد.');
    }
}
