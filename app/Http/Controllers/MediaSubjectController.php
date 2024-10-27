<?php

namespace App\Http\Controllers;

use App\Models\Catalogs\SubjectAudience;
use App\Models\Catalogs\SubjectFormat;
use App\Models\MediaSubject;
use App\Models\Picture;
use App\Models\Post;
use Illuminate\Http\Request;

class MediaSubjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:لیست سوژه های رسانه ای', ['only' => ['index']]);
        $this->middleware('permission:ایجاد سوژه های رسانه ای', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش سوژه های رسانه ای', ['only' => ['edit', 'update']]);
        $this->middleware('permission:حذف سوژه های رسانه ای', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        if (empty($request->all())) {
            $mediaSubjects = MediaSubject::with('adderInfo', 'editorInfo')->orderByDesc('id')->paginate(50);
        } else {
            $mediaSubjects = $this->searchControl($request);
        }
        return view('Posts.MediaSubjects.index', compact('mediaSubjects'));
    }

    public function create()
    {
        $categories = $this->getAllNonPostCategories();
        $subjectFormats = SubjectFormat::where('status', 1)->get();
        $subjectAudiences = SubjectAudience::where('status', 1)->get();
        return view('Posts.MediaSubjects.create', compact('categories', 'subjectFormats', 'subjectAudiences'));
    }

    public function checkMediaSubjectsIfExists($subjectsArray = []): false|string|null
    {
        if (!empty($subjectsArray) and count($subjectsArray) > 0) {
            $checkedSubjects = [];
            foreach ($subjectsArray as $subject) {
                if (MediaSubject::find($subject) == null) {
                    continue;
                }
                $subjectId = MediaSubject::where('id', $subject)->select('id')->first();
                $checkedSubjects[] = $subjectId->id;
            }
            return json_encode(array_unique($checkedSubjects), true);
        }
        return null;
    }

    public function checkPostsIfExists($postsArray = []): false|string|null
    {
        if (!empty($postsArray) and count($postsArray) > 0) {
            $checkedPosts = [];
            foreach ($postsArray as $post) {
                if (Post::find($post) == null) {
                    continue;
                }
                $postId = Post::where('id', $post)->select('id')->first();
                $checkedPosts[] = $postId->id;
            }
            return json_encode(array_unique($checkedPosts), true);
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
            'subject_format' => 'required|integer|exists:subject_formats,id',
            'subject_audience' => 'required|integer|exists:subject_audiences,id',
            'keywords' => 'required|string',
            'resources' => 'required|string',
            'related_items' => 'array',
            'related_items.*' => 'required|string',
            'post_types' => 'array',
            'post_types.*' => 'required|integer|exists:post_types,id',
            'links' => 'array',
            'links.*' => 'required|string',
            'attached_documents' => 'array',
            'attached_documents.*' => 'required|integer|exists:posts,id',
            'media_subjects' => 'array',
            'media_subjects.*' => 'required',
            'main_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'child_images' => 'array',
            'child_images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);

        $mediaSubject = new MediaSubject();
        $mediaSubject->title = $request->title;
        $mediaSubject->status = $request->status;
        $mediaSubject->chosen = $request->chosen;

        if ($request->status == 2) {
            $mediaSubject->draft_token = $this->makeTokenForDraft('notes');
        } else {
            $mediaSubject->draft_token = null;
        }

        $mediaSubject->subject_format = $request->subject_format;
        $mediaSubject->subject_audience = $request->subject_audience;
        $mediaSubject->body = $request->body;
        $mediaSubject->resources = $request->resources;
        $mediaSubject->keywords = $this->jsonEncodeArrays($request->keywords);
        $mediaSubject->attached_documents = $this->checkPostsIfExists($request->attached_documents);
        $mediaSubject->similar_subjects = $this->checkMediaSubjectsIfExists($request->media_subjects);
        $mediaSubject->related_items = $this->saveRelatedItems($request->related_items, $request->post_types, $request->links);
        $mediaSubject->adder = $this->getMyUserId();
        $mediaSubject->save();

        $id = $mediaSubject->id;
        if ($request->hasFile('main_image')) {
            $path = $request->file('main_image')->store('public/uploads/MediaSubjects/' . $id);
            $this->savePictures($id, "media_subject", 'picture_main', str_replace('public', '/storage', $path));
        }

        if ($request->hasFile('child_images')) {
            foreach ($request->file('child_images') as $file) {
                $path = $file->store('public/uploads/MediaSubjects/' . $id);
                $this->savePictures($id, "media_subject", 'picture_child', str_replace('public', '/storage', $path));
            }
        }
        if ($request->hasFile('slider_image')) {
            $this->sliderManagement($request->slider, 'MediaSubject', $mediaSubject->id);
        }
        return redirect()->back()->with('success', "سوژه های رسانه ای با کد $id با موفقیت ایجاد شد.");
    }

    public function edit($id)
    {
        $mediaSubject = MediaSubject::with('mainImage', 'childImages', 'adderInfo', 'editorInfo', 'sliderImage')->find($id);
        $allSubjects = MediaSubject::where('status', 1)->get();
        $categories = $this->getAllNonPostCategories();
        $subjectFormats = SubjectFormat::where('status', 1)->get();
        $subjectAudiences = SubjectAudience::where('status', 1)->get();
        $mediaSubjects = [];
        if (!empty($mediaSubjects->similar_subjects)) {
            $mediaSubjects = MediaSubject::whereIn('similar_subjects', json_decode($mediaSubjects->similar_subjects, true))->get();
        }
        return view('Posts.MediaSubjects.edit', compact('mediaSubject', 'categories', 'allSubjects', 'subjectFormats', 'subjectAudiences', 'mediaSubjects'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|integer|exists:media_subjects,id',
            'title' => 'required|string',
            'status' => 'required|integer|in:1,2',
            'chosen' => 'required|integer|in:0,1',
            'slider' => 'required|integer|in:0,1',
            'subject_format' => 'required|integer|exists:subject_formats,id',
            'subject_audience' => 'required|integer|exists:subject_audiences,id',
            'body' => 'required|string',
            'keywords' => 'required|string',
            'resources' => 'required|string',
            'related_items' => 'array',
            'related_items.*' => 'required|string',
            'post_types' => 'array',
            'post_types.*' => 'required|integer|exists:post_types,id',
            'links' => 'array',
            'links.*' => 'required|string',
            'attached_documents' => 'array',
            'attached_documents.*' => 'required|integer|exists:posts,id',
            'media_subjects' => 'array',
            'media_subjects.*' => 'required',
            'main_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'child_images' => 'array',
            'child_images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);

        $id = $request->id;
        $mediaSubject = MediaSubject::find($id);
        $mediaSubject->title = $request->title;
        $mediaSubject->status = $request->status;
        $mediaSubject->chosen = $request->chosen;

        if ($request->status == 2) {
            $mediaSubject->draft_token = $this->makeTokenForDraft('notes');
        } else {
            $mediaSubject->draft_token = null;
        }

        $mediaSubject->subject_format = $request->subject_format;
        $mediaSubject->subject_audience = $request->subject_audience;
        $mediaSubject->resources = $request->resources;
        $mediaSubject->body = $request->body;
        $mediaSubject->keywords = $this->jsonEncodeArrays($request->keywords);
        $mediaSubject->attached_documents = $this->checkPostsIfExists($request->attached_documents);
        $mediaSubject->related_items = $this->saveRelatedItems($request->related_items, $request->post_types, $request->links);
        $mediaSubject->similar_subjects = $this->checkMediaSubjectsIfExists($request->media_subjects);
        $mediaSubject->editor = $this->getMyUserId();
        $mediaSubject->save();


        if ($request->hasFile('main_image')) {
            $path = $request->file('main_image')->store('public/uploads/MediaSubjects/' . $id);
            Picture::where('post_type', 'media_subject')->where('image_type', 'picture_main')->where('post_id', $mediaSubject->id)->delete();
            $this->savePictures($mediaSubject->id, "media_subject", 'picture_main', str_replace('public', '/storage', $path));
        }

        if ($request->hasFile('child_images')) {
            foreach ($request->file('child_images') as $file) {
                $path = $file->store('public/uploads/MediaSubjects/' . $id);
                $this->savePictures($mediaSubject->id, "media_subject", 'picture_child', str_replace('public', '/storage', $path));
            }
        }

        if ($request->hasFile('slider_image') and $request->slider == 1) {
            $this->sliderManagement($request->slider, 'MediaSubject', $mediaSubject->id, $request->slider_image);
        } elseif ($request->slider == 0) {
            $this->sliderManagement($request->slider, 'MediaSubject', $mediaSubject->id);
        }

        return redirect()->back()->with('success', "سوژه های رسانه ای با کد $id با موفقیت ویرایش شد.");
    }

    public function destroy($id)
    {
        $delete = MediaSubject::where('id', $id)->delete();
        if ($delete) {
            $this->deleteSliderAfterDeletePost('media_subjects', $id);
            return redirect()->back()->with('success', 'سوژه رسانه ای با موفقیت حذف شد!');
        }
        return redirect()->back()->withErrors(['errors' => 'حذف سوژه رسانه ای با مشکل مواجه شد!']);
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
        $subject = MediaSubject::find($id);
        if (empty($subject)) {
            return response()->json([null]);
        }
        return response()->json($subject);
    }
}
