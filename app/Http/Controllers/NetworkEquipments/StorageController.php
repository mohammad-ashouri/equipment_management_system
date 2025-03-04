<?php

namespace App\Http\Controllers\NetworkEquipments;

use App\Http\Controllers\Controller;
use App\Models\NetworkEquipments\Storage;
use Illuminate\Http\Request;

class StorageController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست Storage', ['only' => ['index']]);
        $this->middleware('permission:ایجاد Storage', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش Storage', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف Storage', ['only' => ['destroy']]);
    }

    public function index()
    {
        $storages = Storage::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('NetworkEquipments.Storages.index', compact('storages'));
    }

    public function create()
    {
        return view('NetworkEquipments.Storages.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
            'ram' => 'required|integer',
            'cpu' => 'required|string',
            'hdd' => 'required|integer',
            'ssd' => 'required|integer',
            'm2' => 'required|integer',
        ]);

        $storage = Storage::create([
            'model' => $request->input('model'),
            'ram' => $request->input('ram'),
            'cpu' => $request->input('cpu'),
            'hdd' => $request->input('hdd'),
            'ssd' => $request->input('ssd'),
            'm2' => $request->input('m2'),
            'brand' => $request->input('brand'),
            'adder' => $this->getMyUserId()
        ]);

        if ($storage) {
            return redirect()->route('Storages.index')->with('success', 'Storage با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد Storage']);
    }

    public function edit($id)
    {
        $storage = Storage::findOrFail($id);

        return view('NetworkEquipments.Storages.edit', compact('storage'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:storages,id',
            'model' => 'required|string',
            'ram' => 'required|integer',
            'cpu' => 'required|string',
            'hdd' => 'required|integer',
            'ssd' => 'required|integer',
            'm2' => 'required|integer',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $storage = Storage::findOrFail($id);
        $storage->brand = $request->input('brand');
        $storage->model = $request->input('model');
        $storage->status = $request->input('status');
        $storage->ram = $request->input('ram');
        $storage->cpu = $request->input('cpu');
        $storage->hdd = $request->input('hdd');
        $storage->ssd = $request->input('ssd');
        $storage->m2 = $request->input('m2');
        $storage->editor = $this->getMyUserId();
        $storage->save();

        return redirect()->route('Storages.index')->with('success', 'Storage با موفقیت ویرایش شد.');
    }
}
