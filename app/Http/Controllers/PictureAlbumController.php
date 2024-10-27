<?php

namespace App\Http\Controllers;

use App\Models\Picture;
use App\Models\PictureAlbum;
use Illuminate\Http\Request;

class PictureAlbumController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست آلبوم تصاویر', ['only' => ['index']]);
        $this->middleware('permission:ایجاد آلبوم تصاویر', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش آلبوم تصاویر', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف آلبوم تصاویر', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        if (empty($request->all())) {
            $pictureAlbums = PictureAlbum::orderByDesc('date')->paginate(30);
        } else {
            $pictureAlbums = $this->searchControl($request);
        }
        return view('Multimedia.PictureAlbum.index', compact('pictureAlbums'));
    }

    public function create()
    {
        return view('Multimedia.PictureAlbum.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'date' => 'required',
            'image_file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'status' => 'required|integer|in:1,2',
        ]);

        $pictureAlbum = PictureAlbum::create(['title' => $request->input('title'), 'date' => $request->input('date'), 'adder' => $this->getMyUserId()]);

        $id = $pictureAlbum->id;
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('public/uploads/Multimedia/PictureAlbums/' . $id);
            $this->savePictures($id, "picture_album", 'picture_main', str_replace('public', '/storage', $path));
        }

        if ($pictureAlbum) {
            return redirect()->route('PictureAlbum.index')->with('success', 'آلبوم تصویر با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد آلبوم تصویر']);
    }

    public function edit($id)
    {
        $pictureAlbum = PictureAlbum::with('pictureSrc')->find($id);

        return view('Multimedia.PictureAlbum.edit', compact('pictureAlbum'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'date' => 'required',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'status' => 'required|integer|in:1,2',
        ]);

        $pictureAlbum = PictureAlbum::find($id);
        $pictureAlbum->title = $request->input('title');
        $pictureAlbum->date = $request->input('date');
        $pictureAlbum->status = $request->input('status');
        $id = $pictureAlbum->id;
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('public/uploads/Multimedia/PictureAlbums/' . $id);
            $this->savePictures($id, "picture_album", 'picture_main', str_replace('public', '/storage', $path));
        }
        $pictureAlbum->editor = $this->getMyUserId();
        $pictureAlbum->save();

        return redirect()->route('PictureAlbum.index')->with('success', 'آلبوم تصویر با موفقیت ویرایش شد.');
    }

    public function destroy($id)
    {
        $deleteAlbum = PictureAlbum::where('id', $id)->delete();
        $deletePicture = Picture::where('post_id', $id)->where('post_type', 'picture_album')->delete();
        if ($deleteAlbum and $deletePicture) {
            return redirect()->back()->with('success', 'آلبوم تصویر با موفقیت حذف شد!');
        }
        return redirect()->back()->withErrors(['errors' => 'حذف آلبوم تصویر با مشکل مواجه شد!']);
    }
}
