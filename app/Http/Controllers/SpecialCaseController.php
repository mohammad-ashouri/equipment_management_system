<?php

namespace App\Http\Controllers;

use App\Models\Picture;
use App\Models\SpecialCase;
use Illuminate\Http\Request;

class SpecialCaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:لیست پرونده ویژه', ['only' => ['index']]);
        $this->middleware('permission:ایجاد پرونده ویژه', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش پرونده ویژه', ['only' => ['edit', 'update']]);
        $this->middleware('permission:حذف پرونده ویژه', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        if (empty($request->all())) {
            $specialCases = SpecialCase::with('adderInfo', 'editorInfo')->orderByDesc('id')->paginate(50);
        } else {
            $specialCases = $this->searchControl($request);
        }
        return view('Posts.SpecialCases.index', compact('specialCases'));
    }

    public function create()
    {
        return view('Posts.SpecialCases.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'status' => 'required|integer|in:1,2',
            'chosen' => 'required|integer|in:0,1',
            'slider' => 'required|integer|in:0,1',
            'note_title' => 'required|string',
            'note_body' => 'required|string',
            'note_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'interview_title' => 'required|string',
            'interview_body' => 'required|string',
            'interview_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'movies_title' => 'array',
            'movies_title.*' => 'required|string',
            'movies_link' => 'array',
            'movies_link.*' => 'required|string',
            'audios_title' => 'array',
            'audios_title.*' => 'required|string',
            'audios_link' => 'array',
            'audios_link.*' => 'required|file|mimes:mp3,ogg,wav,aac|max:100000',
            'images_title' => 'array',
            'images_title.*' => 'required|string',
            'images_file' => 'array',
            'images_file.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);
        $specialCase = new SpecialCase();
        $specialCase->title = $request->title;
        $specialCase->status = $request->status;
        $specialCase->chosen = $request->chosen;

        if ($request->status == 2) {
            $specialCase->draft_token = $this->makeTokenForDraft('notes');
        } else {
            $specialCase->draft_token = null;
        }

        $specialCase->note_title = $request->note_title;
        $specialCase->note_body = $request->note_body;
        $specialCase->interview_title = $request->interview_title;
        $specialCase->interview_body = $request->interview_body;
        $specialCase->adder = $this->getMyUserId();
        $specialCase->save();

        $id = $specialCase->id;

        if (!empty($request->movies_title) and !empty($request->movies_link) and count($request->movies_title) == count($request->movies_link)) {
            $movies = [];
            foreach ($request->movies_title as $index => $movie) {
                $movies[] = ['title' => $movie, 'link' => $request->movies_link[$index]];
            }
            $specialCase->movies = json_encode($movies);
        }

        if (!empty($request->audios_title) and !empty($request->audios_link) and count($request->audios_title) == count($request->audios_link)) {
            $audioSrc = [];
            foreach ($request->audios_link as $index => $audio) {
                $path = $audio->store("public/uploads/SpecialCase/$id/audios");
                $audioSrc[] = ['title' => $request->audios_title[$index], 'path' => $path];
            }
            $specialCase->audios = json_encode($audioSrc);
        }
        if (!empty($request->images_title) and !empty($request->images_link) and count($request->images_title) == count($request->images_link)) {
            foreach ($request->images_link as $index => $image) {
                $path = $image->store("public/uploads/SpecialCase/$id/images");
                $this->savePictures($id, "special_case_image_gallery", 'picture_main', str_replace('public', '/storage', $path), $request->images_title[$index]);
            }
        }
        $specialCase->save();

        if ($request->hasFile('note_image')) {
            $path = $request->file('note_image')->store('public/uploads/SpecialCase/' . $id);
            $this->savePictures($id, "special_case_note", 'picture_main', str_replace('public', '/storage', $path));
        }

        if ($request->hasFile('interview_image')) {
            $path = $request->file('interview_image')->store('public/uploads/SpecialCase/' . $id);
            $this->savePictures($id, "special_case_interview", 'picture_main', str_replace('public', '/storage', $path));
        }

        if ($request->hasFile('slider_image')) {
            $this->sliderManagement($request->slider, 'SpecialCase', $specialCase->id);
        }

        return redirect()->back()->with('success', "پرونده ویژه با کد $id با موفقیت ایجاد شد.");
    }

    public function edit($id)
    {
        $specialCase = SpecialCase::with('noteImage', 'imagesGallery', 'interviewImage', 'adderInfo', 'editorInfo', 'sliderImage')->find($id);
        return view('Posts.SpecialCases.edit', compact('specialCase'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|integer|exists:special_cases,id',
            'title' => 'required|string',
            'status' => 'required|integer|in:1,2',
            'chosen' => 'required|integer|in:0,1',
            'slider' => 'required|integer|in:0,1',
            'note_title' => 'required|string',
            'note_body' => 'required|string',
            'note_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'interview_title' => 'required|string',
            'interview_body' => 'required|string',
            'interview_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'movies_title' => 'array',
            'movies_title.*' => 'required|string',
            'movies_link' => 'array',
            'movies_link.*' => 'required|string',
            'audios_title' => 'array',
            'audios_title.*' => 'required|string',
            'audios_link' => 'array',
            'audios_link.*' => 'required|file|mimes:mp3,ogg,wav,aac|max:100000',
            'images_title' => 'array',
            'images_title.*' => 'required|string',
            'images_link' => 'array',
            'images_link.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);
        $id = $request->id;
        $specialCase = SpecialCase::find($id);
        $specialCase->title = $request->title;
        $specialCase->status = $request->status;
        $specialCase->chosen = $request->chosen;

        if ($request->status == 2) {
            $specialCase->draft_token = $this->makeTokenForDraft('notes');
        } else {
            $specialCase->draft_token = null;
        }

        $specialCase->note_title = $request->note_title;
        $specialCase->note_body = $request->note_body;
        $specialCase->interview_title = $request->interview_title;
        $specialCase->interview_body = $request->interview_body;

        $movies = [];
        if (!empty($request->movies_title) and !empty($request->movies_link) and count($request->movies_title) == count($request->movies_link)) {
            foreach ($request->movies_title as $index => $movie) {
                $movies[] = ['title' => $movie, 'link' => $request->movies_link[$index]];
            }
        }
        $specialCase->movies = json_encode($movies);

        if ((isset($request->audios_title) && !empty($request->audios_link)) || (isset($request->saved_audios_link) && !empty($request->saved_audios_link))) {
            $audioSrc = json_decode($specialCase->audios, true) ?? [];
            if (isset($request->saved_audios_link)) {
                $filteredAudios = [];
                foreach ($request->saved_audios_link as $audio) {
                    if (in_array($audio, array_column($audioSrc, 'path'))) {
                        $filteredAudios[] = $audio;
                    }
                }
                $audioSrc = array_filter($audioSrc, function ($audio) use ($filteredAudios) {
                    return in_array($audio['path'], $filteredAudios);
                });
            }

            if ($request->hasFile('audios_link')) {
                foreach ($request->file('audios_link') as $index => $audio) {
                    $path = $audio->store("public/uploads/SpecialCase/$id/audios");
                    $audioSrc[] = ['title' => $request->audios_title[$index], 'path' => str_replace('public', '/storage', $path)];
                }
            }

            $specialCase->audios = json_encode($audioSrc);
        } else {
            $specialCase->audios = null;
        }


        if ((isset($request->images_title) && !empty($request->images_link)) || (isset($request->saved_images) && !empty($request->saved_images))) {
            if (isset($request->saved_images)) {
                foreach ($specialCase->imagesGallery as $image) {
                    if (!in_array($image->src, $request->saved_images)) {
                        Picture::whereSrc($image->src)
                            ->wherePostType('special_case_image_gallery')
                            ->delete();
                    }
                }
            }
            if ($request->hasFile('images_link')) {
                foreach ($request->images_link as $index => $image) {
                    $path = $image->store("public/uploads/SpecialCase/$id/images");
                    $this->savePictures($id, "special_case_image_gallery", 'picture_main', str_replace('public', '/storage', $path), $request->images_title[$index]);
                }
            }
        }


        $specialCase->editor = $this->getMyUserId();
        $specialCase->save();

        $id = $specialCase->id;
        if ($request->hasFile('note_image')) {
            $path = $request->file('note_image')->store('public/uploads/SpecialCase/' . $id);
            $this->removePicture($id, "special_case_note", 'picture_main');
            $this->savePictures($id, "special_case_note", 'picture_main', str_replace('public', '/storage', $path));
        }

        if ($request->hasFile('interview_image')) {
            $path = $request->file('interview_image')->store('public/uploads/SpecialCase/' . $id);
            $this->removePicture($id, "special_case_interview", 'picture_main');
            $this->savePictures($id, "special_case_interview", 'picture_main', str_replace('public', '/storage', $path));
        }

        if ($request->hasFile('slider_image') and $request->slider == 1) {
            $this->sliderManagement($request->slider, 'SpecialCase', $specialCase->id, $request->slider_image);
        } elseif ($request->slider == 0) {
            $this->sliderManagement($request->slider, 'SpecialCase', $specialCase->id);
        }

        return redirect()->back()->with('success', "پرونده ویژه با کد $id با موفقیت ویرایش شد.");
    }

    public function destroy($id)
    {
        $delete = SpecialCase::where('id', $id)->delete();
        if ($delete) {
            $this->deleteSliderAfterDeletePost('special_cases', $id);
            return redirect()->back()->with('success', 'پرونده ویژه با موفقیت حذف شد!');
        }
        return redirect()->back()->withErrors(['errors' => 'حذف پرونده ویژه با مشکل مواجه شد!']);
    }
}
