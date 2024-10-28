<?php

namespace App\Http\Controllers;

use App\Models\InternationalDocument;
use App\Models\Picture;
use Illuminate\Http\Request;

class InternationalDocumentController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:لیست اسناد خارجی', ['only' => ['index']]);
        $this->middleware('permission:ایجاد اسناد خارجی', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش اسناد خارجی', ['only' => ['edit', 'update']]);
        $this->middleware('permission:حذف اسناد خارجی', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        if (empty($request->all())) {
            $internationalDocuments = InternationalDocument::with('adderInfo', 'editorInfo')->orderByDesc('id')->paginate(50);
        } else {
            $internationalDocuments = $this->searchControl($request);
        }
        return view('Posts.InternationalDocuments.index', compact('internationalDocuments'));
    }

    public function create()
    {
        $categories = $this->getAllNonPostCategories();
        return view('Posts.InternationalDocuments.create', compact('categories'));
    }

    public function checkSimilarDocumentsIfExists($documentsArray = []): false|string|null
    {
        if (!empty($documentsArray) and count($documentsArray) > 0) {
            $checkedDocuments = [];
            foreach ($documentsArray as $subject) {
                if (InternationalDocument::where('id', $subject)->where('status', 1)->first() == null) {
                    continue;
                }
                $documentId = InternationalDocument::where('id', $subject)->where('status', 1)->select('id')->first();
                if (!empty($documentId)) {
                    $checkedDocuments[] = $documentId->id;
                }
            }
            return json_encode(array_unique($checkedDocuments), true);
        }
        return null;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'status' => 'required|integer|in:1,2',
            'slider' => 'required|integer|in:0,1',
            'body' => 'required|string',
            'keywords' => 'nullable|string',
            'person_and_organization' => 'nullable|string',
            'locations' => 'nullable|string',
            'times' => 'nullable|string',
            'events' => 'nullable|string',
            'equipments' => 'nullable|string',
            'contracts' => 'nullable|string',
            'other' => 'nullable|string',
            'related_items' => 'array',
            'related_items.*' => 'required|string',
            'post_types' => 'array',
            'post_types.*' => 'required|integer|exists:post_types,id',
            'links' => 'array',
            'links.*' => 'required|string',
            'similar_documents' => 'array',
            'similar_documents.*' => 'required',
            'main_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'child_images' => 'array',
            'child_images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);

        $internationalDocument = new InternationalDocument();
        $internationalDocument->title = $request->title;
        $internationalDocument->status = $request->status;

        if ($request->status == 2) {
            $internationalDocument->draft_token = $this->makeTokenForDraft('notes');
        } else {
            $internationalDocument->draft_token = null;
        }

        $internationalDocument->body = $request->body;
        $internationalDocument->keywords = $this->jsonEncodeArrays($request->keywords);
        $internationalDocument->person_and_organization = $request->person_and_organization;
        $internationalDocument->locations = $request->locations;
        $internationalDocument->times = $request->times;
        $internationalDocument->events = $request->events;
        $internationalDocument->equipments = $request->equipments;
        $internationalDocument->contracts = $request->contracts;
        $internationalDocument->other = $request->other;
        $internationalDocument->related_items = $this->saveRelatedItems($request->related_items, $request->post_types, $request->links);
        $internationalDocument->similar_documents = $this->checkSimilarDocumentsIfExists($request->similar_documents);
        $internationalDocument->adder = $this->getMyUserId();
        $internationalDocument->save();

        $id = $internationalDocument->id;
        if ($request->hasFile('main_image')) {
            $path = $request->file('main_image')->store('public/uploads/InternationalDocuments/' . $id);
            $this->savePictures($id, "international_document", 'picture_main', str_replace('public', '/storage', $path));
        }

        if ($request->hasFile('child_images')) {
            foreach ($request->file('child_images') as $file) {
                $path = $file->store('public/uploads/InternationalDocuments/' . $id);
                $this->savePictures($id, "international_document", 'picture_child', str_replace('public', '/storage', $path));
            }
        }

        if ($request->hasFile('slider_image')) {
            $this->sliderManagement($request->slider, 'Note', $internationalDocument->id, $request->slider_image);
        }

        return redirect()->route('InternationalDocuments.index')->with('success', "سند خارجی با کد $id با موفقیت ایجاد شد.");
    }

    public function edit($id)
    {
        $internationalDocument = InternationalDocument::with('mainImage', 'childImages', 'adderInfo', 'editorInfo', 'sliderImage')->find($id);
        $categories = $this->getAllNonPostCategories();

        $internationalDocuments = [];
        if (!empty($internationalDocument->similar_documents)) {
            $internationalDocuments = InternationalDocument::whereIn('id', json_decode($internationalDocument->similar_documents, true))->get();
        }
        return view('Posts.InternationalDocuments.edit', compact('internationalDocument', 'categories', 'internationalDocuments'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|integer|exists:international_documents,id',
            'title' => 'required|string',
            'status' => 'required|integer|in:1,2',
            'slider' => 'required|integer|in:0,1',
            'body' => 'required|string',
            'keywords' => 'nullable|string',
            'person_and_organization' => 'nullable|string',
            'locations' => 'nullable|string',
            'times' => 'nullable|string',
            'events' => 'nullable|string',
            'equipments' => 'nullable|string',
            'contracts' => 'nullable|string',
            'other' => 'nullable|string',
            'related_items' => 'array',
            'related_items.*' => 'required|string',
            'post_types' => 'array',
            'post_types.*' => 'required|integer|exists:post_types,id',
            'links' => 'array',
            'links.*' => 'required|string',
            'similar_documents' => 'array',
            'similar_documents.*' => 'required',
            'main_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'child_images' => 'array',
            'child_images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);

        $id = $request->id;
        $internationalDocument = InternationalDocument::find($id);
        $internationalDocument->title = $request->title;
        $internationalDocument->status = $request->status;

        if ($request->status == 2) {
            $internationalDocument->draft_token = $this->makeTokenForDraft('notes');
        } else {
            $internationalDocument->draft_token = null;
        }

        $internationalDocument->body = $request->body;
        $internationalDocument->person_and_organization = $request->person_and_organization;
        $internationalDocument->locations = $request->locations;
        $internationalDocument->times = $request->times;
        $internationalDocument->events = $request->events;
        $internationalDocument->equipments = $request->equipments;
        $internationalDocument->contracts = $request->contracts;
        $internationalDocument->other = $request->other;
        $internationalDocument->keywords = $this->jsonEncodeArrays($request->keywords);
        $internationalDocument->similar_documents = $this->checkSimilarDocumentsIfExists($request->similar_documents);
        $internationalDocument->related_items = $this->saveRelatedItems($request->related_items, $request->post_types, $request->links);
        $internationalDocument->editor = $this->getMyUserId();
        $internationalDocument->save();


        if ($request->hasFile('main_image')) {
            $path = $request->file('main_image')->store('public/uploads/InternationalDocuments/' . $id);
            Picture::where('post_type', 'international_document')->where('image_type', 'picture_main')->where('post_id', $internationalDocument->id)->delete();
            $this->savePictures($internationalDocument->id, "international_document", 'picture_main', str_replace('public', '/storage', $path));
        }

        if ($request->hasFile('child_images')) {
            foreach ($request->file('child_images') as $file) {
                $path = $file->store('public/uploads/InternationalDocuments/' . $id);
                $this->savePictures($internationalDocument->id, "international_document", 'picture_child', str_replace('public', '/storage', $path));
            }
        }

        if ($request->hasFile('slider_image') and $request->slider == 1) {
            $this->sliderManagement($request->slider, 'InternationalDocument', $internationalDocument->id, $request->slider_image);
        } elseif ($request->slider == 0) {
            $this->sliderManagement($request->slider, 'InternationalDocument', $internationalDocument->id);
        }

        return redirect()->back()->with('success', "سند خارجی با کد $id با موفقیت ویرایش شد.");
    }

    public function destroy($id)
    {
        $delete = InternationalDocument::where('id', $id)->delete();
        if ($delete) {
            $this->deleteSliderAfterDeletePost('international_documents', $id);
            return redirect()->back()->with('success', 'سند خارجی با موفقیت حذف شد!');
        }
        return redirect()->back()->withErrors(['errors' => 'حذف سند خارجی با مشکل مواجه شد!']);
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
        $subject = InternationalDocument::where('id', $id)->where('status', 1)->first();
        if (empty($subject)) {
            return response()->json([null]);
        }
        return response()->json($subject);
    }
}
