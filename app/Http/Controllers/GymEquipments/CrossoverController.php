<?php

namespace App\Http\Controllers\GymEquipments;

use App\Http\Controllers\Controller;
use App\Models\GymEquipments\Crossover;
use Illuminate\Http\Request;

class CrossoverController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست کراس', ['only' => ['index']]);
        $this->middleware('permission:ایجاد کراس', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش کراس', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف کراس', ['only' => ['destroy']]);
    }

    public function index()
    {
        $crossovers = Crossover::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('GymEquipments.Crossovers.index', compact('crossovers'));
    }

    public function create()
    {
        return view('GymEquipments.Crossovers.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $crossovers = Crossover::create(['model' => $request->input('model'), 'brand' => $request->input('brand'), 'type' => $request->input('type'), 'adder' => $this->getMyUserId()]);

        if ($crossovers) {
            return redirect()->route('Crossovers.index')->with('success', 'کراس با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد کراس']);
    }

    public function edit($id)
    {
        $crossover = Crossover::findOrFail($id);

        return view('GymEquipments.Crossovers.edit', compact('crossover'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:crossovers,id',
            'model' => 'required|string',
            'type' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $crossovers = Crossover::findOrFail($id);
        $crossovers->brand = $request->input('brand');
        $crossovers->model = $request->input('model');
        $crossovers->type = $request->input('type');
        $crossovers->status = $request->input('status');
        $crossovers->editor = $this->getMyUserId();
        $crossovers->save();

        return redirect()->route('Crossovers.index')->with('success', 'کراس با موفقیت ویرایش شد.');
    }
}
