<?php

namespace App\Http\Controllers\TechnicalFacilities;

use App\Http\Controllers\Controller;
use App\Models\TechnicalFacilities\Microwave;
use Illuminate\Http\Request;

class MicrowaveController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست مایکروفر', ['only' => ['index']]);
        $this->middleware('permission:ایجاد مایکروفر', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش مایکروفر', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف مایکروفر', ['only' => ['destroy']]);
    }

    public function index()
    {
        $ladders = Microwave::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('TechnicalFacilities.Microwaves.index', compact('ladders'));
    }

    public function create()
    {
        return view('TechnicalFacilities.Microwaves.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $ladder = Microwave::create([
            'model' => $request->input('model'),
            'brand' => $request->input('brand'),
            'adder' => $this->getMyUserId()
        ]);

        if ($ladder) {
            return redirect()->route('Microwaves.index')->with('success', 'مایکروفر با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد مایکروفر']);
    }

    public function edit($id)
    {
        $ladder = Microwave::findOrFail($id);

        return view('TechnicalFacilities.Microwaves.edit', compact('ladder'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:ladders,id',
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $ladder = Microwave::findOrFail($id);
        $ladder->brand = $request->input('brand');
        $ladder->model = $request->input('model');
        $ladder->status = $request->input('status');
        $ladder->editor = $this->getMyUserId();
        $ladder->save();

        return redirect()->route('Microwaves.index')->with('success', 'مایکروفر با موفقیت ویرایش شد.');
    }
}
