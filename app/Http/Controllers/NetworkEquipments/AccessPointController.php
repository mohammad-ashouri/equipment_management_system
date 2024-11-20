<?php

namespace App\Http\Controllers\NetworkEquipments;

use App\Http\Controllers\Controller;
use App\Models\NetworkEquipments\AccessPoint;
use Illuminate\Http\Request;

class AccessPointController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست اکسس پوینت', ['only' => ['index']]);
        $this->middleware('permission:ایجاد اکسس پوینت', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش اکسس پوینت', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف اکسس پوینت', ['only' => ['destroy']]);
    }

    public function index()
    {
        $accessPoints = AccessPoint::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('NetworkEquipments.AccessPoints.index', compact('accessPoints'));
    }

    public function create()
    {
        return view('NetworkEquipments.AccessPoints.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
            'antennas_number' => 'required|integer',
        ]);

        $accessPoint = AccessPoint::create([
            'model' => $request->input('model'),
            'antennas_number' => $request->input('antennas_number'),
            'brand' => $request->input('brand'),
            'adder' => $this->getMyUserId()
        ]);

        if ($accessPoint) {
            return redirect()->route('AccessPoints.index')->with('success', 'اکسس پوینت با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد اکسس پوینت']);
    }

    public function edit($id)
    {
        $accessPoint = AccessPoint::findOrFail($id);

        return view('NetworkEquipments.AccessPoints.edit', compact('accessPoint'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:access_points,id',
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
            'antennas_number' => 'required|integer',
        ]);

        $accessPoint = AccessPoint::findOrFail($id);
        $accessPoint->brand = $request->input('brand');
        $accessPoint->model = $request->input('model');
        $accessPoint->status = $request->input('status');
        $accessPoint->antennas_number = $request->input('antennas_number');
        $accessPoint->editor = $this->getMyUserId();
        $accessPoint->save();

        return redirect()->route('AccessPoints.index')->with('success', 'اکسس پوینت با موفقیت ویرایش شد.');
    }
}
