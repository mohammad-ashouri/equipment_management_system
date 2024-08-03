<?php

namespace App\Http\Controllers\DigitalEquipments;

use App\Http\Controllers\Controller;
use App\Models\DigitalEquipments\Tablet;
use Illuminate\Http\Request;

class TabletController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست تبلت', ['only' => ['index']]);
        $this->middleware('permission:ایجاد تبلت', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش تبلت', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف تبلت', ['only' => ['destroy']]);
    }

    public function index()
    {
        $tablets = Tablet::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->paginate(50);
        return view('DigitalEquipments.Tablets.index', compact('tablets'));
    }

    public function create()
    {
        return view('DigitalEquipments.Tablets.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'internal_memory' => 'required|string',
            'ram' => 'required|string',
            'simcard_number' => 'required|integer',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $tablets = Tablet::create(['model' => $request->input('model'),
            'brand' => $request->input('brand'),
            'internal_memory' => $request->input('internal_memory'),
            'ram' => $request->input('ram'),
            'simcard_number' => $request->input('simcard_number'),
            'adder' => $this->getMyUserId()]);

        if ($tablets) {
            return redirect()->route('Tablets.index')->with('success', 'تبلت با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد تبلت']);
    }

    public function edit($id)
    {
        $tablet = Tablet::findOrFail($id);

        return view('DigitalEquipments.Tablets.edit', compact('tablet'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:tablets,id',
            'model' => 'required|string',
            'internal_memory' => 'required|string',
            'ram' => 'required|string',
            'simcard_number' => 'required|integer',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $tablets = Tablet::findOrFail($id);
        $tablets->brand = $request->input('brand');
        $tablets->model = $request->input('model');
        $tablets->internal_memory = $request->input('internal_memory');
        $tablets->ram = $request->input('ram');
        $tablets->simcard_number = $request->input('simcard_number');
        $tablets->status = $request->input('status');
        $tablets->editor = $this->getMyUserId();
        $tablets->save();

        return redirect()->route('Tablets.index')->with('success', 'تبلت با موفقیت ویرایش شد.');
    }
}
