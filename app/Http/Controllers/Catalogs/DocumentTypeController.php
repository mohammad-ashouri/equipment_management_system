<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\DocumentType;
use Illuminate\Http\Request;
use PhpParser\Comment\Doc;

class DocumentTypeController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست انواع سند', ['only' => ['index']]);
        $this->middleware('permission:ایجاد نوع سند', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش نوع سند', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف نوع سند', ['only' => ['destroy']]);
    }

    public function index()
    {
        $documentTypes = DocumentType::orderBy('name', 'asc')->paginate(10);
        return view('Catalogs.DocumentTypes.index', compact('documentTypes'));
    }

    public function create()
    {
        return view('Catalogs.DocumentTypes.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:document_types,name',
        ]);

        $documentType = DocumentType::create(['name' => $request->input('name'), 'adder' => $this->getMyUserId()]);

        if ($documentType) {
            return redirect()->route('DocumentTypes.index')->with('success', 'نوع سند با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد نوع سند']);
    }

    public function edit($id)
    {
        $documentType = DocumentType::find($id);

        return view('Catalogs.DocumentTypes.edit', compact('documentType'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'status' => 'required|integer|in:0,1',
        ]);

        $role = DocumentType::find($id);
        $role->name = $request->input('name');
        $role->status = $request->input('status');
        $role->editor = $this->getMyUserId();
        $role->save();

        return redirect()->route('DocumentTypes.index')->with('success', 'نوع سند با موفقیت ویرایش شد.');
    }
}
