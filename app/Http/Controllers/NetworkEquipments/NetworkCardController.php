<?php

namespace App\Http\Controllers\NetworkEquipments;

use App\Http\Controllers\Controller;
use App\Models\NetworkEquipments\NetworkCard;
use Illuminate\Http\Request;

class NetworkCardController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست کارت شبکه', ['only' => ['index']]);
        $this->middleware('permission:ایجاد کارت شبکه', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش کارت شبکه', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف کارت شبکه', ['only' => ['destroy']]);
    }

    public function index()
    {
        $networkCards = NetworkCard::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('NetworkEquipments.NetworkCards.index', compact('networkCards'));
    }

    public function create()
    {
        return view('NetworkEquipments.NetworkCards.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
            'connectivity_type' => 'required|string',
            'function_type' => 'required|string',
        ]);

        $networkCard = NetworkCard::create(['model' => $request->input('model'), 'connectivity_type' => $request->input('connectivity_type'), 'function_type' => $request->input('function_type'), 'brand' => $request->input('brand'), 'adder' => $this->getMyUserId()]);

        if ($networkCard) {
            return redirect()->route('NetworkCards.index')->with('success', 'کارت شبکه با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد کارت شبکه']);
    }

    public function edit($id)
    {
        $networkCard = NetworkCard::findOrFail($id);

        return view('NetworkEquipments.NetworkCards.edit', compact('networkCard'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:network_cards,id',
            'model' => 'required|string',
            'connectivity_type' => 'required|string',
            'function_type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $networkCard = NetworkCard::findOrFail($id);
        $networkCard->brand = $request->input('brand');
        $networkCard->model = $request->input('model');
        $networkCard->status = $request->input('status');
        $networkCard->connectivity_type = $request->input('connectivity_type');
        $networkCard->function_type = $request->input('function_type');
        $networkCard->editor = $this->getMyUserId();
        $networkCard->save();

        return redirect()->route('NetworkCards.index')->with('success', 'کارت شبکه با موفقیت ویرایش شد.');
    }
}
