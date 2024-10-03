<?php

namespace App\Http\Controllers\NetworkEquipments;

use App\Http\Controllers\Controller;
use App\Models\NetworkEquipments\Kvm;
use Illuminate\Http\Request;

class KvmController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست kvm', ['only' => ['index']]);
        $this->middleware('permission:ایجاد kvm', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش kvm', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف kvm', ['only' => ['destroy']]);
    }

    public function index()
    {
        $Kvms = Kvm::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->paginate(50);
        return view('NetworkEquipments.Kvms.index', compact('Kvms'));
    }

    public function create()
    {
        return view('NetworkEquipments.Kvms.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
            'ports_number' => 'required|integer',
            'type' => 'required|string',
        ]);

        $Kvm = Kvm::create([
            'model' => $request->input('model'),
            'ports_number' => $request->input('ports_number'),
            'type' => $request->input('type'),
            'brand' => $request->input('brand'),
            'adder' => $this->getMyUserId()
        ]);

        if ($Kvm) {
            return redirect()->route('Kvms.index')->with('success', 'kvm با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد kvm']);
    }

    public function edit($id)
    {
        $Kvm = Kvm::findOrFail($id);

        return view('NetworkEquipments.Kvms.edit', compact('Kvm'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:kvms,id',
            'model' => 'required|string',
            'ports_number' => 'required|integer',
            'type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $Kvm = Kvm::findOrFail($id);
        $Kvm->brand = $request->input('brand');
        $Kvm->model = $request->input('model');
        $Kvm->status = $request->input('status');
        $Kvm->ports_number = $request->input('ports_number');
        $Kvm->type = $request->input('type');
        $Kvm->editor = $this->getMyUserId();
        $Kvm->save();

        return redirect()->route('Kvms.index')->with('success', 'kvm با موفقیت ویرایش شد.');
    }
}
