<?php

namespace App\Http\Controllers\TechnicalFacilities;

use App\Http\Controllers\Controller;
use App\Models\TechnicalFacilities\Ladder;
use Illuminate\Http\Request;

class LadderController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست نردبان', ['only' => ['index']]);
        $this->middleware('permission:ایجاد نردبان', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش نردبان', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف نردبان', ['only' => ['destroy']]);
    }

    public function index()
    {
        $ladders = Ladder::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('TechnicalFacilities.Ladders.index', compact('ladders'));
    }

    public function create()
    {
        return view('TechnicalFacilities.Ladders.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'material' => 'required|string',
            'stairs_number' => 'required|integer',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $ladder = Ladder::create([
            'model' => $request->input('model'),
            'material' => $request->input('material'),
            'stairs_number' => $request->input('stairs_number'),
            'brand' => $request->input('brand'),
            'adder' => $this->getMyUserId()
        ]);

        if ($ladder) {
            return redirect()->route('Ladders.index')->with('success', 'نردبان با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد نردبان']);
    }

    public function edit($id)
    {
        $ladder = Ladder::findOrFail($id);

        return view('TechnicalFacilities.Ladders.edit', compact('ladder'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:ladders,id',
            'model' => 'required|string',
            'material' => 'required|string',
            'stairs_number' => 'required|integer',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $ladder = Ladder::findOrFail($id);
        $ladder->brand = $request->input('brand');
        $ladder->model = $request->input('model');
        $ladder->material = $request->input('material');
        $ladder->stairs_number = $request->input('stairs_number');
        $ladder->status = $request->input('status');
        $ladder->editor = $this->getMyUserId();
        $ladder->save();

        return redirect()->route('Ladders.index')->with('success', 'نردبان با موفقیت ویرایش شد.');
    }
}
