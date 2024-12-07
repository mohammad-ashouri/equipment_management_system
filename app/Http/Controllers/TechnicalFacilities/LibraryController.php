<?php

namespace App\Http\Controllers\TechnicalFacilities;

use App\Http\Controllers\Controller;
use App\Models\TechnicalFacilities\Library;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست کتابخانه', ['only' => ['index']]);
        $this->middleware('permission:ایجاد کتابخانه', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش کتابخانه', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف کتابخانه', ['only' => ['destroy']]);
    }

    public function index()
    {
        $libraries = Library::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('TechnicalFacilities.Libraries.index', compact('libraries'));
    }

    public function create()
    {
        return view('TechnicalFacilities.Libraries.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'material' => 'required|string',
            'floors_number' => 'required|integer',
            'doors_number' => 'required|integer',
            'closets_number' => 'required|integer',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $library = Library::create([
            'model' => $request->input('model'),
            'brand' => $request->input('brand'),
            'material' => $request->input('material'),
            'floors_number' => $request->input('floors_number'),
            'doors_number' => $request->input('doors_number'),
            'closets_number' => $request->input('closets_number'),
            'adder' => $this->getMyUserId()
        ]);

        if ($library) {
            return redirect()->route('Libraries.index')->with('success', 'کتابخانه با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد کتابخانه']);
    }

    public function edit($id)
    {
        $library = Library::findOrFail($id);

        return view('TechnicalFacilities.Libraries.edit', compact('library'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:libraries,id',
            'model' => 'required|string',
            'material' => 'required|string',
            'floors_number' => 'required|integer',
            'doors_number' => 'required|integer',
            'closets_number' => 'required|integer',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $library = Library::findOrFail($id);
        $library->brand = $request->input('brand');
        $library->model = $request->input('model');
        $library->material = $request->input('material');
        $library->floors_number = $request->input('floors_number');
        $library->doors_number = $request->input('doors_number');
        $library->closets_number = $request->input('closets_number');
        $library->status = $request->input('status');
        $library->editor = $this->getMyUserId();
        $library->save();

        return redirect()->route('Libraries.index')->with('success', 'کتابخانه با موفقیت ویرایش شد.');
    }
}
