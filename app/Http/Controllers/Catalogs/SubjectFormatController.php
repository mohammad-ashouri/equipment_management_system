<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\SubjectFormat;
use Illuminate\Http\Request;

class SubjectFormatController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست قالب سوژه ها', ['only' => ['index']]);
        $this->middleware('permission:ایجاد قالب سوژه ها', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش قالب سوژه ها', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف قالب سوژه ها', ['only' => ['destroy']]);
    }

    public function index()
    {
        $subjectFormats = SubjectFormat::orderBy('name', 'asc')->paginate(10);
        return view('Catalogs.SubjectFormats.index', compact('subjectFormats'));
    }

    public function create()
    {
        return view('Catalogs.SubjectFormats.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:subject_formats,name',
        ]);

        $subjectFormat = SubjectFormat::create(['name' => $request->input('name'), 'adder' => $this->getMyUserId()]);

        if ($subjectFormat) {
            return redirect()->route('SubjectFormats.index')->with('success', 'قالب سوژه با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد قالب سوژه']);
    }

    public function edit($id)
    {
        $subjectFormat = SubjectFormat::find($id);

        return view('Catalogs.SubjectFormats.edit', compact('subjectFormat'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'status' => 'required|integer|in:0,1',
        ]);

        $subjectFormat = SubjectFormat::find($id);
        $subjectFormat->name = $request->input('name');
        $subjectFormat->status = $request->input('status');
        $subjectFormat->editor = $this->getMyUserId();
        $subjectFormat->save();

        return redirect()->route('SubjectFormats.index')->with('success', 'قالب سوژه با موفقیت ویرایش شد.');
    }
}
