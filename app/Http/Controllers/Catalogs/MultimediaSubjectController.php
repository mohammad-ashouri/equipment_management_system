<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\MultimediaSubject;
use Illuminate\Http\Request;

class MultimediaSubjectController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست موضوع چند رسانه ای', ['only' => ['index']]);
        $this->middleware('permission:ایجاد موضوع چند رسانه ای', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش موضوع چند رسانه ای', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف موضوع چند رسانه ای', ['only' => ['destroy']]);
    }

    public function index()
    {
        $multimediaSubjects = MultimediaSubject::orderBy('name', 'asc')->paginate(10);
        return view('Catalogs.MultimediaSubjects.index', compact('multimediaSubjects'));
    }

    public function create()
    {
        return view('Catalogs.MultimediaSubjects.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:multimedia_subjects,name',
        ]);

        $multimediaSubject = MultimediaSubject::create(['name' => $request->input('name'), 'adder' => $this->getMyUserId()]);

        if ($multimediaSubject) {
            return redirect()->route('MultimediaSubjects.index')->with('success', 'موضوع چندرسانه ای با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد موضوع چندرسانه ای']);
    }

    public function edit($id)
    {
        $multimediaSubject = MultimediaSubject::find($id);

        return view('Catalogs.MultimediaSubjects.edit', compact('multimediaSubject'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'status' => 'required|integer|in:0,1',
        ]);

        $multimediaSubject = MultimediaSubject::find($id);
        $multimediaSubject->name = $request->input('name');
        $multimediaSubject->status = $request->input('status');
        $multimediaSubject->editor = $this->getMyUserId();
        $multimediaSubject->save();

        return redirect()->route('MultimediaSubjects.index')->with('success', 'موضوع چندرسانه ای با موفقیت ویرایش شد.');
    }
}
