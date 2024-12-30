<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\BookSubject;
use Illuminate\Http\Request;

class BookSubjectController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست موضوعات کتاب', ['only' => ['index']]);
        $this->middleware('permission:ایجاد موضوعات کتاب', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش موضوعات کتاب', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف موضوعات کتاب', ['only' => ['destroy']]);
    }

    public function index()
    {
        $bookSubjects = BookSubject::orderBy('name', 'asc')->get();
        return view('Catalogs.BookSubjects.index', compact('bookSubjects'));
    }

    public function create()
    {
        return view('Catalogs.BookSubjects.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:book_subjects,name',
        ]);

        $bookSubject = BookSubject::create(['name' => $request->input('name'), 'adder' => $this->getMyUserId()]);

        if ($bookSubject) {
            return redirect()->route('BookSubjects.index')->with('success', 'موضوعات کتاب با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد موضوعات کتاب']);
    }

    public function edit($id)
    {
        $bookSubject = BookSubject::findOrFail($id);

        return view('Catalogs.BookSubjects.edit', compact('bookSubject'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:book_subjects,id',
        ]);

        $bookSubject = BookSubject::findOrFail($id);
        $bookSubject->name = $request->input('name');
        $bookSubject->status = $request->input('status');
        $bookSubject->editor = $this->getMyUserId();
        $bookSubject->save();

        return redirect()->route('BookSubjects.index')->with('success', 'موضوعات کتاب با موفقیت ویرایش شد.');
    }
}
