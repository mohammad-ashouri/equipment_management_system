<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\SubjectAudience;
use Illuminate\Http\Request;

class SubjectAudienceController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست مخاطب سوژه ها', ['only' => ['index']]);
        $this->middleware('permission:ایجاد مخاطب سوژه ها', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش مخاطب سوژه ها', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف مخاطب سوژه ها', ['only' => ['destroy']]);
    }

    public function index()
    {
        $subjectAudiences = SubjectAudience::orderBy('name', 'asc')->paginate(10);
        return view('Catalogs.SubjectAudiences.index', compact('subjectAudiences'));
    }

    public function create()
    {
        return view('Catalogs.SubjectAudiences.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:subject_formats,name',
        ]);

        $subjectAudience = SubjectAudience::create(['name' => $request->input('name'), 'adder' => $this->getMyUserId()]);

        if ($subjectAudience) {
            return redirect()->route('SubjectAudiences.index')->with('success', 'مخاطب سوژه با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد مخاطب سوژه']);
    }

    public function edit($id)
    {
        $subjectAudience = SubjectAudience::find($id);

        return view('Catalogs.SubjectAudiences.edit', compact('subjectAudience'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'status' => 'required|integer|in:0,1',
        ]);

        $subjectAudience = SubjectAudience::find($id);
        $subjectAudience->name = $request->input('name');
        $subjectAudience->status = $request->input('status');
        $subjectAudience->editor = $this->getMyUserId();
        $subjectAudience->save();

        return redirect()->route('SubjectAudiences.index')->with('success', 'مخاطب سوژه با موفقیت ویرایش شد.');
    }
}
