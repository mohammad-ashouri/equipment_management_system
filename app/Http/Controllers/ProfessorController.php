<?php

namespace App\Http\Controllers;

use App\Models\Picture;
use App\Models\Professor;
use Illuminate\Http\Request;

class ProfessorController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:لیست اساتید', ['only' => ['index']]);
        $this->middleware('permission:ایجاد اساتید', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش اساتید', ['only' => ['edit', 'update']]);
        $this->middleware('permission:حذف اساتید', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        if (empty($request->all())) {
            $professors = Professor::with('adderInfo', 'editorInfo')->orderByDesc('id')->paginate(50);
        } else {
            $professors = $this->searchControl($request);
        }
        return view('Posts.Professors.index', compact('professors'));
    }

    public function create()
    {
        $categories = $this->getAllNonPostCategories();
        $adjectives = $this->getAllPersonAdjectives();
        return view('Posts.Professors.create', compact('categories', 'adjectives'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'status' => 'required|integer|in:1,2',
            'chosen' => 'required|integer|in:0,1',
            'slider' => 'required|integer|in:0,1',
            'body' => 'required|string',
            'adjective' => 'required|string',
            'speciality' => 'required|string',
            'books' => 'array',
            'books.*' => 'nullable|string',
            'articles' => 'array',
            'articles.*' => 'nullable|string',
            'keywords' => 'required|string',
            'main_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'child_images' => 'array',
            'child_images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);

        $professor = new Professor();
        $professor->title = $request->title;
        $professor->status = $request->status;
        $professor->chosen = $request->chosen;

        if ($request->status == 2) {
            $professor->draft_token = $this->makeTokenForDraft('notes');
        } else {
            $professor->draft_token = null;
        }

        $professor->body = $request->body;
        $professor->adjective = $request->adjective;
        $professor->speciality = $request->speciality;
        if (!empty($request->books)) {
            $books = array_filter($request->books, function ($value) {
                return !empty($value) && trim($value) !== '';
            });
            $professor->books = json_encode($books, true);
        } else {
            $professor->books = null;
        }

        if (!empty($request->articles)) {
            $articles = array_filter($request->articles, function ($value) {
                return !empty($value) && trim($value) !== '';
            });
            $professor->articles = json_encode($articles, true);
        } else {
            $professor->articles = null;
        }
        $professor->keywords = $this->jsonEncodeArrays($request->keywords);
        $professor->adder = $this->getMyUserId();
        $professor->save();

        $id = $professor->id;
        if ($request->hasFile('main_image')) {
            $path = $request->file('main_image')->store('public/uploads/Professors/' . $id);
            $this->savePictures($id, "professor", 'picture_main', str_replace('public', '/storage', $path));
        }

        if ($request->hasFile('child_images')) {
            foreach ($request->file('child_images') as $file) {
                $path = $file->store('public/uploads/Professors/' . $id);
                $this->savePictures($id, "professor", 'picture_child', str_replace('public', '/storage', $path));
            }
        }

        if ($request->hasFile('slider_image')) {
            $this->sliderManagement($request->slider, 'Professor', $professor->id);
        }
        return redirect()->back()->with('success', "استاد با کد $id با موفقیت ایجاد شد.");
    }

    public function edit($id)
    {
        $professor = Professor::with('mainImage', 'childImages', 'adderInfo', 'editorInfo', 'sliderImage')->find($id);
        $adjectives = $this->getAllPersonAdjectives();
        $categories = $this->getAllNonPostCategories();
        return view('Posts.Professors.edit', compact('professor', 'categories', 'adjectives'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|integer|exists:professors,id',
            'title' => 'required|string',
            'status' => 'required|integer|in:1,2',
            'chosen' => 'required|integer|in:0,1',
            'slider' => 'required|integer|in:0,1',
            'body' => 'required|string',
            'adjective' => 'required|string',
            'speciality' => 'required|string',
            'keywords' => 'required|string',
            'books' => 'array',
            'books.*' => 'nullable|string',
            'articles' => 'array',
            'articles.*' => 'nullable|string',
            'main_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'child_images' => 'array',
            'child_images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);

        $id = $request->id;
        $professor = Professor::find($id);
        $professor->title = $request->title;
        $professor->status = $request->status;
        $professor->chosen = $request->chosen;

        if ($request->status == 2) {
            $professor->draft_token = $this->makeTokenForDraft('notes');
        } else {
            $professor->draft_token = null;
        }

        $professor->body = $request->body;
        $professor->adjective = $request->adjective;
        $professor->speciality = $request->speciality;

        if (!empty($request->books)) {
            $books = array_filter($request->books, function ($value) {
                return !empty($value) && trim($value) !== '';
            });
            $professor->books = json_encode($books, true);
        } else {
            $professor->books = null;
        }

        if (!empty($request->articles)) {
            $articles = array_filter($request->articles, function ($value) {
                return !empty($value) && trim($value) !== '';
            });
            $professor->articles = json_encode($articles, true);
        } else {
            $professor->articles = null;
        }
        $professor->keywords = $this->jsonEncodeArrays($request->keywords);
        $professor->editor = $this->getMyUserId();
        $professor->save();


        if ($request->hasFile('main_image')) {
            $path = $request->file('main_image')->store('public/uploads/Professors/' . $id);
            Picture::where('post_type', 'professor')->where('image_type', 'picture_main')->where('post_id', $professor->id)->delete();
            $this->savePictures($professor->id, "professor", 'picture_main', str_replace('public', '/storage', $path));
        }

        if ($request->hasFile('child_images')) {
            foreach ($request->file('child_images') as $file) {
                $path = $file->store('public/uploads/Professors/' . $id);
                $this->savePictures($professor->id, "professor", 'picture_child', str_replace('public', '/storage', $path));
            }
        }

        if ($request->hasFile('slider_image') and $request->slider == 1) {
            $this->sliderManagement($request->slider, 'Professor', $professor->id, $request->slider_image);
        } elseif ($request->slider == 0) {
            $this->sliderManagement($request->slider, 'Professor', $professor->id);
        }

        return redirect()->back()->with('success', "استاد با کد $id با موفقیت ویرایش شد.");
    }

    public function destroy($id)
    {
        $delete = Professor::where('id', $id)->delete();
        if ($delete) {
            $this->deleteSliderAfterDeletePost('professors', $id);
            return redirect()->back()->with('success', 'استاد با موفقیت حذف شد!');
        }
        return redirect()->back()->withErrors(['errors' => 'حذف استاد با مشکل مواجه شد!']);
    }

    public function destroyImage($id)
    {
        $delete = Picture::where('id', $id)->delete();
        if ($delete) {
            return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'fail']);
    }
}
