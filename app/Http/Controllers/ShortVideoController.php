<?php

namespace App\Http\Controllers;

use App\Models\Catalogs\MultimediaSubject;
use App\Models\ShortVideo;
use App\Models\Picture;
use Illuminate\Http\Request;

class ShortVideoController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:لیست فیلم های کوتاه', ['only' => ['index']]);
        $this->middleware('permission:ایجاد فیلم های کوتاه', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش فیلم های کوتاه', ['only' => ['edit', 'update']]);
        $this->middleware('permission:حذف فیلم های کوتاه', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        if (empty($request->all())) {
            $shortVideos = ShortVideo::with('subjectInfo', 'adderInfo', 'editorInfo')->orderByDesc('id')->paginate(50);
        } else {
            $shortVideos = $this->searchControl($request);
        }
        return view('Multimedia.ShortVideos.index', compact('shortVideos'));
    }

    public function create()
    {
        $multimediaSubjects = MultimediaSubject::where('status', 1)->orderBy('name', 'asc')->get();
        return view('Multimedia.ShortVideos.create', compact('multimediaSubjects'));
    }

    public function checkSimilarShortVideosIfExists($shortVideosArray = []): false|string|null
    {
        if (!empty($shortVideosArray) and count($shortVideosArray) > 0) {
            $checkedShortVideos = [];
            foreach ($shortVideosArray as $shortVideos) {
                if (ShortVideo::where('id', $shortVideos)->where('status', 1)->first() == null) {
                    continue;
                }
                $shortVideoId = ShortVideo::where('id', $shortVideos)->where('status', 1)->select('id')->first();
                if (!empty($shortVideoId)) {
                    $checkedShortVideos[] = $shortVideoId->id;
                }
            }
            return json_encode(array_unique($checkedShortVideos), true);
        }
        return null;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'status' => 'required|integer|in:1,2',
            'body' => 'required|string',
            'keywords' => 'required|string',
            'subject' => 'required|integer|exists:multimedia_subjects,id',
            'video_link' => 'required|string',
            'related_items' => 'array',
            'related_items.*' => 'required|string',
        ]);

        $shortVideo = new ShortVideo();
        $shortVideo->title = $request->title;
        $shortVideo->status = $request->status;
        $shortVideo->body = $request->body;
        $shortVideo->subject = $request->subject;
        $shortVideo->video_link = $request->video_link;
        $shortVideo->keywords = $this->jsonEncodeArrays($request->keywords);
        $shortVideo->similar_short_videos = $this->checkSimilarShortVideosIfExists($request->similar_short_videos);
        $shortVideo->related_items = $this->saveRelatedItems($request->related_items, $request->post_types, $request->links);
        $shortVideo->adder = $this->getMyUserId();
        $shortVideo->save();

        $id = $shortVideo->id;
        return redirect()->back()->with('success', "فیلم کوتاه با کد $id با موفقیت ایجاد شد.");
    }

    public function edit($id)
    {
        $shortVideo = ShortVideo::with('adderInfo', 'editorInfo')->find($id);
        $multimediaSubjects = MultimediaSubject::where('status', 1)->orderBy('name', 'asc')->get();
        $shortVideos = [];
        if (!empty($shortVideo->similar_short_videos)) {
            $shortVideos = ShortVideo::whereIn('id', json_decode($shortVideo->similar_short_videos, true))->get();
        }
        return view('Multimedia.ShortVideos.edit', compact('shortVideo', 'multimediaSubjects', 'shortVideos'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|integer|exists:short_videos,id',
            'title' => 'required|string',
            'status' => 'required|integer|in:1,2',
            'body' => 'required|string',
            'keywords' => 'required|string',
            'subject' => 'required|integer|exists:multimedia_subjects,id',
            'video_link' => 'required|string',
            'related_items' => 'array',
            'related_items.*' => 'required|string',
        ]);

        $id = $request->id;
        $shortVideo = ShortVideo::find($id);
        $shortVideo->title = $request->title;
        $shortVideo->status = $request->status;
        $shortVideo->body = $request->body;
        $shortVideo->subject = $request->subject;
        $shortVideo->video_link = $request->video_link;
        $shortVideo->keywords = $this->jsonEncodeArrays($request->keywords);
        $shortVideo->similar_short_videos = $this->checkSimilarShortVideosIfExists($request->short_videos);
        $shortVideo->related_items = $this->saveRelatedItems($request->related_items, $request->post_types, $request->links);
        $shortVideo->editor = $this->getMyUserId();
        $shortVideo->save();

        return redirect()->back()->with('success', "فیلم کوتاه با کد $id با موفقیت ویرایش شد.");
    }

    public function destroy($id)
    {
        $delete = ShortVideo::where('id', $id)->delete();
        if ($delete) {
            return redirect()->back()->with('success', 'فیلم کوتاه با موفقیت حذف شد!');
        }
        return redirect()->back()->withErrors(['errors' => 'حذف فیلم کوتاه با مشکل مواجه شد!']);
    }

    public function show($id): \Illuminate\Http\JsonResponse
    {
        $video = ShortVideo::where('id', $id)->where('status', 1)->first();
        if (empty($video)) {
            return response()->json([null]);
        }
        return response()->json($video);
    }
}
