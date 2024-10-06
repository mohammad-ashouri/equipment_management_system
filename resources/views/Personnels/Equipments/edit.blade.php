@php use App\Models\DigitalEquipments\AttendanceSystem;use App\Models\DigitalEquipments\CameraHolder;use App\Models\DigitalEquipments\CameraLens;use App\Models\DigitalEquipments\Cctv;use App\Models\DigitalEquipments\DVB;use App\Models\DigitalEquipments\ExternalHardDisk;use App\Models\DigitalEquipments\FlashMemory;use App\Models\DigitalEquipments\Mobile;use App\Models\DigitalEquipments\Phone;use App\Models\DigitalEquipments\Recorder;use App\Models\DigitalEquipments\SatelliteDish;use App\Models\DigitalEquipments\Simcard;use App\Models\DigitalEquipments\Speaker;use App\Models\DigitalEquipments\Tablet;use App\Models\DigitalEquipments\Television;use App\Models\DigitalEquipments\Ups;use App\Models\DigitalEquipments\Webcam;use App\Models\Equipment;use App\Models\HardwareEquipments\Cases;use App\Models\HardwareEquipments\CopyMachine;use App\Models\HardwareEquipments\Cpu;use App\Models\HardwareEquipments\GraphicCard;use App\Models\HardwareEquipments\Headset;use App\Models\HardwareEquipments\InternalHardDisk;use App\Models\HardwareEquipments\Keyboard;use App\Models\HardwareEquipments\Monitor;use App\Models\HardwareEquipments\Motherboard;use App\Models\HardwareEquipments\Mouse;use App\Models\HardwareEquipments\Odd;use App\Models\HardwareEquipments\Power;use App\Models\HardwareEquipments\Printer;use App\Models\HardwareEquipments\Ram;use App\Models\HardwareEquipments\Scanner;use App\Models\HardwareEquipments\Voip;use App\Models\NetworkEquipments\CableTester;use App\Models\NetworkEquipments\Dongle;use App\Models\NetworkEquipments\Kvm;use App\Models\NetworkEquipments\Lantv;use App\Models\NetworkEquipments\Modem;use App\Models\NetworkEquipments\PunchWrench;use App\Models\NetworkEquipments\Rack;use App\Models\NetworkEquipments\SocketWrench;use App\Models\NetworkEquipments\StripperWrench;use App\Models\NetworkEquipments\Switches; @endphp
@extends('layouts.PanelMaster')
@section('content')
    @switch($equipment->equipmentType->name)
        @case('case')
            @php
                $cases=Cases::get();
                $powers=Power::get();
                $cpus=Cpu::get();
                $rams=Ram::get();
                $motherboards=Motherboard::get();
                $internalHards=InternalHardDisk::get();
                $odds=Odd::get();
                $graphicCards=GraphicCard::get();
            @endphp
            @break
        @case('monitor')
            @php
                $monitors=Monitor::get();
            @endphp
            @break
        @case('mouse')
            @php
                $mouses=Mouse::get();
            @endphp
            @break
        @case('keyboard')
            @php
                $keyboards=Keyboard::get();
            @endphp
        @case('headset')
            @php
                $headsets=Headset::get();
            @endphp
            @break
        @case('printer')
            @php
                $printers=Printer::get();
            @endphp
            @break
        @case('scanner')
            @php
                $scanners=Scanner::get();
            @endphp
            @break
        @case('copy_machine')
            @php
                $copyMachines=CopyMachine::get();
            @endphp
            @break
        @case('voip')
            @php
                $voips=Voip::get();
            @endphp
            @break
        @case('switch')
            @php
                $switches=Switches::get();
            @endphp
            @break
        @case('modem')
            @php
                $modems=Modem::get();
            @endphp
            @break
        @case('rack')
            @php
                $racks=Rack::get();
            @endphp
            @break
        @case('dongle')
            @php
                $dongles=Dongle::get();
            @endphp
        @case('external_hard_disk')
            @php
                $external_hard_disks=ExternalHardDisk::get();
            @endphp
            @break
        @case('tablet')
            @php
                $tablets=Tablet::get();
            @endphp
            @break
        @case('phone')
            @php
                $phones=Phone::get();
            @endphp
            @break
        @case('mobile')
            @php
                $mobiles=Mobile::get();
            @endphp
            @break
        @case('camera_holder')
            @php
                $camera_holders=CameraHolder::get();
            @endphp
            @break
        @case('television')
            @php
                $televisions=Television::get();
            @endphp
            @break
        @case('dvb')
            @php
                $dvbs=DVB::get();
            @endphp
            @break
        @case('simcard')
            @php
                $allSimcards=Equipment::whereEquipmentType(21)->pluck('info')->toArray();
                $simcards=[];
                foreach ($allSimcards as $simcard){
                    $decoded=json_decode($simcard,true);
                    if ($decoded['simcard']==json_decode($equipment->info,true)['simcard']){
                        continue;
                    }
                    $simcards[]=$decoded['simcard'];
                }
                $simcards=Simcard::whereNotIn('id',$simcards)->get();
            @endphp
            @break
        @case('punch_wrench')
            @php
                $punchWrenches=PunchWrench::get();
            @endphp
            @break
        @case('socket_wrench')
            @php
                $socketWrenches=SocketWrench::get();
            @endphp
            @break
        @case('stripper_wrench')
            @php
                $stripperWrenches=StripperWrench::get();
            @endphp
            @break
        @case('cable_tester')
            @php
                $cableTesters=CableTester::get();
            @endphp
            @break
        @case('kvm')
            @php
                $kvms=Kvm::get();
            @endphp
            @break
        @case('lantv')
            @php
                $lantvs=Lantv::get();
            @endphp
            @break
        @case('speaker')
            @php
                $speakers=Speaker::get();
            @endphp
            @break
        @case('attendance_system')
            @php
                $attendanceSystems=AttendanceSystem::get();
            @endphp
            @break
        @case('cctv')
            @php
                $cctvs=Cctv::get();
            @endphp
            @break
        @case('recorder')
            @php
                $recorders=Recorder::get();
            @endphp
            @break
        @case('webcam')
            @php
                $webcams=Webcam::get();
            @endphp
            @break
        @case('flash_memory')
            @php
                $flash_memories=FlashMemory::get();
            @endphp
            @break
        @case('ups')
            @php
                $ups=Ups::get();
            @endphp
            @break
        @case('satellite_dish')
            @php
                $satelliteDishes=SatelliteDish::get();
            @endphp
            @break
        @case('camera_lens')
            @php
                $cameraLenses=CameraLens::get();
            @endphp
            @break
    @endswitch

    <main class="flex-1 bg-gray-100 py-6 px-8">
        {{ html()->form('POST')->route('Personnels.equipments.update')->id('equipment-form')->open() }}
        <div class="mx-auto lg:mr-72">
            <h1 class="text-2xl font-bold mb-4">ویرایش {{$equipment->equipmentType->persian_name}}
                برای {{ $personnel->first_name }} {{ $personnel->last_name }}
                با کد پرسنلی {{ $personnel->personnel_code }}</h1>
            @include('layouts.components.errors')
            @include('layouts.components.success')
            <div class="bg-white rounded shadow flex flex-col p-4">
                <div class="grid gap-6 mb-6 md:grid-cols-2">
                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label for="property_code"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">کد
                                اموال </label>
                            <input type="text" name="property_code" value="{{ $equipment->property_code }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="">
                        </div>
                        <div>
                            <label for="delivery_date"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">تاریخ
                                تحویل </label>
                            <input type="text" name="delivery_date" value="{{ $equipment->delivery_date }}"
                                   class="delivery_date bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   required/>
                        </div>
                    </div>
                    @include('Personnels.Equipments.edit.'.$equipment->equipmentType->name)
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <input type="hidden" name="equipmentId" value="{{$equipment->id}}">
                    <button type="submit"
                            class="mt-3 w-full inline-flex justify-center px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-green-300 sm:mt-0 sm:w-auto">
                        ویرایش
                    </button>
                    <button id="backward_page" type="button"
                            class="mt-3 ml-2 w-full inline-flex justify-center px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring focus:border-blue-300 sm:mt-0 sm:w-auto">
                        بازگشت
                    </button>
                </div>
            </div>
        </div>
        {{ html()->form()->close() }}
    </main>

@endsection
