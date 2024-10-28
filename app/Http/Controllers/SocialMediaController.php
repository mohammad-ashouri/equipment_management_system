<?php

namespace App\Http\Controllers;

use App\Models\Picture;
use App\Models\SocialMedia;
use Illuminate\Http\Request;

class SocialMediaController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:لیست فضای مجازی', ['only' => ['index']]);
        $this->middleware('permission:ایجاد فضای مجازی', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش فضای مجازی', ['only' => ['edit', 'update']]);
        $this->middleware('permission:حذف فضای مجازی', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        if (empty($request->all())) {
            $socialMedias = SocialMedia::with('adderInfo', 'editorInfo')->orderByDesc('id')->paginate(50);
        } else {
            $socialMedias = $this->searchControl($request);
        }
        return view('Posts.SocialMedia.index', compact('socialMedias'));
    }

    public function create()
    {
        $categories = $this->getAllNonPostCategories();
        $platforms = $this->getAllSocialMediaPlatforms();
        return view('Posts.SocialMedia.create', compact('categories', 'platforms'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'status' => 'required|integer|in:1,2',
            'chosen' => 'required|integer|in:0,1',
            'slider' => 'required|integer|in:0,1',
            'body' => 'required|string',
            'platform' => 'required|integer|exists:social_media_platforms,id',
            'platform_id' => 'required|string',
            'followers' => 'required|string',
            'activity' => 'required|string',
            'keywords' => 'required|string',
            'main_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'child_images' => 'array',
            'child_images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);

        $socialMedias = new SocialMedia();
        $socialMedias->title = $request->title;
        $socialMedias->status = $request->status;
        $socialMedias->chosen = $request->chosen;

        if ($request->status == 2) {
            $socialMedias->draft_token = $this->makeTokenForDraft('notes');
        } else {
            $socialMedias->draft_token = null;
        }

        $socialMedias->body = $request->body;
        $socialMedias->platform = $request->platform;
        $socialMedias->platform_id = $request->platform_id;
        $socialMedias->followers = $request->followers;
        $socialMedias->activity = $request->activity;
        $socialMedias->keywords = $this->jsonEncodeArrays($request->keywords);
        $socialMedias->adder = $this->getMyUserId();
        $socialMedias->save();

        $id = $socialMedias->id;
        if ($request->hasFile('main_image')) {
            $path = $request->file('main_image')->store('public/uploads/SocialMedia/' . $id);
            $this->savePictures($id, "social_media", 'picture_main', str_replace('public', '/storage', $path));
        }

        if ($request->hasFile('child_images')) {
            foreach ($request->file('child_images') as $file) {
                $path = $file->store('public/uploads/SocialMedia/' . $id);
                $this->savePictures($id, "social_media", 'picture_child', str_replace('public', '/storage', $path));
            }
        }

        if ($request->hasFile('slider_image')) {
            $this->sliderManagement($request->slider, 'SocialMedia', $socialMedias->id);
        }

        return redirect()->back()->with('success', "فضای مجازی با کد $id با موفقیت ایجاد شد.");
    }

    public function edit($id)
    {
        $socialMedia = SocialMedia::with('mainImage', 'childImages', 'adderInfo', 'editorInfo', 'sliderImage')->find($id);
        $categories = $this->getAllNonPostCategories();
        $platforms = $this->getAllSocialMediaPlatforms();
        return view('Posts.SocialMedia.edit', compact('socialMedia', 'categories', 'platforms'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|integer|exists:social_media,id',
            'title' => 'required|string',
            'status' => 'required|integer|in:1,2',
            'chosen' => 'required|integer|in:0,1',
            'slider' => 'required|integer|in:0,1',
            'body' => 'required|string',
            'platform' => 'required|integer|exists:social_media_platforms,id',
            'platform_id' => 'required|string',
            'followers' => 'required|string',
            'activity' => 'required|string',
            'keywords' => 'required|string',
            'main_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'child_images' => 'array',
            'child_images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);

        $id = $request->id;
        $socialMedias = SocialMedia::find($id);
        $socialMedias->title = $request->title;
        $socialMedias->status = $request->status;
        $socialMedias->chosen = $request->chosen;

        if ($request->status == 2) {
            $socialMedias->draft_token = $this->makeTokenForDraft('notes');
        } else {
            $socialMedias->draft_token = null;
        }

        $socialMedias->body = $request->body;
        $socialMedias->platform = $request->platform;
        $socialMedias->platform_id = $request->platform_id;
        $socialMedias->followers = $request->followers;
        $socialMedias->activity = $request->activity;
        $socialMedias->keywords = $this->jsonEncodeArrays($request->keywords);
        $socialMedias->editor = $this->getMyUserId();
        $socialMedias->save();


        if ($request->hasFile('main_image')) {
            $path = $request->file('main_image')->store('public/uploads/SocialMedia/' . $id);
            Picture::where('post_type', 'book_introductions')->where('image_type', 'picture_main')->where('post_id', $socialMedias->id)->delete();
            $this->savePictures($socialMedias->id, "social_media", 'picture_main', str_replace('public', '/storage', $path));
        }

        if ($request->hasFile('child_images')) {
            foreach ($request->file('child_images') as $file) {
                $path = $file->store('public/uploads/SocialMedia/' . $id);
                $this->savePictures($socialMedias->id, "social_media", 'picture_child', str_replace('public', '/storage', $path));
            }
        }

        if ($request->hasFile('slider_image') and $request->slider == 1) {
            $this->sliderManagement($request->slider, 'SocialMedia', $socialMedias->id, $request->slider_image);
        } elseif ($request->slider == 0) {
            $this->sliderManagement($request->slider, 'SocialMedia', $socialMedias->id);
        }

        return redirect()->back()->with('success', "فضای مجازی با کد $id با موفقیت ویرایش شد.");
    }

    public function destroy($id)
    {
        $delete = SocialMedia::where('id', $id)->delete();
        if ($delete) {
            $this->deleteSliderAfterDeletePost('social_medias', $id);
            return redirect()->back()->with('success', 'فضای مجازی با موفقیت حذف شد!');
        }
        return redirect()->back()->withErrors(['errors' => 'حذف فضای مجازی با مشکل مواجه شد!']);
    }

    public function destroyImage($id)
    {
        $delete = Picture::where('id', $id)->delete();
        if ($delete) {
            return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'fail']);
    }
}
