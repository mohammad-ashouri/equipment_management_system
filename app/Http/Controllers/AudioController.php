<?php

namespace App\Http\Controllers;

use App\Models\Audio;
use App\Models\Catalogs\AudiosSubject;
use Illuminate\Http\Request;

class AudioController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:لیست صوت ها', ['only' => ['index']]);
        $this->middleware('permission:ایجاد صوت ها', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش صوت ها', ['only' => ['edit', 'update']]);
        $this->middleware('permission:حذف صوت ها', ['only' => ['destroy']]);
        ini_set('upload_max_filesize', '102400M');
        ini_set('post_max_size', '102400M');
    }

    public function index(Request $request)
    {
        if (empty($request->all())) {
            $audios = Audio::with('adderInfo', 'editorInfo')->orderByDesc('id')->paginate(50);
        } else {
            $audios = $this->searchControl($request);
        }
        return view('Multimedia.Audios.index', compact('audios'));
    }

    public function create()
    {
        $subjects = AudiosSubject::where('status', 1)->orderBy('name')->get();
        return view('Multimedia.Audios.create', compact('subjects'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'country' => 'required|string',
            'subject' => 'required|integer|exists:audios_subjects,id',
            'audio_file' => 'required|file|mimes:mpga,mp3,wav',
            'status' => 'required|integer|in:1,2',
        ]);

        $audio = new Audio();
        $audio->title = $request->title;
        $audio->status = $request->status;
        $audio->subject = $request->subject;
        $audio->country = $request->country;
        $audio->src = 1;
        $audio->adder = $this->getMyUserId();
        $audio->save();

        $id = $audio->id;
        $path = $request->file('audio_file')->store('public/uploads/Multimedia/Audios/' . $id);
        $audio->src = str_replace('public', '/storage', $path);
        $audio->save();

        return redirect()->route('Audios.index')->with('success', "صوت با کد $id با موفقیت ایجاد شد.");
    }

    public function edit($id)
    {
        $audio = Audio::with('adderInfo', 'editorInfo')->find($id);
        $subjects = AudiosSubject::where('status', 1)->orderBy('name')->get();
        return view('Multimedia.Audios.edit', compact('audio', 'subjects'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|integer|exists:audios,id',
            'title' => 'required|string',
            'country' => 'required|string',
            'subject' => 'required|integer|exists:audios_subjects,id',
            'audio_file' => 'nullable|file|mimes:mpga,mp3,wav',
            'status' => 'required|integer|in:1,2',
        ]);

        $id = $request->id;
        $audio = Audio::find($id);
        $audio->title = $request->title;
        $audio->country = $request->country;
        $audio->subject = $request->subject;
        $audio->status = $request->status;
        $audio->editor = $this->getMyUserId();
        if ($request->hasFile('audio_file')) {
            $path = $request->file('audio_file')->store('public/uploads/Multimedia/Audios/' . $id);
            $audio->src = str_replace('public', '/storage', $path);
        }
        $audio->save();

        return redirect()->route('Audios.index')->with('success', "صوت با کد $id با موفقیت ویرایش شد.");
    }

    public function destroy($id)
    {
        $delete = Audio::where('id', $id)->delete();
        if ($delete) {
            return redirect()->back()->with('success', 'صوت با موفقیت حذف شد!');
        }
        return redirect()->back()->withErrors(['errors' => 'حذف صوت با مشکل مواجه شد!']);
    }
}
