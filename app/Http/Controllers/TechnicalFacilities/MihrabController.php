<?php

namespace App\Http\Controllers\TechnicalFacilities;

use App\Http\Controllers\Controller;
use App\Models\TechnicalFacilities\Mihrab;
use Illuminate\Http\Request;

class MihrabController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست محراب', ['only' => ['index']]);
        $this->middleware('permission:ایجاد محراب', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش محراب', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف محراب', ['only' => ['destroy']]);
    }

    public function index()
    {
        $mihrabs = Mihrab::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('TechnicalFacilities.Mihrabs.index', compact('mihrabs'));
    }

    public function create()
    {
        return view('TechnicalFacilities.Mihrabs.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'material' => 'required|string',
            'width' => 'required|integer',
            'height' => 'required|integer',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $mihrabs = Mihrab::create([
            'model' => $request->input('model'),
            'brand' => $request->input('brand'),
            'material' => $request->input('material'),
            'width' => $request->input('width'),
            'height' => $request->input('height'),
            'adder' => $this->getMyUserId()
        ]);

        if ($mihrabs) {
            return redirect()->route('Mihrabs.index')->with('success', 'محراب با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد محراب']);
    }

    public function edit($id)
    {
        $mihrab = Mihrab::findOrFail($id);

        return view('TechnicalFacilities.Mihrabs.edit', compact('mihrab'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:mihrabs,id',
            'model' => 'required|string',
            'material' => 'required|string',
            'width' => 'required|integer',
            'height' => 'required|integer',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $mihrab = Mihrab::findOrFail($id);
        $mihrab->brand = $request->input('brand');
        $mihrab->model = $request->input('model');
        $mihrab->material = $request->input('material');
        $mihrab->width = $request->input('width');
        $mihrab->height = $request->input('height');
        $mihrab->status = $request->input('status');
        $mihrab->editor = $this->getMyUserId();
        $mihrab->save();

        return redirect()->route('Mihrabs.index')->with('success', 'محراب با موفقیت ویرایش شد.');
    }
}
