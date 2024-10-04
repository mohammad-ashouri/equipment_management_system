<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\EquipmentType;
use App\Models\Personnel;
use Illuminate\Http\Request;

class EquipmentsController extends Controller
{

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
        $this->validate($request, [
            'property_code' => 'nullable|string|unique:equipments,property_code',
        ]);

        $input = $request->all();
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
            'property_code' => "nullable|string|unique:equipments,property_code,$request->equipmentId,id",
        ]);
        $input = $request->all();
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
        } else {
            return redirect()->back()->withErrors(['errors' => 'مقدار هارد وارد نشده است']);
        }
        if (isset($input['ram'])) {
            $input['ram'] = array_filter($input['ram'], function ($value) {
                return !is_null($value);
            });
        } else {
            return redirect()->back()->withErrors(['errors' => 'مقدار رم وارد نشده است']);
        }
        $equipment = Equipment::find($request->equipmentId);
        $equipment->property_code = $request->property_code;
        $equipment->delivery_date = $request->delivery_date;
        unset($input['_token']);
        $equipment->info = json_encode($input, true);
        $equipment->adder = $this->getMyUserId();
        $equipment->save();

        return redirect()->route('Personnels.equipments', $equipment->personnel)->with('success', $equipment->equipmentType->persian_name . "  با موفقیت ویرایش شد.");
    }
}
