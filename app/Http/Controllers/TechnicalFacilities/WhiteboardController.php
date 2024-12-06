<?php

namespace App\Http\Controllers\TechnicalFacilities;

use App\Http\Controllers\Controller;
use App\Models\TechnicalFacilities\Whiteboard;
use Illuminate\Http\Request;

class WhiteboardController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست تخته وایت بورد', ['only' => ['index']]);
        $this->middleware('permission:ایجاد تخته وایت بورد', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش تخته وایت بورد', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف تخته وایت بورد', ['only' => ['destroy']]);
    }

    public function index()
    {
        $whiteboards = Whiteboard::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('TechnicalFacilities.Whiteboards.index', compact('whiteboards'));
    }

    public function create()
    {
        return view('TechnicalFacilities.Whiteboards.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'material' => 'required|string',
            'width' => 'required|integer',
            'length' => 'required|integer',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $whiteboards = Whiteboard::create(['model' => $request->input('model'), 'brand' => $request->input('brand'), 'material' => $request->input('material'), 'width' => $request->input('width'), 'length' => $request->input('length'), 'adder' => $this->getMyUserId()]);

        if ($whiteboards) {
            return redirect()->route('Whiteboards.index')->with('success', 'تخته وایت بورد با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد تخته وایت بورد']);
    }

    public function edit($id)
    {
        $whiteboard = Whiteboard::findOrFail($id);

        return view('TechnicalFacilities.Whiteboards.edit', compact('whiteboard'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:whiteboards,id',
            'model' => 'required|string',
            'material' => 'required|string',
            'width' => 'required|integer',
            'length' => 'required|integer',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $whiteboards = Whiteboard::findOrFail($id);
        $whiteboards->brand = $request->input('brand');
        $whiteboards->model = $request->input('model');
        $whiteboards->material = $request->input('material');
        $whiteboards->width = $request->input('width');
        $whiteboards->length = $request->input('length');
        $whiteboards->status = $request->input('status');
        $whiteboards->editor = $this->getMyUserId();
        $whiteboards->save();

        return redirect()->route('Whiteboards.index')->with('success', 'تخته وایت بورد با موفقیت ویرایش شد.');
    }
}
