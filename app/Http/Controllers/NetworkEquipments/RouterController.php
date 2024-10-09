<?php

namespace App\Http\Controllers\NetworkEquipments;

use App\Http\Controllers\Controller;
use App\Models\NetworkEquipments\Router;
use Illuminate\Http\Request;

class RouterController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست روتر', ['only' => ['index']]);
        $this->middleware('permission:ایجاد روتر', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش روتر', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف روتر', ['only' => ['destroy']]);
    }

    public function index()
    {
        $routers = Router::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->paginate(50);
        return view('NetworkEquipments.Routers.index', compact('routers'));
    }

    public function create()
    {
        return view('NetworkEquipments.Routers.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string',
            'brand' => 'required|integer|exists:brands,id',
            'ports_number' => 'required|integer',
            'antennas_number' => 'required|integer',
        ]);

        $router = Router::create([
            'model' => $request->input('model'),
            'ports_number' => $request->input('ports_number'),
            'antennas_number' => $request->input('antennas_number'),
            'brand' => $request->input('brand'),
            'adder' => $this->getMyUserId()
        ]);

        if ($router) {
            return redirect()->route('Routers.index')->with('success', 'روتر با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد روتر']);
    }

    public function edit($id)
    {
        $router = Router::findOrFail($id);

        return view('NetworkEquipments.Routers.edit', compact('router'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:routers,id',
            'model' => 'required|string',
            'ports_number' => 'required|integer',
            'brand' => 'required|integer|exists:brands,id',
            'antennas_number' => 'required|integer',
        ]);

        $router = Router::findOrFail($id);
        $router->brand = $request->input('brand');
        $router->model = $request->input('model');
        $router->status = $request->input('status');
        $router->ports_number = $request->input('ports_number');
        $router->antennas_number = $request->input('antennas_number');
        $router->editor = $this->getMyUserId();
        $router->save();

        return redirect()->route('Routers.index')->with('success', 'روتر با موفقیت ویرایش شد.');
    }
}
