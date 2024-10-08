<?php

namespace App\Http\Controllers\TechnicalFacilities;

use App\Http\Controllers\Controller;
use App\Models\TechnicalFacilities\FireExtinguisher;
use Illuminate\Http\Request;

class FireExtinguisherController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:لیست کپسول آتش نشانی', ['only' => ['index']]);
        $this->middleware('permission:ایجاد کپسول آتش نشانی', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش کپسول آتش نشانی', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف کپسول آتش نشانی', ['only' => ['destroy']]);
    }

    public function index()
    {
        $fireExtinguishers = FireExtinguisher::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->paginate(50);
        return view('TechnicalFacilities.FireExtinguishers.index', compact('fireExtinguishers'));
    }

    public function create()
    {
        return view('TechnicalFacilities.FireExtinguishers.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'weight' => 'required|integer',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $fireExtinguisher = FireExtinguisher::create(['model' => $request->input('model'), 'brand' => $request->input('brand'), 'weight' => $request->input('weight'), 'adder' => $this->getMyUserId()]);

        if ($fireExtinguisher) {
            return redirect()->route('FireExtinguishers.index')->with('success', 'کپسول آتش نشانی با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد کپسول آتش نشانی']);
    }

    public function edit($id)
    {
        $fireExtinguisher = FireExtinguisher::findOrFail($id);

        return view('TechnicalFacilities.FireExtinguishers.edit', compact('fireExtinguisher'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:fire_extinguishers,id',
            'model' => 'required|string',
            'weight' => 'required|integer',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $fireExtinguisher = FireExtinguisher::findOrFail($id);
        $fireExtinguisher->brand = $request->input('brand');
        $fireExtinguisher->model = $request->input('model');
        $fireExtinguisher->weight = $request->input('weight');
        $fireExtinguisher->status = $request->input('status');
        $fireExtinguisher->editor = $this->getMyUserId();
        $fireExtinguisher->save();

        return redirect()->route('FireExtinguishers.index')->with('success', 'کپسول آتش نشانی با موفقیت ویرایش شد.');
    }
}
