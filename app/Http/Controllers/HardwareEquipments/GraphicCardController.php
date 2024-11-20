<?php

namespace App\Http\Controllers\HardwareEquipments;

use App\Http\Controllers\Controller;
use App\Models\HardwareEquipments\GraphicCard;
use Illuminate\Http\Request;

class GraphicCardController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست کارت گرافیک', ['only' => ['index']]);
        $this->middleware('permission:ایجاد کارت گرافیک', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش کارت گرافیک', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف کارت گرافیک', ['only' => ['destroy']]);
    }

    public function index()
    {
        $graphicCards = GraphicCard::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('HardwareEquipments.GraphicCards.index', compact('graphicCards'));
    }

    public function create()
    {
        return view('HardwareEquipments.GraphicCards.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'ram_size' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $graphicCard = GraphicCard::create(['model' => $request->input('model'), 'brand' => $request->input('brand'), 'ram_size' => $request->input('ram_size'), 'adder' => $this->getMyUserId()]);

        if ($graphicCard) {
            return redirect()->route('GraphicCards.index')->with('success', 'کارت گرافیک با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد کارت گرافیک']);
    }

    public function edit($id)
    {
        $graphicCard = GraphicCard::findOrFail($id);

        return view('HardwareEquipments.GraphicCards.edit', compact('graphicCard'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:graphic_cards,id',
            'model' => 'required|string',
            'ram_size' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $graphicCard = GraphicCard::findOrFail($id);
        $graphicCard->brand = $request->input('brand');
        $graphicCard->model = $request->input('model');
        $graphicCard->ram_size = $request->input('ram_size');
        $graphicCard->status = $request->input('status');
        $graphicCard->editor = $this->getMyUserId();
        $graphicCard->save();

        return redirect()->route('GraphicCards.index')->with('success', 'کارت گرافیک با موفقیت ویرایش شد.');
    }
}
