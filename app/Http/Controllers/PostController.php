<?php

namespace App\Http\Controllers;

use App\Models\Picture;
use App\Models\Post;
use App\Models\TagLabel;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:لیست اسناد', ['only' => ['index']]);
        $this->middleware('permission:ایجاد اسناد', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش اسناد', ['only' => ['edit', 'update']]);
        $this->middleware('permission:حذف اسناد', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        if (empty($request->all())) {
            $posts = Post::with('adderInfo', 'editorInfo')->orderByDesc('id')->paginate(50);
        } else {
            $posts = $this->searchControl($request);
        }
        return view('Posts.Posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = $this->getAllPostCategories();
        $documentTypes = $this->getAllDocumentTypes();
        return view('Posts.Posts.create', compact('categories', 'documentTypes'));
    }

    public function checkSimilarDocumentsIfExists($documentsArray = []): false|string|null
    {
        if (!empty($documentsArray) and count($documentsArray) > 0) {
            $checkedDocuments = [];
            foreach ($documentsArray as $subject) {
                if (Post::where('id', $subject)->where('status', 1)->first() == null) {
                    continue;
                }
                $documentId = Post::where('id', $subject)->where('status', 1)->select('id')->first();
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
            'tags' => 'nullable|string',
            'person_and_organization' => 'nullable|string',
            'locations' => 'nullable|string',
            'times' => 'nullable|string',
            'events' => 'nullable|string',
            'equipments' => 'nullable|string',
            'contracts' => 'nullable|string',
            'other' => 'nullable|string',
            'main_subject' => 'nullable|string',
            'second_subject' => 'nullable|string',
            'third_subject' => 'nullable|string',
            'fourth_subject' => 'nullable|string',
            'source_book' => 'nullable|string',
            'volume_number' => 'nullable|string',
            'book_number' => 'nullable|string',
            'page_number' => 'nullable|string',
            'document_number' => 'nullable|string',
            'document_internal_number' => 'nullable|string',
            'document_type' => 'nullable|string|exists:document_types,id',
            'document_producer' => 'nullable|string',
            'recipient_of_document' => 'nullable|string',
            'AD_date' => 'nullable|string',
            'jalali_date' => 'nullable|string',
            'description' => 'nullable|string',
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

        $post = new Post();
        $post->title = $request->title;
        $post->status = $request->status;

        if ($request->status == 2) {
            $post->draft_token = $this->makeTokenForDraft('notes');
        } else {
            $post->draft_token = null;
        }

        $post->body = $request->body;

        $tags = explode(',', $request->keywords);
        $keywordsArray = array_map('trim', $tags);
        $tagArray = [];
        foreach ($keywordsArray as $tag) {
            $tagLabelId = TagLabel::firstOrCreate(['name' => $tag, 'adder' => $this->getMyUserId()]);
            $tagArray[] = $tagLabelId->id;
        }
        $post->tags = json_encode($tagArray, true);

        $post->person_and_organization = $request->person_and_organization;
        $post->locations = $request->locations;
        $post->times = $request->times;
        $post->events = $request->events;
        $post->equipments = $request->equipments;
        $post->contracts = $request->contracts;
        $post->other = $request->other;
        $post->main_subject = $request->main_subject;
        $post->second_subject = $request->second_subject;
        $post->third_subject = $request->third_subject;
        $post->fourth_subject = $request->fourth_subject;
        $post->source_book = $request->source_book;
        $post->volume_number = $request->volume_number;
        $post->book_number = $request->book_number;
        $post->page_number = $request->page_number;
        $post->document_number = $request->document_number;
        $post->document_internal_number = $request->document_internal_number;
        $post->document_type = $request->document_type;
        $post->document_producer = $request->document_producer;
        $post->recipient_of_document = $request->recipient_of_document;
        $post->AD_date = $request->AD_date;
        $post->jalali_date = $request->jalali_date;
        $post->description = $request->description;
        $post->related_items = $this->saveRelatedItems($request->related_items, $request->post_types, $request->links);
        $post->similar_documents = $this->checkSimilarDocumentsIfExists($request->similar_documents);

        $post->adder = $this->getMyUserId();
        $post->save();

        $id = $post->id;
        if ($request->hasFile('main_image')) {
            $path = $request->file('main_image')->store('public/uploads/Posts/' . $id);
            $this->savePictures($id, "post", 'picture_main', str_replace('public', '/storage', $path));
        }

        if ($request->hasFile('slider_image')) {
            $this->sliderManagement($request->slider, 'Post', $post->id);
        }

        if ($request->hasFile('child_images')) {
            foreach ($request->file('child_images') as $file) {
                $path = $file->store('public/uploads/Posts/' . $id);
                $this->savePictures($id, "post", 'picture_child', str_replace('public', '/storage', $path));
            }
        }

        return redirect()->back()->with('success', "سند با کد $id با موفقیت ایجاد شد.");
    }

    public function edit($id)
    {
        $post = Post::with('mainImage', 'childImages', 'adderInfo', 'editorInfo', 'categories2', 'sliderImage')->find($id);
        $categories = $this->getAllPostCategories();
        $documentTypes = $this->getAllDocumentTypes();

        $postTagsJson = $post->tags;
        $postTagsArray = json_decode($postTagsJson, true);
        if (is_array($postTagsArray)) {
            $keywords = TagLabel::whereIn('id', $postTagsArray)->pluck('name')->toArray();
        } else {
            dd('Invalid JSON format in tags field');
        }

        $postCategoriesArray = [];
        foreach ($post->categories2 as $postCategory) {
            $postCategoriesArray[] = $postCategory->id;
        }

        $documents = [];

        if (!empty($post->similar_documents)) {
            $documents = Post::whereIn('id', json_decode($post->similar_documents, true))->get();
        }

        return view('Posts.Posts.edit', compact('post', 'categories', 'documentTypes', 'keywords', 'postCategoriesArray', 'documents'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|integer|exists:posts,id',
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
            'other' => 'nullable|string', 'main_subject' => 'nullable|string',
            'second_subject' => 'nullable|string',
            'third_subject' => 'nullable|string',
            'fourth_subject' => 'nullable|string',
            'source_book' => 'nullable|string',
            'volume_number' => 'nullable|string',
            'book_number' => 'nullable|string',
            'page_number' => 'nullable|string',
            'document_number' => 'nullable|string',
            'document_internal_number' => 'nullable|string',
            'document_type' => 'nullable|string|exists:document_types,id',
            'document_producer' => 'nullable|string',
            'recipient_of_document' => 'nullable|string',
            'AD_date' => 'nullable|string',
            'jalali_date' => 'nullable|string',
            'description' => 'nullable|string',
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
        $post = Post::find($id);
        $post->title = $request->title;
        $post->status = $request->status;

        if ($request->status == 2) {
            $post->draft_token = $this->makeTokenForDraft('notes');
        } else {
            $post->draft_token = null;
        }

        $post->body = $request->body;

        $tags = explode(',', $request->keywords);
        $keywordsArray = array_map('trim', $tags);
        $tagArray = [];
        foreach ($keywordsArray as $tag) {
            $tagLabelId = TagLabel::firstOrCreate(['name' => $tag, 'adder' => $this->getMyUserId()]);
            $tagArray[] = $tagLabelId->id;
        }
        $post->tags = json_encode($tagArray, true);

        $post->person_and_organization = $request->person_and_organization;
        $post->locations = $request->locations;
        $post->times = $request->times;
        $post->events = $request->events;
        $post->equipments = $request->equipments;
        $post->contracts = $request->contracts;
        $post->other = $request->other;
        $post->main_subject = $request->main_subject;
        $post->second_subject = $request->second_subject;
        $post->third_subject = $request->third_subject;
        $post->fourth_subject = $request->fourth_subject;
        $post->source_book = $request->source_book;
        $post->volume_number = $request->volume_number;
        $post->book_number = $request->book_number;
        $post->page_number = $request->page_number;
        $post->document_number = $request->document_number;
        $post->document_internal_number = $request->document_internal_number;
        $post->document_type = $request->document_type;
        $post->document_producer = $request->document_producer;
        $post->recipient_of_document = $request->recipient_of_document;
        $post->AD_date = $request->AD_date;
        $post->jalali_date = $request->jalali_date;
        $post->description = $request->description;
        $post->related_items = $this->saveRelatedItems($request->related_items, $request->post_types, $request->links);
        $post->similar_documents = $this->checkSimilarDocumentsIfExists($request->similar_documents);

        $post->editor = $this->getMyUserId();
        $post->save();

        if ($request->hasFile('slider_image') and $request->slider == 1) {
            $this->sliderManagement($request->slider, 'Post', $post->id, $request->slider_image);
        } elseif ($request->slider == 0) {
            $this->sliderManagement($request->slider, 'Post', $post->id);
        }

        if ($request->hasFile('main_image')) {
            $path = $request->file('main_image')->store('public/uploads/Posts/' . $id);
            Picture::where('post_type', 'post')->where('image_type', 'picture_main')->where('post_id', $post->id)->delete();
            $this->savePictures($post->id, "post", 'picture_main', str_replace('public', '/storage', $path));
        }

        if ($request->hasFile('child_images')) {
            foreach ($request->file('child_images') as $file) {
                $path = $file->store('public/uploads/Posts/' . $id);
                $this->savePictures($post->id, "post", 'picture_child', str_replace('public', '/storage', $path));
            }
        }

        return redirect()->back()->with('success', "سند با کد $id با موفقیت ویرایش شد.");
    }

    public function destroy($id)
    {
        $delete = Post::where('id', $id)->delete();
        if ($delete) {
            $this->deleteSliderAfterDeletePost('posts', $id);
            return redirect()->back()->with('success', 'سند با موفقیت حذف شد!');
        }
        return redirect()->back()->withErrors(['errors' => 'حذف سند با مشکل مواجه شد!']);
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
        $subject = Post::where('id', $id)->where('status', 1)->first();
        if (empty($subject)) {
            return response()->json([null]);
        }
        return response()->json($subject);
    }
}
