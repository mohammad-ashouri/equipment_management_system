<?php

namespace App\Http\Controllers\TechnicalFacilities;

use App\Http\Controllers\Controller;
use App\Models\TechnicalFacilities\WhiteboardHolder;
use Illuminate\Http\Request;

class WhiteboardHolderController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست پایه تخته وایت بورد', ['only' => ['index']]);
        $this->middleware('permission:ایجاد پایه تخته وایت بورد', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش پایه تخته وایت بورد', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف پایه تخته وایت بورد', ['only' => ['destroy']]);
    }

    public function index()
    {
        $whiteboardHolders = WhiteboardHolder::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('TechnicalFacilities.WhiteboardHolders.index', compact('whiteboardHolders'));
    }

    public function create()
    {
        return view('TechnicalFacilities.WhiteboardHolders.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'material' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $whiteboardHolders = WhiteboardHolder::create([
            'model' => $request->input('model'),
            'brand' => $request->input('brand'),
            'material' => $request->input('material'),
            'adder' => $this->getMyUserId()
        ]);

        if ($whiteboardHolders) {
            return redirect()->route('WhiteboardHolders.index')->with('success', 'پایه تخته وایت بورد با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد پایه تخته وایت بورد']);
    }

    public function edit($id)
    {
        $whiteboardHolder = WhiteboardHolder::findOrFail($id);

        return view('TechnicalFacilities.WhiteboardHolders.edit', compact('whiteboardHolder'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:whiteboard_holders,id',
            'model' => 'required|string',
            'material' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $whiteboardHolders = WhiteboardHolder::findOrFail($id);
        $whiteboardHolders->brand = $request->input('brand');
        $whiteboardHolders->model = $request->input('model');
        $whiteboardHolders->material = $request->input('material');
        $whiteboardHolders->status = $request->input('status');
        $whiteboardHolders->editor = $this->getMyUserId();
        $whiteboardHolders->save();

        return redirect()->route('WhiteboardHolders.index')->with('success', 'پایه تخته وایت بورد با موفقیت ویرایش شد.');
    }
}
