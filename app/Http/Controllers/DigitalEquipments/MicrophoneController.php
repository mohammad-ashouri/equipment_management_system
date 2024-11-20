<?php

namespace App\Http\Controllers\DigitalEquipments;

use App\Http\Controllers\Controller;
use App\Models\DigitalEquipments\Microphone;
use Illuminate\Http\Request;

class MicrophoneController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست میکروفون', ['only' => ['index']]);
        $this->middleware('permission:ایجاد میکروفون', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش میکروفون', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف میکروفون', ['only' => ['destroy']]);
    }

    public function index()
    {
        $microphones = Microphone::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('DigitalEquipments.Microphones.index', compact('microphones'));
    }

    public function create()
    {
        return view('DigitalEquipments.Microphones.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $microphone = Microphone::create([
            'model' => $request->input('model'),
            'brand' => $request->input('brand'),
            'type' => $request->input('type'),
            'adder' => $this->getMyUserId()
        ]);

        if ($microphone) {
            return redirect()->route('Microphones.index')->with('success', 'میکروفون با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد میکروفون']);
    }

    public function edit($id)
    {
        $microphone = Microphone::findOrFail($id);

        return view('DigitalEquipments.Microphones.edit', compact('microphone'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:microphones,id',
            'model' => 'required|string',
            'type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $microphone = Microphone::findOrFail($id);
        $microphone->brand = $request->input('brand');
        $microphone->model = $request->input('model');
        $microphone->type = $request->input('type');
        $microphone->status = $request->input('status');
        $microphone->editor = $this->getMyUserId();
        $microphone->save();

        return redirect()->route('Microphones.index')->with('success', 'میکروفون با موفقیت ویرایش شد.');
    }
}
