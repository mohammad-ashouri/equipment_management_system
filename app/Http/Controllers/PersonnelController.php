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
        $personnels = Personnel::with(['buildingInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->paginate(50);
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

        $personnels = Personnel::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'personnel_code' => $request->input('personnel_code'),
            'building' => $request->input('building'),
            'room_number' => $request->input('room_number'),
            'adder' => $this->getMyUserId()
        ]);

        if ($personnels) {
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

    public function equipments($personnel)
    {
        $personnel = Personnel::findOrFail($personnel);
        $equipmentTypes = EquipmentType::orderBy('persian_name')->get();
        $equipments = Equipment::wherePersonnel($personnel->id)->get();
        return view('Personnels.equipments', compact('personnel', 'equipmentTypes', 'equipments'));
    }

    public function newEquipment($personnel, $equipmentType)
    {
        $personnel = Personnel::findOrFail($personnel);
        $equipmentType = EquipmentType::findOrFail($equipmentType);
        return view('Personnels.Equipments.new', compact('personnel', 'equipmentType'));
    }

    public function storeEquipment(Request $request)
    {
        $input = $request->all();
        if (isset($input['hdd'])) {
            $input['hdd'] = array_filter($input['hdd'], function ($value) {
                return !is_null($value);
            });
        }
        if (isset($input['ram'])) {
            $input['ram'] = array_filter($input['ram'], function ($value) {
                return !is_null($value);
            });
        }
        $equipment = new Equipment();
        $equipment->personnel = $request->personnel;
        $equipment->property_code = $request->property_code;
        $equipment->delivery_date = $request->delivery_date;
        $equipment->equipment_type = $request->equipment_type;
        unset($input['personnel'], $input['property_code'], $input['equipment_type'], $input['_token']);
        $equipment->info = json_encode($input, true);
        $equipment->adder = $this->getMyUserId();
        $equipment->save();

        $equipmentType = EquipmentType::find($request->equipment_type);
        return redirect()->route('Personnels.equipments', $equipment->personnel)->with('success', "$equipmentType->persian_name  با موفقیت ایجاد شد.");
    }

    public function editEquipment($personnel, $equipmentId)
    {
        $personnel = Personnel::findOrFail($personnel);
        $equipment = Equipment::findOrFail($equipmentId);
        return view('Personnels.Equipments.edit', compact('personnel', 'equipment'));
    }

    public function updateEquipment(Request $request)
    {
        $this->validate($request, [
            'equipmentId' => 'required|integer|exists:equipments,id',
        ]);
        $input = $request->all();

        if (isset($input['hdd'])) {
            $input['hdd'] = array_filter($input['hdd'], function ($value) {
                return !is_null($value);
            });
        }
        if (isset($input['ram'])) {
            $input['ram'] = array_filter($input['ram'], function ($value) {
                return !is_null($value);
            });
        }
        $equipment = Equipment::find($request->equipmentId);
        $equipment->delivery_date = $request->delivery_date;
        unset($input['_token']);
        $equipment->info = json_encode($input, true);
        $equipment->adder = $this->getMyUserId();
        $equipment->save();

        return redirect()->route('Personnels.equipments', $equipment->personnel)->with('success', $equipment->equipmentType->persian_name . "  با موفقیت ویرایش شد.");

    }
}
