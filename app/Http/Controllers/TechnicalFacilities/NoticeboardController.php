<?php

namespace App\Http\Controllers\TechnicalFacilities;

use App\Http\Controllers\Controller;
use App\Models\TechnicalFacilities\Noticeboard;
use Illuminate\Http\Request;

class NoticeboardController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست تخته اعلانات', ['only' => ['index']]);
        $this->middleware('permission:ایجاد تخته اعلانات', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش تخته اعلانات', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف تخته اعلانات', ['only' => ['destroy']]);
    }

    public function index()
    {
        $whiteboards = Noticeboard::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('TechnicalFacilities.Noticeboards.index', compact('whiteboards'));
    }

    public function create()
    {
        return view('TechnicalFacilities.Noticeboards.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'width' => 'required|integer',
            'length' => 'required|integer',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $whiteboards = Noticeboard::create(['model' => $request->input('model'), 'brand' => $request->input('brand'), 'width' => $request->input('width'), 'length' => $request->input('length'), 'adder' => $this->getMyUserId()]);

        if ($whiteboards) {
            return redirect()->route('Noticeboards.index')->with('success', 'تخته اعلانات با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد تخته اعلانات']);
    }

    public function edit($id)
    {
        $whiteboard = Noticeboard::findOrFail($id);

        return view('TechnicalFacilities.Noticeboards.edit', compact('whiteboard'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:whiteboards,id',
            'model' => 'required|string',
            'width' => 'required|integer',
            'length' => 'required|integer',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $whiteboards = Noticeboard::findOrFail($id);
        $whiteboards->brand = $request->input('brand');
        $whiteboards->model = $request->input('model');
        $whiteboards->width = $request->input('width');
        $whiteboards->length = $request->input('length');
        $whiteboards->status = $request->input('status');
        $whiteboards->editor = $this->getMyUserId();
        $whiteboards->save();

        return redirect()->route('Noticeboards.index')->with('success', 'تخته اعلانات با موفقیت ویرایش شد.');
    }
}
