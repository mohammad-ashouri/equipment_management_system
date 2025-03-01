@php
    $counter=0;
    use App\Models\DigitalEquipments\Phone;use App\Models\HardwareEquipments\Cases;use App\Models\HardwareEquipments\Cpu;use App\Models\HardwareEquipments\GraphicCard;use App\Models\HardwareEquipments\Headset;use App\Models\HardwareEquipments\InternalHardDisk;use App\Models\HardwareEquipments\Keyboard;use App\Models\HardwareEquipments\Monitor;use App\Models\HardwareEquipments\Motherboard;use App\Models\HardwareEquipments\Mouse;use App\Models\HardwareEquipments\Odd;use App\Models\HardwareEquipments\Power;use App\Models\HardwareEquipments\Printer;use App\Models\HardwareEquipments\Ram;use Illuminate\Support\Str;use Morilog\Jalali\Jalalian; @endphp
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
                            <th class=" px-6 py-3 font-bold ">case</th>
                            <th class=" px-6 py-3 font-bold ">M.B</th>
                            <th class=" px-6 py-3 font-bold ">CPU</th>
                            <th class=" px-6 py-3 font-bold no-filter">VGA</th>
                            <th class=" px-6 py-3 font-bold">ODD</th>
                            <th class=" px-3 py-3  font-bold no-filter">RAM</th>
                            <th class=" px-3 py-3  font-bold no-filter">HARD</th>
                            <th class=" px-3 py-3  font-bold ">Power</th>
                            <th class=" px-3 py-3  font-bold ">LCD</th>
                            <th class=" px-3 py-3  font-bold ">Keyboard</th>
                            <th class=" px-3 py-3  font-bold ">Mouse</th>
                            <th class=" px-3 py-3  font-bold ">Telephone</th>
                            <th class=" px-3 py-3  font-bold ">Printer</th>
                            <th class=" px-3 py-3  font-bold ">Headphone</th>
                            <th class=" px-3 py-3  font-bold ">case</th>
                            <th class=" px-3 py-3  font-bold ">LCD</th>
                            <th class=" px-3 py-3  font-bold ">Hard</th>
                            <th class=" px-3 py-3  font-bold ">شماره پلمپ</th>
                            <th class=" px-3 py-3  font-bold ">ساختمان</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($persons as $key=>$person)
                            <tr class="odd:bg-gray-300 even:bg-white">
                                <td class="py-2">{{ $key }}</td>
                                <td class="py-2">{{ $person->personnel_code }}</td>
                                @php
                                dd($person->equipments);
                                    $equipment=null;
                                    $allEquipment=[];
                                        foreach($person->equipments as $equipment){
                                            $monitorPropertyCode=$casePropertyCode=$sealCode=$odd=$graphicCard=null;
                                            switch ($equipment->equipmentType->name){
                                                case 'case':
                                                    $equipmentInfo=json_decode($equipment['info'],true);
                                                    $case=Cases::find($equipmentInfo['case']);
                                                    $motherboard=Motherboard::find($equipmentInfo['motherboard']);
                                                    $cpu=Cpu::find($equipmentInfo['cpu']);
                                                    if(isset($equipmentInfo['graphicCard']) and $equipmentInfo['graphicCard']!='ندارد'){
                                                        $graphicCard=GraphicCard::find($equipmentInfo['graphicCard']);
                                                    }
                                                    if(isset($equipmentInfo['odd']) and $equipmentInfo['odd']!='ندارد'){
                                                        $odd=Odd::find($equipmentInfo['odd']);
                                                    }
                                                    $rams=[];
                                                    foreach ($equipmentInfo['ram'] as $ram){
                                                        $rams[]=Ram::find($ram);
                                                    }
                                                    $hards=[];
                                                    foreach ($equipmentInfo['internalHardDisks'] as $hard){
                                                        $hards[]=InternalHardDisk::find($hard['id']);
                                                    }
                                                    $power=Power::find($equipmentInfo['power']);
                                                    $sealCode=$equipmentInfo['seal_code'];
                                                    $casePropertyCode=@$equipmentInfo['property_code'];
                                                    break;
                                                case 'monitor':
                                                    $monitor=Monitor::find($equipment->monitor);
                                                    $monitorPropertyCode=$equipment->property_code;
                                                    break;
                                                case 'keyboard':
                                                    $keyboard=Keyboard::find($equipment->keyboard);
                                                    break;
                                                case 'mouse':
                                                    $mouse=Mouse::find($equipment->mouse);
                                                    break;
                                                case 'phone':
                                                    $phone=Phone::find($equipment->phone);
                                                    break;
                                                case 'printer':
                                                    $printer=Printer::find($equipment->printer);
                                                    break;
                                                case 'headphone':
                                                    $headphone=Headset::find($equipment->headphone);
                                                    break;
                                            }
                                        }
                                @endphp
                                <td class="py-2">{{ isset($case) ? $case->brandInfo->name . ' ' . $case->model : '' }}</td>
                                <td class="py-2">{{ isset($motherboard) ? $motherboard->brandInfo->name  . ' ' . $motherboard->model : '' }}</td>
                                <td class="py-2">{{ isset($cpu) ? $cpu->brandInfo->name  . ' ' . $cpu->model : '' }}</td>
                                <td class="py-2">{{ isset($graphicCard) ? $graphicCard->brandInfo->name . ' ' . $graphicCard->model . ' ' . $graphicCard->ram_size : '' }}</td>
                                <td class="py-2">{{ isset($odd) ? $odd->brandInfo->name . ' ' . $odd->model . ' ' . $odd->connectivity_type : '' }}</td>
                                <td class="py-2">
                                    @if(isset($rams))
                                        @foreach($rams as $ram)
                                            {{ $ram['brandInfo']['name'] }} - {{ $ram['model'] }}
                                            - {{ $ram['type'] }} - {{ $ram['size'] }}
                                            - {{ $ram['frequency'] }} <br/>
                                        @endforeach
                                    @endif
                                </td>
                                <td class="py-2">
                                    @if(isset($hards))
                                        @foreach($hards as $hard)
                                            {{ $hard['brandInfo']['name'] }} - {{ $hard['model'] }}
                                            - {{ $hard['capacity'] }}
                                            <br/>
                                        @endforeach
                                    @endif
                                </td>
                                <td class="py-2">{{ isset($power) ? $power->brandInfo->name . ' ' . $power->model . ' ' . $power->voltage : '' }}</td>
                                <td class="py-2">{{ isset($monitor) ? $monitor->brandInfo->name . ' ' . $monitor->model . ' ' . $monitor->size : '' }}</td>
                                <td class="py-2">{{ isset($keyboard) ? $keyboard->brandInfo->name . ' ' . $keyboard->model : '' }}</td>
                                <td class="py-2">{{ isset($mouse) ? $mouse->brandInfo->name . ' ' . $mouse->model : '' }}</td>
                                <td class="py-2">{{ isset($phone) ? $phone->brandInfo->name . ' ' . $phone->model : '' }}</td>
                                <td class="py-2">{{ isset($printer) ? $printer->brandInfo->name . ' ' .$printer->model . ' ' .$printer->function_type : '' }}</td>
                                <td class="py-2">{{ isset($headphone) ? $headphone->brandInfo->name : '' }}</td>
                                <td class="py-2">{{ $casePropertyCode }}</td>
                                <td class="py-2">{{ $monitorPropertyCode }}</td>
                                <td class="py-2">
                                    @if(isset($hards))
                                        @foreach ($equipmentInfo['internalHardDisks'] as $hard)
                                            {{ $hard['property_code'] }} <br>
                                        @endforeach
                                    @endif
                                </td>
                                <td class="py-2">{{ $sealCode }}
                                    <br/></td>
                                <td class="py-2">{{ isset($equipment->buildingInfo->name) ? $equipment->buildingInfo->name : '' }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection

