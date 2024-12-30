<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\Publication;
use Illuminate\Http\Request;

class PublicationController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست انتشارات', ['only' => ['index']]);
        $this->middleware('permission:ایجاد انتشارات', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش انتشارات', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف انتشارات', ['only' => ['destroy']]);
    }

    public function index()
    {
        $publications = Publication::orderBy('name', 'asc')->get();
        return view('Catalogs.Publications.index', compact('publications'));
    }

    public function create()
    {
        return view('Catalogs.Publications.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:publications,name',
        ]);

        $publication = Publication::create(['name' => $request->input('name'), 'adder' => $this->getMyUserId()]);

        if ($publication) {
            return redirect()->route('Publications.index')->with('success', 'انتشارات با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد انتشارات']);
    }

    public function edit($id)
    {
        $publication = Publication::findOrFail($id);

        return view('Catalogs.Publications.edit', compact('publication'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:publications,id',
        ]);

        $publication = Publication::findOrFail($id);
        $publication->name = $request->input('name');
        $publication->status = $request->input('status');
        $publication->editor = $this->getMyUserId();
        $publication->save();

        return redirect()->route('Publications.index')->with('success', 'انتشارات با موفقیت ویرایش شد.');
    }
}
