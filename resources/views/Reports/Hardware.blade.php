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
                            <th class=" px-3 py-3 font-bold no-filter ">شماره پلمپ</th>
                            <th class=" px-3 py-3  font-bold no-filter ">ساختمان</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($persons as $person)
                            @php
                                $colors = [
                                    // رنگ‌های آبی و سبز متعادل
                                    'steelblue', 'teal', 'cadetblue', 'mediumturquoise', 'royalblue', 'deepskyblue',
                                    'dodgerblue', 'cornflowerblue', 'darkcyan', 'darkturquoise', 'slateblue',

                                    // رنگ‌های بنفش و صورتی متعادل
                                    'darkorchid', 'mediumorchid', 'darkviolet', 'blueviolet', 'mediumpurple', 'orchid',
                                    'plum', 'fuchsia', 'deeppink', 'palevioletred', 'crimson',

                                    // رنگ‌های گرم و طبیعی
                                    'sienna', 'chocolate', 'saddlebrown', 'peru', 'tan', 'goldenrod', 'darkgoldenrod',
                                    'sandybrown', 'orangered', 'tomato', 'firebrick', 'darkred',

                                    // رنگ‌های خاکستری و خنثی
                                    'dimgray', 'dimgrey', 'slategray', 'darkslategray', 'gray', 'zinc'
                                ];

                                $monitors=$cases=$mouses=$keyboards=$headsets=$printers=$scanners=$phones=$monitorPropertyCodes=$casePropertyCodes=$caseSealCodes=[];
                                foreach ($person->equipments as $key=>$equipment){
                                    $info=json_decode($equipment->info,true);
                                    switch ($equipment->equipment_type){
                                        case 1:
                                            $monitors[]=['monitor'=>Monitor::find($info['monitor']),'color'=>$colors[$key]];
                                            $monitorPropertyCodes[]=['code'=>$equipment->property_code,'color'=>$colors[$key]];
                                            break;
                                        case 2:
                                            $rams=[];
                                            foreach ($info['ram'] as $ram){
                                                $rams[]=['ram'=>Ram::find($ram),'color'=>$colors[$key]];
                                            }
                                            $hards=[];
                                            foreach ($info['internalHardDisks'] as $hard){
                                                $hards[]=[
                                                    'property_code'=> $hard['property_code'],
                                                    'hard'=> InternalHardDisk::find($hard['id']),
                                                    'color'=>$colors[$key],
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
                                                'color'=>$colors[$key],
                                            ];
                                            $casePropertyCodes[]=['code'=>$equipment->property_code,'color'=>$colors[$key]];
                                            $caseSealCodes[]= !empty($info['seal_code']) ? $info['seal_code'] : 'بدون کد';
                                            break;
                                        case 3:
                                            $mouses[]=['mouse'=>Mouse::find($info['mouse']),'color'=>$colors[$key]];
                                            break;
                                        case 4:
                                            $keyboards[]=['keyboard'=>Keyboard::find($info['keyboard']),'color'=>$colors[$key]];
                                            break;
                                        case 5:
                                            $headsets[]=['headset'=>Headset::find($info['headset']),'color'=>$colors[$key]];
                                            break;
                                        case 6:
                                            $printers[]=['printer'=>Printer::find($info['printer']),'color'=>$colors[$key]];
                                            break;
                                        case 7:
                                            $scanners[]=['scanner'=>Scanner::find($info['scanner']),'color'=>$colors[$key]];
                                            break;
                                        case 15:
                                            $phones[]=['phone'=>Phone::find($info['phone']),'color'=>$colors[$key]];
                                            break;
                                    }
                                }
                            @endphp
                            <tr class="odd:bg-gray-300 even:bg-white">
                                <td class="py-2">{{ $loop->iteration }}</td>
                                <td class="py-2">{{ $person->personnel_code }}</td>
                                <td class="py-2">
                                    <table style="border-collapse: separate; border-spacing: 5px;">
                                        @foreach($cases as $case)
                                            <tr>
                                                <td style="background-color: {{ $case['color'] ?? '#333' }};
                                                   border-radius: 5px;
                                                   padding: 10px;
                                                   overflow: hidden;
                                                   clip-path: inset(0 round 5px);
                                                   color: white;">
                                                    {{ $case['case']->brandInfo->name }} {{ $case['case']->model }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </td>
                                <td class="py-2">
                                    <table style="border-collapse: separate; border-spacing: 5px;">
                                        @foreach($cases as $case)
                                            <tr>
                                                <td style="background-color: {{ $case['color'] ?? '#333' }};
                                                   border-radius: 5px;
                                                   padding: 10px;
                                                   overflow: hidden;
                                                   clip-path: inset(0 round 5px);
                                                   color: white;">
                                                    {{ $case['motherboard']->brandInfo->name }} {{ $case['motherboard']->model }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </td>
                                <td class="py-2"><table style="border-collapse: separate; border-spacing: 5px;">
                                        @foreach($cases as $case)
                                            <tr>
                                                <td style="background-color: {{ $case['color'] ?? '#333' }};
                                                   border-radius: 5px;
                                                   padding: 10px;
                                                   overflow: hidden;
                                                   clip-path: inset(0 round 5px);
                                                   color: white;">
                                                    {{ $case['cpu']->brandInfo->name }} {{ $case['cpu']->model }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </td>
                                <td class="py-2"><table style="border-collapse: separate; border-spacing: 5px;">
                                        @foreach($cases as $case)
                                            @if($case['graphicCard'] != null)
                                                <tr>
                                                    <td style="background-color: {{ $case['color'] ?? '#333' }};
                                                       border-radius: 5px;
                                                       padding: 10px;
                                                       overflow: hidden;
                                                       clip-path: inset(0 round 5px);
                                                       color: white;">
                                                        {{ $case['graphicCard']->brandInfo->name }} {{ $case['graphicCard']->model }}
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </table>

                                </td>
                                <td class="py-2">
                                    <table style="border-collapse: separate; border-spacing: 5px;">
                                        @foreach($cases as $case)
                                            @if($case['odd']!=null)
                                                <tr>
                                                    <td style="background-color: {{ $case['color'] }};
                                                       border-radius: 5px;
                                                       padding: 10px;
                                                       overflow: hidden;
                                                       clip-path: inset(0 round 5px);
                                                       color: white;">
                                                        {{ $case['odd']->brandInfo->name }} {{ $case['odd']->model }}
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </table>
                                </td>
                                <td class="py-2">
                                    <table style="border-collapse: separate; border-spacing: 5px;">
                                        @foreach($cases as $case)
                                            @foreach($case['rams'] as $ram)
                                                <tr>
                                                    <td style="background-color: {{ $ram['color'] }};
                                                       border-radius: 5px;
                                                       padding: 10px;
                                                       overflow: hidden;
                                                       clip-path: inset(0 round 5px);
                                                       color: white;">
                                                        {{ $ram['ram']->brandInfo->name }} {{ $ram['ram']->model }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </table>

                                </td>
                                <td class="py-2">
                                    <table style="border-collapse: separate; border-spacing: 5px;">
                                        @foreach($cases as $case)
                                            @foreach($case['hards'] as $hards)
                                                <tr>
                                                    <td style="background-color: {{ $hards['color'] ?? '#333' }};
                                                       border-radius: 5px;
                                                       padding: 10px;
                                                       overflow: hidden;
                                                       clip-path: inset(0 round 5px);
                                                       color: white;">
                                                        {{ $hards['hard']->brandInfo->name }} {{ $hards['hard']->model }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </table>

                                </td>
                                <td class="py-2"><table style="border-collapse: separate; border-spacing: 5px;">
                                        @foreach($cases as $case)
                                            <tr>
                                                <td style="background-color: {{ $case['color'] ?? '#333' }};
                                                   border-radius: 5px;
                                                   padding: 10px;
                                                   overflow: hidden;
                                                   clip-path: inset(0 round 5px);
                                                   color: white;">
                                                    {{ $case['power']->brandInfo->name }} {{ $case['power']->model }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </td>
                                <td class="py-2">
                                    <table style="border-collapse: separate; border-spacing: 5px;">
                                        @foreach($monitors as $monitor)
                                            <tr>
                                                <td style="background-color: {{ $monitor['color'] ?? '#333' }};
                                                   border-radius: 5px;
                                                   padding: 10px;
                                                   overflow: hidden;
                                                   clip-path: inset(0 round 5px);
                                                   color: white;">
                                                    {{ $monitor['monitor']->brandInfo->name }} {{ $monitor['monitor']->model }} {{ $monitor['monitor']->size }}inch
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </td>
                                <td class="py-2">
                                    <table style="border-collapse: separate; border-spacing: 5px;">
                                        @foreach($keyboards as $keyboard)
                                            <tr>
                                                <td style="background-color: {{ $keyboard['color'] ?? '#333' }};
                                                   border-radius: 5px;
                                                   padding: 10px;
                                                   overflow: hidden;
                                                   clip-path: inset(0 round 5px);
                                                   color: white;">
                                                    {{ $keyboard['keyboard']->brandInfo->name }} - {{ $keyboard['keyboard']->model }} - {{ $keyboard['keyboard']->connectivity_type }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </td>
                                <td class="py-2">
                                    <table style="border-collapse: separate; border-spacing: 5px;">
                                        @foreach($mouses as $mouse)
                                            <tr>
                                                <td style="background-color: {{ $mouse['color'] ?? '#333' }};
                                                   border-radius: 5px;
                                                   padding: 10px;
                                                   overflow: hidden;
                                                   clip-path: inset(0 round 5px);
                                                   color: white;">
                                                    {{ $mouse['mouse']->brandInfo->name }} {{ $mouse['mouse']->model }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </td>
                                <td class="py-2">
                                    <table style="border-collapse: separate; border-spacing: 5px;">
                                        @foreach($phones as $phone)
                                            <tr>
                                                <td style="background-color: {{ $phone['color'] ?? '#333' }};
                                                   border-radius: 5px;
                                                   padding: 10px;
                                                   overflow: hidden;
                                                   clip-path: inset(0 round 5px);
                                                   color: white;">
                                                    {{ $phone['phone']->brandInfo->name }} {{ $phone['phone']->model }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </td>
                                <td class="py-2">
                                    <table style="border-collapse: separate; border-spacing: 5px;">
                                        @foreach($printers as $printer)
                                            <tr>
                                                <td style="background-color: {{ $printer['color'] ?? '#333' }};
                                                   border-radius: 5px;
                                                   padding: 10px;
                                                   overflow: hidden;
                                                   clip-path: inset(0 round 5px);
                                                   color: white;">
                                                    {{ $printer['printer']->brandInfo->name }} {{ $printer['printer']->model }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </td>
                                <td class="py-2">
                                    <table style="border-collapse: separate; border-spacing: 5px;">
                                        @foreach($scanners as $scanner)
                                            <tr>
                                                <td style="background-color: {{ $scanner['color'] ?? '#333' }};
                                                   border-radius: 5px;
                                                   padding: 10px;
                                                   overflow: hidden;
                                                   clip-path: inset(0 round 5px);
                                                   color: white;">
                                                    {{ $scanner['scanner']->brandInfo->name }} {{ $scanner['scanner']->model }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>

                                </td>
                                <td class="py-2">
                                    <table style="border-collapse: separate; border-spacing: 5px;">
                                        @foreach($headsets as $headset)
                                            <tr>
                                                <td style="background-color: {{ $headset['color'] ?? '#333' }};
                                                   border-radius: 5px;
                                                   padding: 10px;
                                                   overflow: hidden;
                                                   clip-path: inset(0 round 5px);
                                                   color: white;">
                                                    {{ $headset['headset']->brandInfo->name }} {{ $headset['headset']->model }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </td>
                                <td class="py-2">
                                    <table style="border-collapse: separate; border-spacing: 5px;">
                                        @foreach($casePropertyCodes as $casePropertyCode)
                                            <tr>
                                                <td style="background-color: {{ $casePropertyCode['color'] }};
                                                   border-radius: 5px;
                                                   padding: 10px;
                                                   overflow: hidden;
                                                   clip-path: inset(0 round 5px);
                                                   color: white;">
                                                    {{ $casePropertyCode['code'] ?? 'نامشخص' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>

                                </td>
                                <td class="py-2">
                                    <table style="border-collapse: separate; border-spacing: 5px;">
                                        @foreach($monitorPropertyCodes as $monitorPropertyCode)
                                            <tr>
                                                <td style="background-color: {{ $monitorPropertyCode['color'] ?? '#333' }};
                                                   border-radius: 5px;
                                                   padding: 10px;
                                                   overflow: hidden;
                                                   clip-path: inset(0 round 5px);
                                                   color: white;">
                                                    {{ $monitorPropertyCode['code'] ?? 'N/A' }}
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

