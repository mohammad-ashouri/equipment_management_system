<?php

namespace App\Http\Controllers;

use App\Models\Catalogs\Building;
use App\Models\Equipment;
use App\Models\EquipmentType;
use App\Models\Personnel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class EquipmentsController extends Controller
{

    public function equipments($personnel)
    {
        $personnel = Personnel::findOrFail($personnel);
        $equipmentTypes = EquipmentType::whereJsonContains('accessible_roles', $this->getMyRoleId())->orderBy('persian_name')->get();
        $equipments = Equipment::whereIn('equipment_type',$equipmentTypes->pluck('id')->toArray())->wherePersonnel($personnel->id)->get();
        $allPersonnels = Personnel::whereStatus(1)->whereNot('id', $personnel->id)->orderBy('last_name')->orderBy('first_name');
        return view('Personnels.equipments', compact('personnel', 'equipmentTypes', 'equipments', 'allPersonnels'));
    }

    public function newEquipment($personnel, $equipmentType)
    {
        $personnel = Personnel::findOrFail($personnel);
        $equipmentType = EquipmentType::whereJsonContains('accessible_roles', $this->getMyRoleId())->findOrFail($equipmentType);
        $buildings = Building::orderBy('name')->get();
        return view('Personnels.Equipments.new', compact('personnel', 'equipmentType', 'buildings'));
    }

    public function storeEquipment(Request $request)
    {
        $this->validate($request, [
            'property_code' => 'nullable|string|unique:equipments,property_code',
            'equipment_type' => 'required|integer|exists:equipment_types,id',
        ]);
        $input = $request->all();
        $equipmentTypeInfo = EquipmentType::whereJsonContains('accessible_roles', $this->getMyRoleId())->find($request->equipment_type)->value('name');
        if (isset($input['internalHardDisk'])) {
            $input['internalHardDisk'] = array_filter($input['internalHardDisk'], function ($value) {
                return !is_null($value);
            });
            $internalHardDisks = array_filter($input['internalHardDisk']);
            $propertyCodes = array_filter($input['internalHardDisk_property_code']);

            foreach ($internalHardDisks as $key => $internalHardDiskId) {
                $propertyCode = $propertyCodes[$key] ?? null;

                $input['internalHardDisks'][] = [
                    'id' => $internalHardDiskId,
                    'property_code' => $propertyCode
                ];
            }
            unset($input['internalHardDisk'], $input['internalHardDisk_property_code']);
        } elseif ($equipmentTypeInfo == 'case' and !isset($input['internalHardDisk'])) {
            return redirect()->back()->withErrors(['errors' => 'مقدار هارد وارد نشده است']);
        }
        if (isset($input['ram'])) {
            $input['ram'] = array_filter($input['ram'], function ($value) {
                return !is_null($value);
            });
        } elseif ($equipmentTypeInfo == 'case' and isset($input['ram'])) {

            return redirect()->back()->withErrors(['errors' => 'مقدار رم وارد نشده است']);
        }
        $equipment = new Equipment();
        $equipment->personnel = $request->personnel;
        $equipment->property_code = $request->property_code;
        $equipment->delivery_date = $request->delivery_date;
        $equipment->equipment_type = $request->equipment_type;
        $equipment->building = $request->building;
        unset($input['building'], $input['personnel'], $input['property_code'], $input['equipment_type'], $input['_token']);
        $equipment->info = json_encode($input, true);
        $equipment->adder = $this->getMyUserId();
        $equipment->save();

        $equipmentType = EquipmentType::whereJsonContains('accessible_roles', $this->getMyRoleId())->find($request->equipment_type);
        return redirect()->route('Personnels.equipments', $equipment->personnel)->with('success', "$equipmentType->persian_name  با موفقیت ایجاد شد.");
    }

    public function editEquipment($personnel, $equipmentId)
    {
        $personnel = Personnel::findOrFail($personnel);
        $equipment = Equipment::findOrFail($equipmentId);
        $buildings = Building::orderBy('name')->get();
        return view('Personnels.Equipments.edit', compact('personnel', 'equipment', 'buildings'));
    }

    public function updateEquipment(Request $request)
    {
        $this->validate($request, [
            'equipmentId' => 'required|integer|exists:equipments,id',
            'property_code' => "nullable|string|unique:equipments,property_code,$request->equipmentId,id",
        ]);
        $input = $request->all();
        $equipment = Equipment::find($request->equipmentId);
        $equipmentTypeInfo = EquipmentType::whereJsonContains('accessible_roles', $this->getMyRoleId())->find($equipment->equipment_type)->value('name');
        if (isset($input['internalHardDisk'])) {
            $input['internalHardDisk'] = array_filter($input['internalHardDisk'], function ($value) {
                return !is_null($value);
            });
            $internalHardDisks = array_filter($input['internalHardDisk']);
            $propertyCodes = array_filter($input['internalHardDisk_property_code']);

            foreach ($internalHardDisks as $key => $internalHardDiskId) {
                $propertyCode = $propertyCodes[$key] ?? null;

                $input['internalHardDisks'][] = [
                    'id' => $internalHardDiskId,
                    'property_code' => $propertyCode
                ];
            }
            unset($input['internalHardDisk'], $input['internalHardDisk_property_code']);
        } elseif ($equipmentTypeInfo == 'case' and !isset($input['internalHardDisk'])) {
            return redirect()->back()->withErrors(['errors' => 'مقدار هارد وارد نشده است']);
        }
        if (isset($input['ram'])) {
            $input['ram'] = array_filter($input['ram'], function ($value) {
                return !is_null($value);
            });
        } elseif ($equipmentTypeInfo == 'case' and !isset($input['ram'])) {
            return redirect()->back()->withErrors(['errors' => 'مقدار رم وارد نشده است']);
        }
        $equipment = Equipment::find($request->equipmentId);
        $equipment->property_code = $request->property_code;
        $equipment->delivery_date = $request->delivery_date;
        $equipment->building = $request->building;
        unset($input['_token']);
        $equipment->info = json_encode($input, true);
        $equipment->adder = $this->getMyUserId();
        $equipment->save();

        return redirect()->route('Personnels.equipments', $equipment->personnel)->with('success', $equipment->equipmentType->persian_name . "  با موفقیت ویرایش شد.");
    }

    public function moveEquipment(Request $request)
    {
        $equipmentInfo = Equipment::findOrFail($request->equipment_id);
        $personnelInfo = Personnel::findOrFail($request->personnel);
        if (empty($equipmentInfo) or empty($personnelInfo)) {
            Session::flash('errors', 'انتقال تجهیزات با خطا مواجه شد');
            return response()->json(['error'], 200);
        }
        $equipmentInfo->personnel = $personnelInfo->id;
        if ($equipmentInfo->save()) {
            Session::flash('success', 'تجهیزات با موفقیت منتقل شد');
            return response()->json(['success'], 200);
        }
    }
}
