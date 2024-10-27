<?php

namespace App\Http\Controllers;

use App\Models\Catalogs\Teacher;
use App\Models\DocumentClass;
use App\Models\Picture;
use Illuminate\Http\Request;

class DocumentClassController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:لیست کلاس اسناد', ['only' => ['index']]);
        $this->middleware('permission:ایجاد کلاس اسناد', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش کلاس اسناد', ['only' => ['edit', 'update']]);
        $this->middleware('permission:حذف کلاس اسناد', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        if (empty($request->all())) {
            $documentClasses = DocumentClass::with('adderInfo', 'editorInfo')->orderByDesc('id')->paginate(50);
        } else {
            $documentClasses = $this->searchControl($request);
        }
        return view('Posts.DocumentClasses.index', compact('documentClasses'));
    }

    public function create()
    {
        $teachers = Teacher::with('adjectiveInfo')->where('status', 1)->get();
        return view('Posts.DocumentClasses.create', compact('teachers'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'short_title' => 'required|string',
            'status' => 'required|integer|in:1,2',
            'chosen' => 'required|integer|in:0,1',
            'slider' => 'required|integer|in:0,1',
            'body' => 'required|string',
            'class_hours' => 'required|string',
            'class_minutes' => 'required|string',
            'main_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
//            'video' => 'required|file|mimes:avi,mp4,mpeg4,mkv,webp|max:204800',
            'topics' => 'array',
            'topics.*' => 'required|string',
            'aparats' => 'array',
            'aparats.*' => 'required|string',
            'teacher' => 'required|integer|exists:teachers,id',
        ]);

        $documentClass = new DocumentClass();
        $documentClass->title = $request->title;
        $documentClass->short_title = $request->short_title;
        $documentClass->status = $request->status;
        $documentClass->chosen = $request->chosen;

        if ($request->status == 2) {
            $documentClass->draft_token = $this->makeTokenForDraft('notes');
        } else {
            $documentClass->draft_token = null;
        }

        $documentClass->about_class = $request->body;
        $documentClass->teacher = $request->teacher;
        $documentClass->class_time = $request->class_hours . ':' . $request->class_minutes;
        $documentClass->adder = $this->getMyUserId();

        $topics = [];
        foreach (request('topics') as $index => $topic) {
            $topics[] = ['topic' => $topic, 'link' => $request['aparats'][$index]];
        }

        $documentClass->topics = json_encode($topics, true);
        $documentClass->save();

        $id = $documentClass->id;
        if ($request->hasFile('main_image')) {
            $path = $request->file('main_image')->store('public/uploads/DocumentClasses/' . $id);
            $this->savePictures($id, "document_class", 'picture_main', str_replace('public', '/storage', $path));
        }
        if ($request->hasFile('slider_image')) {
            $this->sliderManagement($request->slider, 'DocumentClass', $documentClass->id);
        }

        return redirect()->back()->with('success', "کلاس اسناد با کد $id با موفقیت ایجاد شد.");
    }

    public function edit($id)
    {
        $teachers = Teacher::with('adjectiveInfo')->where('status', 1)->get();
        $documentClass = DocumentClass::with('mainImage', 'mainVideo', 'sliderImage')->where('id', $id)->first();
        return view('Posts.DocumentClasses.edit', compact('teachers', 'documentClass'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'short_title' => 'required|string',
            'status' => 'required|integer|in:1,2',
            'chosen' => 'required|integer|in:0,1',
            'slider' => 'required|integer|in:0,1',
            'body' => 'required|string',
            'class_hours' => 'required|string',
            'class_minutes' => 'required|string',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'topics' => 'array',
            'topics.*' => 'required|string',
            'teacher' => 'required|integer|exists:teachers,id',
        ]);

        $documentClass = DocumentClass::find($id);
        $documentClass->title = $request->title;
        $documentClass->short_title = $request->short_title;
        $documentClass->status = $request->status;
        $documentClass->chosen = $request->chosen;

        if ($request->status == 2) {
            $documentClass->draft_token = $this->makeTokenForDraft('notes');
        } else {
            $documentClass->draft_token = null;
        }

        $documentClass->about_class = $request->body;
        $documentClass->teacher = $request->teacher;
        $documentClass->class_time = $request->class_hours . ':' . $request->class_minutes;
        $documentClass->adder = $this->getMyUserId();

        $topics = [];
        foreach (request('topics') as $index => $topic) {
            $topics[] = ['topic' => $topic, 'link' => $request['aparats'][$index]];
        }
        $documentClass->topics = json_encode($topics, true);
        $documentClass->save();

        if ($request->hasFile('main_image')) {
            $path = $request->file('main_image')->store('public/uploads/DocumentClasses/' . $id);
            Picture::where('post_type', 'document_class')->where('image_type', 'picture_main')->where('post_id', $id)->delete();
            $this->savePictures($id, "document_class", 'picture_main', str_replace('public', '/storage', $path));
        }

        if ($request->hasFile('slider_image') and $request->slider == 1) {
            $this->sliderManagement($request->slider, 'DocumentClass', $documentClass->id, $request->slider_image);
        } elseif ($request->slider == 0) {
            $this->sliderManagement($request->slider, 'DocumentClass', $documentClass->id);
        }

        return redirect()->back()->with('success', "کلاس اسناد با کد $id با موفقیت ویرایش شد.");
    }

    public function destroy($id)
    {
        $delete = DocumentClass::where('id', $id)->delete();
        if ($delete) {
            $this->deleteSliderAfterDeletePost('document_classes', $id);
            return redirect()->back()->with('success', 'کلاس اسناد با موفقیت حذف شد!');
        }
        return redirect()->back()->withErrors(['errors' => 'حذف کلاس اسناد با مشکل مواجه شد!']);
    }
}
