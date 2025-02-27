<?php

namespace App\Http\Controllers\NetworkEquipments;

use App\Http\Controllers\Controller;
use App\Models\NetworkEquipments\Nvr;
use Illuminate\Http\Request;

class NvrController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست nvr', ['only' => ['index']]);
        $this->middleware('permission:ایجاد nvr', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش nvr', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف nvr', ['only' => ['destroy']]);
    }

    public function index()
    {
        $nvrs = Nvr::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('NetworkEquipments.Nvrs.index', compact('nvrs'));
    }

    public function create()
    {
        return view('NetworkEquipments.Nvrs.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'channels_number' => 'required|integer',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $nvrs = Nvr::create(['model' => $request->input('model'),
            'brand' => $request->input('brand'),
            'channels_number' => $request->input('channels_number'),
            'adder' => $this->getMyUserId()]);

        if ($nvrs) {
            return redirect()->route('Nvrs.index')->with('success', 'nvr با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد nvr']);
    }

    public function edit($id)
    {
        $nvr = Nvr::findOrFail($id);

        return view('NetworkEquipments.Nvrs.edit', compact('nvr'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:nvrs,id',
            'model' => 'required|string',
            'channels_number' => 'required|integer',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $nvrs = Nvr::findOrFail($id);
        $nvrs->brand = $request->input('brand');
        $nvrs->model = $request->input('model');
        $nvrs->channels_number = $request->input('channels_number');
        $nvrs->status = $request->input('status');
        $nvrs->editor = $this->getMyUserId();
        $nvrs->save();

        return redirect()->route('Nvrs.index')->with('success', 'nvr با موفقیت ویرایش شد.');
    }
}
