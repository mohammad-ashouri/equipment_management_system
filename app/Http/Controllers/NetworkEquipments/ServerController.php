<?php

namespace App\Http\Controllers\NetworkEquipments;

use App\Http\Controllers\Controller;
use App\Models\NetworkEquipments\Server;
use Illuminate\Http\Request;

class ServerController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست سرور', ['only' => ['index']]);
        $this->middleware('permission:ایجاد سرور', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش سرور', ['only' => ['update', 'edit']]);
        $this->middleware('permission:حذف سرور', ['only' => ['destroy']]);
    }

    public function index()
    {
        $servers = Server::with(['brandInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('NetworkEquipments.Servers.index', compact('servers'));
    }

    public function create()
    {
        return view('NetworkEquipments.Servers.create');
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

        $server = Server::create([
            'model' => $request->input('model'),
            'ram' => $request->input('ram'),
            'cpu' => $request->input('cpu'),
            'hdd' => $request->input('hdd'),
            'ssd' => $request->input('ssd'),
            'm2' => $request->input('m2'),
            'brand' => $request->input('brand'),
            'adder' => $this->getMyUserId()
        ]);

        if ($server) {
            return redirect()->route('Servers.index')->with('success', 'سرور با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد سرور']);
    }

    public function edit($id)
    {
        $server = Server::findOrFail($id);

        return view('NetworkEquipments.Servers.edit', compact('server'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'id' => 'required|integer|exists:servers,id',
            'model' => 'required|string',
            'ram' => 'required|integer',
            'cpu' => 'required|string',
            'hdd' => 'required|integer',
            'ssd' => 'required|integer',
            'm2' => 'required|integer',
            'brand' => 'required|integer|exists:brands,id',
        ]);

        $server = Server::findOrFail($id);
        $server->brand = $request->input('brand');
        $server->model = $request->input('model');
        $server->status = $request->input('status');
        $server->ram = $request->input('ram');
        $server->cpu = $request->input('cpu');
        $server->hdd = $request->input('hdd');
        $server->ssd = $request->input('ssd');
        $server->m2 = $request->input('m2');
        $server->editor = $this->getMyUserId();
        $server->save();

        return redirect()->route('Servers.index')->with('success', 'سرور با موفقیت ویرایش شد.');
    }
}
