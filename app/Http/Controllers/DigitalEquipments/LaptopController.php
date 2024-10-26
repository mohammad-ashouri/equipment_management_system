<?php

namespace App\Http\Controllers\DigitalEquipments;

use App\Http\Controllers\Controller;
use App\Models\DigitalEquipments\Laptop;
use App\Models\HardwareEquipments\Cpu;
use App\Models\HardwareEquipments\GraphicCard;
use Illuminate\Http\Request;

class LaptopController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست لپ تاپ', ['only' => ['index']]);
        $this->middleware('permission:ایجاد لپ تاپ', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش لپ تاپ', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف لپ تاپ', ['only' => ['destroy']]);
    }

    public function index()
    {
        $laptops = Laptop::with(['cpuInfo', 'graphicCardInfo', 'brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->paginate(50);
        return view('DigitalEquipments.Laptops.index', compact('laptops'));
    }

    public function create()
    {
        $cpus = Cpu::get();
        $graphicCards = GraphicCard::get();
        return view('DigitalEquipments.Laptops.create', compact('cpus', 'graphicCards'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'monitor_size' => 'required|numeric',
            'cpu' => 'required|integer|exists:cpus,id',
            'graphic_card' => 'required|integer|exists:graphic_cards,id',
            'odd' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $laptop = Laptop::create([
            'model' => $request->input('model'),
            'monitor_size' => $request->input('monitor_size'),
            'cpu' => $request->input('cpu'),
            'graphic_card' => $request->input('graphic_card'),
            'odd' => $request->input('odd'),
            'brand' => $request->input('brand'),
            'adder' => $this->getMyUserId()
        ]);

        if ($laptop) {
            return redirect()->route('Laptops.index')->with('success', 'لپ تاپ با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد لپ تاپ']);
    }

    public function edit($id)
    {
        $laptop = Laptop::findOrFail($id);
        $cpus = Cpu::get();
        $graphicCards = GraphicCard::get();

        return view('DigitalEquipments.Laptops.edit', compact('laptop','cpus', 'graphicCards'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:laptops,id',
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
            'monitor_size' => 'required|numeric',
            'cpu' => 'required|integer|exists:cpus,id',
            'graphic_card' => 'required|integer|exists:graphic_cards,id',
            'odd' => 'required|string',
        ]);

        $laptop = Laptop::findOrFail($id);
        $laptop->brand = $request->input('brand');
        $laptop->model = $request->input('model');
        $laptop->monitor_size = $request->input('monitor_size');
        $laptop->cpu = $request->input('cpu');
        $laptop->graphic_card = $request->input('graphic_card');
        $laptop->odd = $request->input('odd');
        $laptop->status = $request->input('status');
        $laptop->editor = $this->getMyUserId();
        $laptop->save();

        return redirect()->route('Laptops.index')->with('success', 'لپ تاپ با موفقیت ویرایش شد.');
    }
}
