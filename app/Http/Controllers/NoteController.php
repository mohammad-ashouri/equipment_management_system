<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Picture;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:لیست یادداشت ها', ['only' => ['index']]);
        $this->middleware('permission:ایجاد یادداشت ها', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش یادداشت ها', ['only' => ['edit', 'update']]);
        $this->middleware('permission:حذف یادداشت ها', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        if (empty($request->all())) {
            $notes = Note::with('adderInfo', 'editorInfo')->orderByDesc('id')->paginate(50);
        } else {
            $notes = $this->searchControl($request);
        }
        return view('Posts.Notes.index', compact('notes'));
    }

    public function create()
    {
        return view('Posts.Notes.create');
    }

    public function checkSimilarNotesIfExists($notesArray = []): false|string|null
    {
        if (!empty($notesArray) and count($notesArray) > 0) {
            $checkedNotes = [];
            foreach ($notesArray as $note) {
                if (Note::where('id', $note)->where('status', 1)->first() == null) {
                    continue;
                }
                $noteId = Note::where('id', $note)->where('status', 1)->select('id')->first();
                if (!empty($noteId)) {
                    $checkedNotes[] = $noteId->id;
                }
            }
            return json_encode(array_unique($checkedNotes), true);
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
            'author' => 'required|string',
            'keywords' => 'required|string',
            'footnotes' => 'array',
            'footnotes.*' => 'nullable|string',
            'related_items' => 'array',
            'related_items.*' => 'required|string',
            'post_types' => 'array',
            'post_types.*' => 'required|integer|exists:post_types,id',
            'links' => 'array',
            'links.*' => 'required|string',
            'similar_notes' => 'array',
            'similar_notes.*' => 'required',
            'main_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);

        $note = new Note();
        $note->title = $request->title;
        $note->status = $request->status;
        $note->chosen = $request->chosen;

        if ($request->status == 2) {
            $note->draft_token = $this->makeTokenForDraft('notes');
        } else {
            $note->draft_token = null;
        }

        $note->body = $request->body;
        $note->author = $request->author;
        if (isset($request->footnotes) and !empty($request->footnotes)) {
            $note->footnotes = json_encode($request->footnotes, true);
        } else {
            $note->footnotes = json_encode([]);
        }
        $note->keywords = $this->jsonEncodeArrays($request->keywords);
        $note->related_items = $this->saveRelatedItems($request->related_items, $request->post_types, $request->links);
        $note->similar_notes = $this->checkSimilarNotesIfExists($request->notes);
        $note->adder = $this->getMyUserId();
        $note->save();

        $id = $note->id;
        if ($request->hasFile('main_image')) {
            $path = $request->file('main_image')->store('public/uploads/Notes/' . $id);
            $this->savePictures($id, "note", 'picture_main', str_replace('public', '/storage', $path));
        }

        if ($request->hasFile('slider_image')) {
            $this->sliderManagement($request->slider, 'Note', $note->id, $request->slider_image);
        }

        return redirect()->back()->with('success', "یادداشت با کد $id با موفقیت ایجاد شد.");
    }

    public function edit($id)
    {
        $note = Note::with('mainImage', 'adderInfo', 'editorInfo', 'sliderImage')->find($id);

        $notes = [];
        if (!empty($note->similar_notes)) {
            $notes = Note::whereIn('id', json_decode($note->similar_notes, true))->get();
        }

        return view('Posts.Notes.edit', compact('note', 'notes'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'status' => 'required|integer|in:1,2',
            'chosen' => 'required|integer|in:0,1',
            'slider' => 'required|integer|in:0,1',
            'body' => 'required|string',
            'author' => 'required|string',
            'keywords' => 'required|string',
            'footnotes' => 'array',
            'footnotes.*' => 'nullable|string',
            'related_items' => 'array',
            'related_items.*' => 'required|string',
            'post_types' => 'array',
            'post_types.*' => 'required|integer|exists:post_types,id',
            'links' => 'array',
            'links.*' => 'required|string',
            'notes' => 'array',
            'notes.*' => 'required',
            'main_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);

        $note = Note::find($id);
        $note->title = $request->title;
        $note->status = $request->status;
        $note->chosen = $request->chosen;

        if ($request->status == 2) {
            $note->draft_token = $this->makeTokenForDraft('notes');
        } else {
            $note->draft_token = null;
        }

        $note->body = $request->body;
        $note->author = $request->author;
        if (isset($request->footnotes) and !empty($request->footnotes)) {
            $note->footnotes = json_encode($request->footnotes, true);
        } else {
            $note->footnotes = json_encode([]);
        }
        $note->keywords = $this->jsonEncodeArrays($request->keywords);
        $note->related_items = $this->saveRelatedItems($request->related_items, $request->post_types, $request->links);
        $note->similar_notes = $this->checkSimilarNotesIfExists($request->notes);
        $note->editor = $this->getMyUserId();
        $note->save();

        if ($request->hasFile('slider_image') and $request->slider == 1) {
            $this->sliderManagement($request->slider, 'Note', $note->id, $request->slider_image);
        } elseif ($request->slider == 0) {
            $this->sliderManagement($request->slider, 'Note', $note->id);
        }

        if ($request->hasFile('main_image')) {
            $path = $request->file('main_image')->store('public/uploads/Notes/' . $id);
            Picture::where('post_type', 'note')->where('image_type', 'picture_main')->where('post_id', $note->id)->delete();
            $this->savePictures($note->id, "note", 'picture_main', str_replace('public', '/storage', $path));
        }

        return redirect()->back()->with('success', "یادداشت با کد $id با موفقیت ویرایش شد.");
    }

    public function destroy($id)
    {
        $delete = Note::where('id', $id)->delete();
        if ($delete) {
            $this->deleteSliderAfterDeletePost('notes', $id);
            return redirect()->back()->with('success', 'یادداشت با موفقیت حذف شد!');
        }
        return redirect()->back()->withErrors(['errors' => 'حذف یادداشت با مشکل مواجه شد!']);
    }

    public function show($id): \Illuminate\Http\JsonResponse
    {
        $note = Note::where('id', $id)->where('status', 1)->first();
        if (empty($note)) {
            return response()->json([null]);
        }
        return response()->json($note);
    }
}
