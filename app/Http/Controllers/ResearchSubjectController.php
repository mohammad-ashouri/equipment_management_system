<?php

namespace App\Http\Controllers;

use App\Models\Catalogs\Section;
use App\Models\Catalogs\SubjectAudience;
use App\Models\Catalogs\SubjectFormat;
use App\Models\Picture;
use App\Models\Post;
use App\Models\ResearchSubject;
use Illuminate\Http\Request;

class ResearchSubjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:لیست سوژه های پژوهشی', ['only' => ['index']]);
        $this->middleware('permission:ایجاد سوژه های پژوهشی', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش سوژه های پژوهشی', ['only' => ['edit', 'update']]);
        $this->middleware('permission:حذف سوژه های پژوهشی', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        if (empty($request->all())) {
            $researchSubjects = ResearchSubject::with('adderInfo', 'editorInfo')->orderByDesc('id')->paginate(50);
        } else {
            $researchSubjects = $this->searchControl($request);
        }
        return view('Posts.ResearchSubjects.index', compact('researchSubjects'));
    }

    public function create()
    {
        $categories = $this->getAllNonPostCategories();
        $sections = Section::where('status', 1)->get();
        return view('Posts.ResearchSubjects.create', compact('categories', 'sections'));
    }

    public function checkResearchSubjectsIfExists($subjectsArray=[]): false|string|null
    {
        if (!empty($subjectsArray) and count($subjectsArray) > 0) {
            $checkedSubjects = [];
            foreach ($subjectsArray as $subject) {
                if (ResearchSubject::find($subject) == null) {
                    continue;
                }
                $subjectId = ResearchSubject::where('id', $subject)->select('id')->first();
                $checkedSubjects[] = $subjectId->id;
            }
            return json_encode(array_unique($checkedSubjects), true);
        }
        return null;
    }

    public function checkPostsIfExists($postsArray=[]): false|string|null
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
            'section' => 'required|integer|exists:sections,id',
            'keywords' => 'required|string',
            'related_items' => 'array',
            'related_items.*' => 'required|string',
            'post_types' => 'array',
            'post_types.*' => 'required|integer|exists:post_types,id',
            'links' => 'array',
            'links.*' => 'required|string',
            'attached_documents' => 'array',
            'attached_documents.*' => 'required|integer|exists:posts,id',
            'research_subjects' => 'array',
            'research_subjects.*' => 'required',
            'main_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'child_images' => 'array',
            'child_images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);
        $researchSubject = new ResearchSubject();
        $researchSubject->title = $request->title;
        $researchSubject->status = $request->status;
        $researchSubject->chosen = $request->chosen;

        if ($request->status == 2) {
            $researchSubject->draft_token = $this->makeTokenForDraft('notes');
        } else {
            $researchSubject->draft_token = null;
        }

        $researchSubject->section = $request->section;
        $researchSubject->body = $request->body;
        $researchSubject->resources = $request->resources;
        $researchSubject->keywords = $this->jsonEncodeArrays($request->keywords);
        $researchSubject->attached_documents = $this->checkPostsIfExists($request->attached_documents);
        $researchSubject->related_items = $this->saveRelatedItems($request->related_items, $request->post_types, $request->links);
        $researchSubject->similar_subjects = $this->checkResearchSubjectsIfExists($request->research_subjects);
        $researchSubject->adder = $this->getMyUserId();
        $researchSubject->save();

        $id = $researchSubject->id;
        if ($request->hasFile('main_image')) {
            $path = $request->file('main_image')->store('public/uploads/ResearchSubjects/' . $id);
            $this->savePictures($id, "research_subject", 'picture_main', str_replace('public', '/storage', $path));
        }

        if ($request->hasFile('child_images')) {
            foreach ($request->file('child_images') as $file) {
                $path = $file->store('public/uploads/ResearchSubjects/' . $id);
                $this->savePictures($id, "research_subject", 'picture_child', str_replace('public', '/storage', $path));
            }
        }

        if ($request->hasFile('slider_image')) {
            $this->sliderManagement($request->slider, 'ResearchSubject', $researchSubject->id);
        }

        return redirect()->back()->with('success', "سوژه های پژوهشی با کد $id با موفقیت ایجاد شد.");
    }

    public function edit($id)
    {
        $researchSubject = ResearchSubject::with('mainImage', 'childImages', 'adderInfo', 'editorInfo', 'sectionInfo', 'sliderImage')->find($id);
        $allSubjects = ResearchSubject::where('status', 1)->get();
        $categories = $this->getAllNonPostCategories();
        $sections = Section::where('status', 1)->get();
        $researchSubjects=[];
        if (!empty($researchSubject->similar_subjects)) {
            $researchSubjects = ResearchSubject::whereIn('similar_subjects',json_decode($researchSubject->similar_subjects,true))->get();
        }
        return view('Posts.ResearchSubjects.edit', compact('researchSubject', 'categories', 'allSubjects', 'sections', 'researchSubjects'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|integer|exists:research_subjects,id',
            'title' => 'required|string',
            'status' => 'required|integer|in:1,2',
            'chosen' => 'required|integer|in:0,1',
            'slider' => 'required|integer|in:0,1',
            'section' => 'required|integer|exists:sections,id',
            'body' => 'required|string',
            'keywords' => 'required|string',
            'resources' => 'required|string',
            'related_items' => 'array',
            'related_items.*' => 'required|string',
            'post_types' => 'array',
            'post_types.*' => 'required|integer|exists:post_types,id',
            'attached_documents' => 'array',
            'attached_documents.*' => 'required|integer|exists:posts,id',
            'links' => 'array',
            'links.*' => 'required|string',
            'research_subjects' => 'array',
            'research_subjects.*' => 'required',
            'main_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'child_images' => 'array',
            'child_images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);

        $id = $request->id;
        $researchSubject = ResearchSubject::find($id);
        $researchSubject->title = $request->title;
        $researchSubject->status = $request->status;
        $researchSubject->chosen = $request->chosen;

        if ($request->status == 2) {
            $researchSubject->draft_token = $this->makeTokenForDraft('notes');
        } else {
            $researchSubject->draft_token = null;
        }

        $researchSubject->section = $request->section;
        $researchSubject->resources = $request->resources;
        $researchSubject->body = $request->body;
        $researchSubject->keywords = $this->jsonEncodeArrays($request->keywords);
        $researchSubject->attached_documents = $this->checkPostsIfExists($request->attached_documents);
        $researchSubject->related_items = $this->saveRelatedItems($request->related_items, $request->post_types, $request->links);
        $researchSubject->similar_subjects = $this->checkResearchSubjectsIfExists($request->research_subjects);
        $researchSubject->editor = $this->getMyUserId();
        $researchSubject->save();


        if ($request->hasFile('main_image')) {
            $path = $request->file('main_image')->store('public/uploads/ResearchSubjects/' . $id);
            Picture::where('post_type', 'research_subject')->where('image_type', 'picture_main')->where('post_id', $researchSubject->id)->delete();
            $this->savePictures($researchSubject->id, "research_subject", 'picture_main', str_replace('public', '/storage', $path));
        }

        if ($request->hasFile('child_images')) {
            foreach ($request->file('child_images') as $file) {
                $path = $file->store('public/uploads/ResearchSubjects/' . $id);
                $this->savePictures($researchSubject->id, "research_subject", 'picture_child', str_replace('public', '/storage', $path));
            }
        }

        if ($request->hasFile('slider_image') and $request->slider == 1) {
            $this->sliderManagement($request->slider, 'ResearchSubject', $researchSubject->id, $request->slider_image);
        } elseif ($request->slider == 0) {
            $this->sliderManagement($request->slider, 'ResearchSubject', $researchSubject->id);
        }

        return redirect()->back()->with('success', "سوژه های پژوهشی با کد $id با موفقیت ویرایش شد.");
    }

    public function destroy($id)
    {
        $delete = ResearchSubject::where('id', $id)->delete();
        if ($delete) {
            $this->deleteSliderAfterDeletePost('research_subjects', $id);
            return redirect()->back()->with('success', 'سوژه پژوهشی با موفقیت حذف شد!');
        }
        return redirect()->back()->withErrors(['errors' => 'حذف سوژه پژوهشی با مشکل مواجه شد!']);
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
        $subject = ResearchSubject::find($id);
        if (empty($subject)) {
            return response()->json([null]);
        }
        return response()->json($subject);
    }
}
