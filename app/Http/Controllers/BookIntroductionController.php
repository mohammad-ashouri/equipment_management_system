<?php

namespace App\Http\Controllers;

use App\Models\BookIntroduction;
use App\Models\Picture;
use Illuminate\Http\Request;

class BookIntroductionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:لیست معرفی کتاب', ['only' => ['index']]);
        $this->middleware('permission:ایجاد معرفی کتاب', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش معرفی کتاب', ['only' => ['edit', 'update']]);
        $this->middleware('permission:حذف معرفی کتاب', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        if (empty($request->all())) {
            $bookIntroductions = BookIntroduction::with('adderInfo', 'editorInfo')->orderByDesc('id')->paginate(50);
        } else {
            $bookIntroductions = $this->searchControl($request);
        }
        return view('Posts.BookIntroductions.index', compact('bookIntroductions'));
    }

    public function create()
    {
        $categories = $this->getAllNonPostCategories();
        return view('Posts.BookIntroductions.create', compact('categories'));
    }

    public function checkSimilarBookIntroductionsIfExists($booksArray = []): false|string|null
    {
        if (!empty($booksArray) and count($booksArray) > 0) {
            $checkedBooks = [];
            foreach ($booksArray as $books) {
                if (BookIntroduction::where('id', $books)->where('status', 1)->first() == null) {
                    continue;
                }
                $bookId = BookIntroduction::where('id', $books)->where('status', 1)->select('id')->first();
                if (!empty($bookId)) {
                    $checkedBooks[] = $bookId->id;
                }
            }
            return json_encode(array_unique($checkedBooks), true);
        }
        return null;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'status' => 'required|integer|in:1,2',
            'chosen' => 'required|integer|in:0,1',
            'slider' => 'required|integer|in:0,1',
            'body' => 'required|string',
            'book_title' => 'required|string',
            'author' => 'required|string',
            'publisher' => 'required|string',
            'subjects' => 'required|string',
            'keywords' => 'required|string',
            'hint' => 'required|string',
            'related_items' => 'array',
            'related_items.*' => 'required|string',
            'post_types' => 'array',
            'post_types.*' => 'required|integer|exists:post_types,id',
            'links' => 'array',
            'links.*' => 'required|string',
            'similar_books' => 'array',
            'similar_books.*' => 'required',
            'main_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'child_images' => 'array',
            'child_images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);

        $bookIntroduction = new BookIntroduction();
        $bookIntroduction->title = $request->title;
        $bookIntroduction->status = $request->status;
        $bookIntroduction->chosen = $request->chosen;

        if ($request->status == 2) {
            $bookIntroduction->draft_token = $this->makeTokenForDraft('notes');
        } else {
            $bookIntroduction->draft_token = null;
        }

        $bookIntroduction->body = $request->body;
        $bookIntroduction->book_title = $request->book_title;
        $bookIntroduction->author = $request->author;
        $bookIntroduction->publisher = $request->publisher;
        $bookIntroduction->subjects = $request->subjects;
        $bookIntroduction->keywords = $this->jsonEncodeArrays($request->keywords);
        $bookIntroduction->hint = $request->hint;
        $bookIntroduction->related_items = $this->saveRelatedItems($request->related_items, $request->post_types, $request->links);
        $bookIntroduction->similar_books = $this->checkSimilarBookIntroductionsIfExists($request->similar_books);
        $bookIntroduction->adder = $this->getMyUserId();
        $bookIntroduction->save();

        if ($request->hasFile('slider_image')) {
            $this->sliderManagement($request->slider, 'BookIntroduction', $bookIntroduction->id, $request->slider_image);
        }

        $id = $bookIntroduction->id;
        if ($request->hasFile('main_image')) {
            $path = $request->file('main_image')->store('public/uploads/BookIntroductions/' . $id);
            $this->savePictures($id, "book_introductions", 'picture_main', str_replace('public', '/storage', $path));
        }

        if ($request->hasFile('child_images')) {
            foreach ($request->file('child_images') as $file) {
                $path = $file->store('public/uploads/BookIntroductions/' . $id);
                $this->savePictures($id, "book_introductions", 'picture_child', str_replace('public', '/storage', $path));
            }
        }

        return redirect()->back()->with('success', "معرفی کتاب با کد $id با موفقیت ایجاد شد.");
    }

    public function edit($id)
    {
        $bookIntroduction = BookIntroduction::with('mainImage', 'childImages', 'adderInfo', 'editorInfo', 'sliderImage')->find($id);
        $categories = $this->getAllNonPostCategories();
        $bookIntroductions = [];

        if (!empty($bookIntroduction->similar_books)) {
            $bookIntroductions = BookIntroduction::whereIn('id', json_decode($bookIntroduction->similar_books, true))->get();
        }
        return view('Posts.BookIntroductions.edit', compact('bookIntroduction', 'categories', 'bookIntroductions'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|integer|exists:book_introductions,id',
            'title' => 'required|string',
            'status' => 'required|integer|in:1,2',
            'chosen' => 'required|integer|in:0,1',
            'slider' => 'required|integer|in:0,1',
            'body' => 'required|string',
            'book_title' => 'required|string',
            'author' => 'required|string',
            'publisher' => 'required|string',
            'subjects' => 'required|string',
            'keywords' => 'required|string',
            'hint' => 'required|string',
            'related_items' => 'array',
            'related_items.*' => 'required|string',
            'post_types' => 'array',
            'post_types.*' => 'required|integer|exists:post_types,id',
            'links' => 'array',
            'links.*' => 'required|string',
            'similar_books' => 'array',
            'similar_books.*' => 'required',
            'main_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'child_images' => 'array',
            'child_images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);

        $id = $request->id;
        $bookIntroduction = BookIntroduction::find($id);
        $bookIntroduction->title = $request->title;
        $bookIntroduction->status = $request->status;
        $bookIntroduction->chosen = $request->chosen;

        if ($request->status == 2) {
            $bookIntroduction->draft_token = $this->makeTokenForDraft('notes');
        } else {
            $bookIntroduction->draft_token = null;
        }

        $bookIntroduction->body = $request->body;
        $bookIntroduction->book_title = $request->book_title;
        $bookIntroduction->author = $request->author;
        $bookIntroduction->publisher = $request->publisher;
        $bookIntroduction->subjects = $request->subjects;
        $bookIntroduction->keywords = $this->jsonEncodeArrays($request->keywords);
        $bookIntroduction->similar_books = $this->checkSimilarBookIntroductionsIfExists($request->book_introductions);
        $bookIntroduction->related_items = $this->saveRelatedItems($request->related_items, $request->post_types, $request->links);
        $bookIntroduction->hint = $request->hint;
        $bookIntroduction->editor = $this->getMyUserId();
        $bookIntroduction->save();

        if ($request->hasFile('slider_image') and $request->slider == 1) {
            $this->sliderManagement($request->slider, 'BookIntroduction', $bookIntroduction->id, $request->slider_image);
        } elseif ($request->slider == 0) {
            $this->sliderManagement($request->slider, 'BookIntroduction', $bookIntroduction->id);
        }

        if ($request->hasFile('main_image')) {
            $path = $request->file('main_image')->store('public/uploads/BookIntroductions/' . $id);
            Picture::where('post_type', 'book_introductions')->where('image_type', 'picture_main')->where('post_id', $bookIntroduction->id)->delete();
            $this->savePictures($bookIntroduction->id, "book_introductions", 'picture_main', str_replace('public', '/storage', $path));
        }

        if ($request->hasFile('child_images')) {
            foreach ($request->file('child_images') as $file) {
                $path = $file->store('public/uploads/BookIntroductions/' . $id);
                $this->savePictures($bookIntroduction->id, "book_introductions", 'picture_child', str_replace('public', '/storage', $path));
            }
        }

        return redirect()->back()->with('success', "معرفی کتاب با کد $id با موفقیت ویرایش شد.");
    }

    public function destroy($id)
    {
        $delete = BookIntroduction::where('id', $id)->delete();
        if ($delete) {
            $this->deleteSliderAfterDeletePost('book_introductions', $id);
            return redirect()->back()->with('success', 'معرفی کتاب با موفقیت حذف شد!');
        }
        return redirect()->back()->withErrors(['errors' => 'حذف معرفی کتاب با مشکل مواجه شد!']);
    }

    public function destroyImage($id)
    {
        $delete = Picture::where('id', $id)->delete();
        if ($delete) {
            return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'fail']);
    }

    public function show($id): \Illuminate\Http\JsonResponse
    {
        $book = BookIntroduction::where('id', $id)->where('status', 1)->first();
        if (empty($book)) {
            return response()->json([null]);
        }
        return response()->json($book);
    }
}
