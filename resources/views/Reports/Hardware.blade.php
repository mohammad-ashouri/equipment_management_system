@php
    $counter=0;
    use App\Models\DigitalEquipments\Phone;use App\Models\HardwareEquipments\Cases;use App\Models\HardwareEquipments\Cpu;use App\Models\HardwareEquipments\GraphicCard;use App\Models\HardwareEquipments\Headset;use App\Models\HardwareEquipments\InternalHardDisk;use App\Models\HardwareEquipments\Keyboard;use App\Models\HardwareEquipments\Monitor;use App\Models\HardwareEquipments\Motherboard;use App\Models\HardwareEquipments\Mouse;use App\Models\HardwareEquipments\Odd;use App\Models\HardwareEquipments\Power;use App\Models\HardwareEquipments\Printer;use App\Models\HardwareEquipments\Ram;use App\Models\HardwareEquipments\Scanner;use Illuminate\Support\Str;use Morilog\Jalali\Jalalian; @endphp
@extends('layouts.PanelMaster')
@section('content')
    <main class="flex-1 bg-cu-light py-6 px-8">
        <div class="mx-auto lg:mr-72">
            <h1 class="text-2xl font-bold mb-4">گزارش تمامی اقلام سخت افزاری موجود در سامانه</h1>
            <div class="bg-white rounded shadow p-6 mb-4">
                <div>
                    <table class="datatable w-full border-collapse rounded-lg overflow-hidden text-center mt-3">
                        <thead>
                        <tr class="bg-gradient-to-r from-blue-400 to-purple-500 items-center text-center text-white">
                            <th class=" px-6 py-3 w-9 font-bold ">ردیف</th>
                            <th class=" px-6 py-3 font-bold ">پرسنل</th>
                            <th class=" px-6 py-3 font-bold no-filter">case</th>
                            <th class=" px-6 py-3 font-bold no-filter">M.B</th>
                            <th class=" px-6 py-3 font-bold no-filter">CPU</th>
                            <th class=" px-6 py-3 font-bold no-filter">VGA</th>
                            <th class=" px-6 py-3 font-bold no-filter">ODD</th>
                            <th class=" px-3 py-3  font-bold no-filter">RAM</th>
                            <th class=" px-3 py-3  font-bold no-filter">HARD</th>
                            <th class=" px-3 py-3  font-bold no-filter ">Power</th>
                            <th class=" px-3 py-3  font-bold no-filter ">LCD</th>
                            <th class=" px-3 py-3  font-bold no-filter ">Keyboard</th>
                            <th class=" px-3 py-3  font-bold no-filter ">Mouse</th>
                            <th class=" px-3 py-3  font-bold no-filter ">Telephone</th>
                            <th class=" px-3 py-3  font-bold no-filter ">Printer</th>
                            <th class=" px-3 py-3  font-bold no-filter ">Scanner</th>
                            <th class=" px-3 py-3  font-bold no-filter ">Headset</th>
                            <th class=" px-3 py-3  font-bold no-filter ">اموال کیس</th>
                            <th class=" px-3 py-3  font-bold no-filter ">اموال مانیتور</th>
                            <th class=" px-3 py-3  font-bold no-filter ">اموال هارد</th>
                            <th class=" px-3 py-3  font-bold no-filter ">شماره پلمپ</th>
                            <th class=" px-3 py-3  font-bold no-filter ">ساختمان</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($persons as $person)
                            @php
                                $monitors=$cases=$mouses=$keyboards=$headsets=$printers=$scanners=$phones=$monitorPropertyCodes=$casePropertyCodes=$caseSealCodes=[];
                                foreach ($person->equipments as $equipment){
                                    $info=json_decode($equipment->info,true);
                                    switch ($equipment->equipment_type){
                                        case 1:
                                            $monitors[]=Monitor::find($info['monitor']);
                                            $monitorPropertyCodes[]=$equipment->property_code;
                                            break;
                                        case 2:
                                            $rams=[];
                                            foreach ($info['ram'] as $ram){
                                                $rams[]=Ram::find($ram);
                                            }
                                            $hards=[];
                                            foreach ($info['internalHardDisks'] as $hard){
                                                $hards[]=[
                                                    'property_code'=> $hard['property_code'],
                                                    'hard'=> InternalHardDisk::find($hard['id']),
                                                ];
                                            }
                                            $cases[]=[
                                                'case'=>Cases::find($info['case']),
                                                'power'=>Power::find($info['power']),
                                                'motherboard'=>Motherboard::find($info['motherboard']),
                                                'cpu'=>Cpu::find($info['cpu']),
                                                'graphicCard' => (isset($info['graphicCard']) && $info['graphicCard'] != 'ندارد') ? GraphicCard::find($info['graphicCard']) : null,
                                                'odd' => (isset($info['odd']) && $info['odd'] != 'ندارد') ? Odd::find($info['odd']) : null,
                                                'seal_code'=>$info['seal_code'],
                                                'rams'=>$rams,
                                                'hards'=>$hards,
                                            ];
                                            $casePropertyCodes[]=$equipment->property_code;
                                            $caseSealCodes[]= !empty($info['seal_code']) ? $info['seal_code'] : 'بدون کد';
                                            break;
                                        case 3:
                                            $mouses[]=Mouse::find($info['mouse']);
                                            break;
                                        case 4:
                                            $keyboards[]=Keyboard::find($info['keyboard']);
                                            break;
                                        case 5:
                                            $headsets[]=Headset::find($info['headset']);
                                            break;
                                        case 6:
                                            $printers[]=Printer::find($info['printer']);
                                            break;
                                        case 7:
                                            $scanners[]=Scanner::find($info['scanner']);
                                            break;
                                        case 15:
                                            $phones[]=Phone::find($info['phone']);
                                            break;
                                    }
                                }
                            @endphp
                            <tr class="odd:bg-gray-300 even:bg-white">
                                <td class="py-2">{{ $loop->iteration }}</td>
                                <td class="py-2">{{ $person->personnel_code }}</td>
                                <td class="py-2">
                                    <table>
                                        @foreach($cases as $case)
                                            <tr class="border-b-4">
                                                <td>
                                                    {{ $case['case']->brandInfo->name }} {{ $case['case']->model }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </td>
                                <td class="py-2">
                                    <table>
                                        @foreach($cases as $case)
                                            <tr class="border-b-4">
                                                <td>
                                                    {{ $case['motherboard']->brandInfo->name }} {{ $case['motherboard']->model }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </td>
                                <td class="py-2">
                                    <table>
                                        @foreach($cases as $case)
                                            <tr class="border-b-4">
                                                <td>
                                                    {{ $case['cpu']->brandInfo->name }} {{ $case['cpu']->model }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </td>
                                <td class="py-2">
                                    <table>
                                        @foreach($cases as $case)
                                            @if($case['graphicCard']!=null)
                                                <tr class="border-b-4">
                                                    <td>
                                                        {{ $case['graphicCard']->brandInfo->name }} {{ $case['graphicCard']->model }}
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </table>
                                </td>
                                <td class="py-2">
                                    <table>
                                        @foreach($cases as $case)
                                            @if($case['odd']!=null)
                                                <tr class="border-b-4">
                                                    <td>
                                                        {{ $case['odd']->brandInfo->name }} {{ $case['odd']->model }}
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </table>
                                </td>
                                <td class="py-2">
                                    <table>
                                        @foreach($cases as $case)
                                            @foreach($case['rams'] as $ram)
                                                <tr class="border-b-4">
                                                    <td>
                                                        {{ $ram->brandInfo->name }} {{ $ram->model }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </table>
                                </td>
                                <td class="py-2">
                                    <table>
                                        @foreach($cases as $case)
                                            @foreach($case['hards'] as $hards)
                                                <tr class="border-b-4">
                                                    <td>
                                                        {{ $hards['hard']->brandInfo->name }} {{ $hards['hard']->model }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </table>
                                </td>
                                <td class="py-2">
                                    <table>
                                        @foreach($cases as $case)
                                            <tr class="border-b-4">
                                                <td>
                                                    {{ $case['power']->brandInfo->name }} {{ $case['power']->model }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </td>
                                <td class="py-2">
                                    <table>
                                        @foreach($monitors as $monitor)
                                            <tr class="border-b-4">
                                                <td>
                                                    {{ $monitor->brandInfo->name }} {{ $monitor->model }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </td>
                                <td class="py-2">
                                    <table>
                                        @foreach($keyboards as $keyboard)
                                            <tr class="border-b-4">
                                                <td>
                                                    {{ $keyboard->brandInfo->name }} {{ $keyboard->model }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </td>
                                <td class="py-2">
                                    <table>
                                        @foreach($mouses as $mouse)
                                            <tr class="border-b-4">
                                                <td>
                                                    {{ $mouse->brandInfo->name }} {{ $mouse->model }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </td>
                                <td class="py-2">
                                    <table>
                                        @foreach($phones as $phone)
                                            <tr class="border-b-4">
                                                <td>
                                                    {{ $phone->brandInfo->name }} {{ $phone->model }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </td>
                                <td class="py-2">
                                    <table>
                                        @foreach($printers as $printer)
                                            <tr class="border-b-4">
                                                <td>
                                                    {{ $printer->brandInfo->name }} {{ $printer->model }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </td>
                                <td class="py-2">
                                    <table>
                                        @foreach($scanners as $scanner)
                                            <tr class="border-b-4">
                                                <td>
                                                    {{ $scanner->brandInfo->name }} {{ $scanner->model }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </td>
                                <td class="py-2">
                                    <table>
                                        @foreach($headsets as $headset)
                                            <tr class="border-b-4">
                                                <td>
                                                    {{ $headset->brandInfo->name }} {{ $headset->model }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </td>
                                <td class="py-2">
                                    <table>
                                        @foreach($casePropertyCodes as $casePropertyCode)
                                            <tr class="border-b-4">
                                                <td>
                                                    {{ isset($casePropertyCode) ? $casePropertyCode : null }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </td>
                                <td class="py-2">
                                    <table>
                                        @foreach($monitorPropertyCodes as $monitorPropertyCode)
                                            <tr class="border-b-4">
                                                <td>
                                                    {{ isset($monitorPropertyCode) ? $monitorPropertyCode : null }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </td>
                                <td class="py-2">
                                    <table>
                                        @foreach($hards as $hardPropertyCodes)
                                            <tr class="border-b-4">
                                                <td>
                                                    {{ (isset($hardPropertyCodes['property_code']) && $hardPropertyCodes['property_code']!=null) ? $hardPropertyCodes['property_code'] : null }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </td>
                                <td class="py-2">
                                    <table>
                                        @foreach($caseSealCodes as $caseSealCode)
                                            <tr class="border-b-4">
                                                <td>
                                                    {{ $caseSealCode }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </td>
                                <td class="py-2">
                                    {{ $person->buildingInfo->name }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection

