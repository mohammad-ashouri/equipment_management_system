<?php

namespace App\Http\Controllers;

use App\Models\Catalogs\MultimediaSubject;
use App\Models\Documentary;
use App\Models\Picture;
use Illuminate\Http\Request;

class DocumentaryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:لیست مستند', ['only' => ['index']]);
        $this->middleware('permission:ایجاد مستند', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش مستند', ['only' => ['edit', 'update']]);
        $this->middleware('permission:حذف مستند', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        if (empty($request->all())) {
            $documentaries = Documentary::with('adderInfo', 'editorInfo')->orderByDesc('id')->paginate(50);
        } else {
            $documentaries = $this->searchControl($request);
        }
        return view('Posts.Documentaries.index', compact('documentaries'));
    }

    public function create()
    {
        $multimediaSubjects = MultimediaSubject::where('status', 1)->orderBy('name', 'asc')->get();
        return view('Posts.Documentaries.create', compact('multimediaSubjects'));
    }

    public function checkSimilarDocumentariesIfExists($documentariesArray = []): false|string|null
    {
        if (!empty($documentariesArray) and count($documentariesArray) > 0) {
            $checkedDocumentaries = [];
            foreach ($documentariesArray as $documentaries) {
                if (Documentary::where('id', $documentaries)->where('status', 1)->first() == null) {
                    continue;
                }
                $bookId = Documentary::where('id', $documentaries)->where('status', 1)->select('id')->first();
                if (!empty($bookId)) {
                    $checkedDocumentaries[] = $bookId->id;
                }
            }
            return json_encode(array_unique($checkedDocumentaries), true);
        }
        return null;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'status' => 'required|integer|in:1,2',
            'chosen' => 'required|integer|in:0,1',
            'type' => 'required|string',
            'suggested' => 'required|integer|in:0,1',
            'body' => 'required|string',
            'keywords' => 'required|string',
            'video_link' => 'required|string',
            'subject' => 'required|integer|exists:multimedia_subjects,id',
            'main_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'related_items' => 'array',
            'related_items.*' => 'required|string',
        ]);

        $documentary = new Documentary();
        $documentary->title = $request->title;
        $documentary->status = $request->status;
        $documentary->chosen = $request->chosen;
        $documentary->suggested = $request->suggested;
        $documentary->type = $request->type;
        $documentary->body = $request->body;
        $documentary->subject = $request->subject;
        $documentary->related_items = $this->saveRelatedItems($request->related_items, $request->post_types, $request->links);
        $documentary->keywords = $this->jsonEncodeArrays($request->keywords);
        $documentary->similar_documentaries = $this->checkSimilarDocumentariesIfExists($request->documentaries);
        $documentary->video_link = $request->video_link;
        $documentary->adder = $this->getMyUserId();
        $documentary->save();

        $id = $documentary->id;
        if ($request->hasFile('main_image')) {
            $path = $request->file('main_image')->store('public/uploads/Documentaries/' . $id);
            $this->savePictures($id, "documentary", 'picture_main', str_replace('public', '/storage', $path));
        }

        if ($request->slider == 1) {
            $this->sliderManagement($request->slider, 'Documentary', $documentary->id);
        }

        $id = $documentary->id;
        return redirect()->back()->with('success', "مستند با کد $id با موفقیت ایجاد شد.");
    }

    public function edit($id)
    {
        $documentary = Documentary::with('adderInfo', 'editorInfo')->find($id);
        $multimediaSubjects = MultimediaSubject::where('status', 1)->orderBy('name', 'asc')->get();
        $documentaries = [];

        if (!empty($documentary->similar_documentaries)) {
            $documentaries = Documentary::whereIn('id', json_decode($documentary->similar_documentaries, true))->get();
        }
        return view('Posts.Documentaries.edit', compact('documentary', 'multimediaSubjects', 'documentaries'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|integer|exists:documentaries,id',
            'title' => 'required|string',
            'type' => 'required|string',
            'suggested' => 'required|integer|in:0,1',
            'status' => 'required|integer|in:1,2',
            'chosen' => 'required|integer|in:0,1',
            'body' => 'required|string',
            'video_link' => 'required|string',
            'subject' => 'required|integer|exists:multimedia_subjects,id',
            'keywords' => 'required|string',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'related_items' => 'array',
            'related_items.*' => 'required|string',
        ]);

        $id = $request->id;
        $documentary = Documentary::find($id);
        $documentary->title = $request->title;
        $documentary->type = $request->type;
        $documentary->suggested = $request->suggested;
        $documentary->status = $request->status;
        $documentary->chosen = $request->chosen;

        if ($request->status == 2) {
            $documentary->draft_token = $this->makeTokenForDraft('notes');
        } else {
            $documentary->draft_token = null;
        }

        $documentary->body = $request->body;
        $documentary->subject = $request->subject;
        $documentary->related_items = $this->saveRelatedItems($request->related_items, $request->post_types, $request->links);
        $documentary->keywords = $this->jsonEncodeArrays($request->keywords);
        $documentary->similar_documentaries = $this->checkSimilarDocumentariesIfExists($request->documentaries);
        $documentary->video_link = $request->video_link;
        $documentary->editor = $this->getMyUserId();
        $documentary->save();

        $id = $documentary->id;
        if ($request->hasFile('main_image')) {
            $path = $request->file('main_image')->store('public/uploads/DocumentClasses/' . $id);
            Picture::where('post_type', 'documentary')->where('image_type', 'picture_main')->where('post_id', $id)->delete();
            $this->savePictures($id, "documentary", 'picture_main', str_replace('public', '/storage', $path));
        }
        $this->sliderManagement($request->slider, 'Documentary', $documentary->id);

        return redirect()->back()->with('success', "مستند با کد $id با موفقیت ویرایش شد.");
    }

    public function destroy($id)
    {
        $delete = Documentary::where('id', $id)->delete();
        if ($delete) {
            $this->deleteSliderAfterDeletePost('documentaries', $id);
            return redirect()->back()->with('success', 'مستند با موفقیت حذف شد!');
        }
        return redirect()->back()->withErrors(['errors' => 'حذف مستند با مشکل مواجه شد!']);
    }

    public function show($id): \Illuminate\Http\JsonResponse
    {
        $documentary = Documentary::where('id', $id)->where('status', 1)->first();
        if (empty($documentary)) {
            return response()->json([null]);
        }
        return response()->json($documentary);
    }
}
