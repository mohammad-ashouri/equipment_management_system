<?php

namespace App\Http\Controllers\TechnicalFacilities;

use App\Http\Controllers\Controller;
use App\Models\TechnicalFacilities\Shredder;
use Illuminate\Http\Request;

class ShredderController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست کاغذ خردکن', ['only' => ['index']]);
        $this->middleware('permission:ایجاد کاغذ خردکن', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش کاغذ خردکن', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف کاغذ خردکن', ['only' => ['destroy']]);
    }

    public function index()
    {
        $shredders = Shredder::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('TechnicalFacilities.Shredders.index', compact('shredders'));
    }

    public function create()
    {
        return view('TechnicalFacilities.Shredders.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $shredders = Shredder::create(['model' => $request->input('model'), 'brand' => $request->input('brand'), 'type' => $request->input('type'), 'adder' => $this->getMyUserId()]);

        if ($shredders) {
            return redirect()->route('Shredders.index')->with('success', 'کاغذ خردکن با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد کاغذ خردکن']);
    }

    public function edit($id)
    {
        $shredder = Shredder::findOrFail($id);

        return view('TechnicalFacilities.Shredders.edit', compact('shredder'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:shredders,id',
            'model' => 'required|string',
            'type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $shredders = Shredder::findOrFail($id);
        $shredders->brand = $request->input('brand');
        $shredders->model = $request->input('model');
        $shredders->type = $request->input('type');
        $shredders->status = $request->input('status');
        $shredders->editor = $this->getMyUserId();
        $shredders->save();

        return redirect()->route('Shredders.index')->with('success', 'کاغذ خردکن با موفقیت ویرایش شد.');
    }
}
