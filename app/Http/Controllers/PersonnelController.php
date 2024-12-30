<?php

namespace App\Http\Controllers;

use App\Models\Catalogs\Building;
use App\Models\Equipment;
use App\Models\EquipmentType;
use App\Models\Personnel;
use Illuminate\Http\Request;

class PersonnelController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست پرسنل', ['only' => ['index']]);
        $this->middleware('permission:ایجاد پرسنل', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش پرسنل', ['only' => ['update', 'edit']]);
    }

    public function index()
    {
        $personnels = Personnel::with(['buildingInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('Personnels.index', compact('personnels'));
    }

    public function create()
    {
        $buildings = Building::whereStatus(1)->orderBy('name')->get();
        return view('Personnels.create', compact('buildings'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'personnel_code' => 'required|integer|unique:personnels,id',
            'building' => 'required|integer|exists:buildings,id',
            'room_number' => 'required|string',
        ]);

        $lastId = Personnel::latest('id')->first();
        $personnel = Personnel::create([
            'id' => $lastId->id + 1,
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'personnel_code' => $request->input('personnel_code'),
            'building' => $request->input('building'),
            'room_number' => $request->input('room_number'),
            'adder' => $this->getMyUserId()
        ]);

        if ($personnel) {
            return redirect()->route('Personnels.index')->with('success', 'پرسنل با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد پرسنل']);
    }

    public function edit($id)
    {
        $personnel = Personnel::findOrFail($id);
        $buildings = Building::whereStatus(1)->orderBy('name')->get();

        return view('Personnels.edit', compact('personnel', 'buildings'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'building' => 'required|integer|exists:buildings,id',
            'room_number' => 'required|string',
        ]);

        $personnel = Personnel::findOrFail($id);
        $personnel->first_name = $request->input('first_name');
        $personnel->last_name = $request->input('last_name');
        $personnel->personnel_code = $request->input('personnel_code');
        $personnel->building = $request->input('building');
        $personnel->room_number = $request->input('room_number');
        $personnel->status = $request->input('status');
        $personnel->editor = $this->getMyUserId();
        $personnel->save();

        return redirect()->route('Personnels.index')->with('success', 'پرسنل با موفقیت ویرایش شد.');
    }

}
