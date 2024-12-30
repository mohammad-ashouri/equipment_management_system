<?php

namespace App\Http\Controllers\TechnicalFacilities;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\Publication;
use App\Models\TechnicalFacilities\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست کتاب', ['only' => ['index']]);
        $this->middleware('permission:ایجاد کتاب', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش کتاب', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف کتاب', ['only' => ['destroy']]);
    }

    public function index()
    {
        $books = Book::with(['publicationInfo', 'brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('TechnicalFacilities.Books.index', compact('books'));
    }

    public function create()
    {
        $publications = Publication::whereStatus(1)->get();
        return view('TechnicalFacilities.Books.create', compact('publications'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'publication' => 'required|integer|exists:publications,id',
            'writer' => 'required|string',
            'size' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $book = Book::create([
            'name' => $request->input('name'),
            'brand' => $request->input('brand'),
            'publication' => $request->input('publication'),
            'writer' => $request->input('writer'),
            'size' => $request->input('size'),
            'adder' => $this->getMyUserId()
        ]);

        if ($book) {
            return redirect()->route('Books.index')->with('success', 'کتاب با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد کتاب']);
    }

    public function edit($id)
    {
        $book = Book::findOrFail($id);
        $publications = Publication::whereStatus(1)->get();

        return view('TechnicalFacilities.Books.edit', compact('book','publications'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:books,id',
            'name' => 'required|string',
            'publication' => 'required|integer|exists:publications,id',
            'writer' => 'required|string',
            'size' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $book = Book::findOrFail($id);
        $book->brand = $request->input('brand');
        $book->name = $request->input('name');
        $book->publication = $request->input('publication');
        $book->writer = $request->input('writer');
        $book->size = $request->input('size');
        $book->status = $request->input('status');
        $book->editor = $this->getMyUserId();
        $book->save();

        return redirect()->route('Books.index')->with('success', 'کتاب با موفقیت ویرایش شد.');
    }
}
