<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\PersonAdjective;
use App\Models\Catalogs\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست مدرس دوره', ['only' => ['index']]);
        $this->middleware('permission:ایجاد مدرس دوره', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش مدرس دوره', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف مدرس دوره', ['only' => ['destroy']]);
    }

    public function index()
    {
        $teachers = Teacher::orderBy('name', 'asc')->paginate(10);
        return view('Catalogs.Teachers.index', compact('teachers'));
    }

    public function create()
    {
        $adjectives = PersonAdjective::where('status', 1)->get();
        return view('Catalogs.Teachers.create', compact('adjectives'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:teachers,name',
            'adjective' => 'required|integer|exists:person_adjectives,id',
            'post' => 'required|string',
            'main_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $teacher = Teacher::create(['name' => $request->input('name'), 'adjective' => $request->input('adjective'), 'post' => $request->input('post'), 'adder' => $this->getMyUserId()]);

        $id = $teacher->id;
        $path = $request->file('main_image')->store('public/uploads/Catalogs/Teachers/' . $id);
        $this->savePictures($id, "teacher_picture", 'picture_main', str_replace('public', '/storage', $path));

        if ($teacher) {
            return redirect()->route('Teachers.index')->with('success', 'مدرس دوره با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد مدرس دوره']);
    }

    public function edit($id)
    {
        $teacher = Teacher::with('mainImage')->find($id);
        $adjectives = PersonAdjective::where('status', 1)->get();

        return view('Catalogs.Teachers.edit', compact('teacher', 'adjectives'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'adjective' => 'required|integer|exists:person_adjectives,id',
            'post' => 'required|string',
            'main_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:teachers,id',
        ]);

        $teacher = Teacher::find($id);
        $teacher->name = $request->input('name');
        $teacher->adjective = $request->input('adjective');
        $teacher->post = $request->input('post');
        $teacher->status = $request->input('status');
        $teacher->editor = $this->getMyUserId();
        $teacher->save();

        if ($request->hasFile('main_image')) {
            $id = $teacher->id;
            $path = $request->file('main_image')->store('public/uploads/Catalogs/Teachers/' . $id);
            $this->savePictures($id, "teacher_picture", 'picture_main', str_replace('public', '/storage', $path));
        }

        return redirect()->route('Teachers.index')->with('success', 'مدرس دوره با موفقیت ویرایش شد.');
    }

    public function show($id)
    {
        $teacher = Teacher::with('mainImage')->find($id);
        if (!$teacher) {
            return response()->json('مدرس پیدا نشد!', 404);
        }
        return response()->json([
            'teacher' => $teacher,
            'image_url' => asset( $teacher->mainImage->src) // Adjust the path accordingly
        ]);
    }
}
