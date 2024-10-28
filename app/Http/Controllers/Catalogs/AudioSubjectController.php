<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\AudiosSubject;
use Illuminate\Http\Request;

class AudioSubjectController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست موضوعات صوت', ['only' => ['index']]);
        $this->middleware('permission:ایجاد موضوعات صوت', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش موضوعات صوت', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف موضوعات صوت', ['only' => ['destroy']]);
    }

    public function index()
    {
        $audiosSubjects = AudiosSubject::orderBy('name', 'asc')->paginate(10);
        return view('Catalogs.AudiosSubjects.index', compact('audiosSubjects'));
    }

    public function create()
    {
        return view('Catalogs.AudiosSubjects.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:audios_subjects,name',
        ]);

        $audiosSubject = AudiosSubject::create(['name' => $request->input('name'), 'adder' => $this->getMyUserId()]);

        if ($audiosSubject) {
            return redirect()->route('AudiosSubjects.index')->with('success', 'موضوع صوت با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد موضوع صوت']);
    }

    public function edit($id)
    {
        $audioSubject = AudiosSubject::find($id);

        return view('Catalogs.AudiosSubjects.edit', compact('audioSubject'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'status' => 'required|integer|in:0,1',
        ]);

        $audioSubject = AudiosSubject::find($id);
        $audioSubject->name = $request->input('name');
        $audioSubject->status = $request->input('status');
        $audioSubject->editor = $this->getMyUserId();
        $audioSubject->save();

        return redirect()->route('AudiosSubjects.index')->with('success', 'موضوع صوت با موفقیت ویرایش شد.');
    }
}
