@php use App\Models\Catalogs\BookSubject;use App\Models\Catalogs\Publication;use App\Models\DigitalEquipments\AttendanceSystem;use App\Models\DigitalEquipments\BatteryCabinet;use App\Models\DigitalEquipments\BatteryCharger;use App\Models\DigitalEquipments\Camera;use App\Models\DigitalEquipments\CameraHolder;use App\Models\DigitalEquipments\CameraLens;use App\Models\DigitalEquipments\CameraRam;use App\Models\DigitalEquipments\CameraSlider;use App\Models\DigitalEquipments\Cctv;use App\Models\DigitalEquipments\DigitalPen;use App\Models\DigitalEquipments\DVB;use App\Models\DigitalEquipments\ExternalHardDisk;use App\Models\DigitalEquipments\FlashMemory;use App\Models\DigitalEquipments\Laptop;use App\Models\DigitalEquipments\Light;use App\Models\DigitalEquipments\LightHolder;use App\Models\DigitalEquipments\Microphone;use App\Models\DigitalEquipments\Mobile;use App\Models\DigitalEquipments\Pbx;use App\Models\DigitalEquipments\Phone;use App\Models\DigitalEquipments\Recorder;use App\Models\DigitalEquipments\SatelliteDish;use App\Models\DigitalEquipments\SatelliteFinder;use App\Models\DigitalEquipments\SatelliteSwitch;use App\Models\DigitalEquipments\SetTopBox;use App\Models\DigitalEquipments\Simcard;use App\Models\DigitalEquipments\SoundCard;use App\Models\DigitalEquipments\Speaker;use App\Models\DigitalEquipments\Tablet;use App\Models\DigitalEquipments\Ups;use App\Models\DigitalEquipments\VideoProjector;use App\Models\DigitalEquipments\VideoProjectorCurtain;use App\Models\DigitalEquipments\Webcam;use App\Models\GymEquipments\Crossover;use App\Models\HardwareEquipments\Cases;use App\Models\HardwareEquipments\CopyMachine;use App\Models\HardwareEquipments\Cpu;use App\Models\HardwareEquipments\ExternalWriter;use App\Models\HardwareEquipments\GraphicCard;use App\Models\HardwareEquipments\Headset;use App\Models\HardwareEquipments\InternalHardDisk;use App\Models\HardwareEquipments\Keyboard;use App\Models\HardwareEquipments\Monitor;use App\Models\HardwareEquipments\Motherboard;use App\Models\HardwareEquipments\Mouse;use App\Models\HardwareEquipments\Odd;use App\Models\HardwareEquipments\Power;use App\Models\HardwareEquipments\Printer;use App\Models\HardwareEquipments\Ram;use App\Models\HardwareEquipments\Scanner;use App\Models\HardwareEquipments\Voip;use App\Models\NetworkEquipments\AccessPoint;use App\Models\NetworkEquipments\CableTester;use App\Models\NetworkEquipments\Dongle;use App\Models\NetworkEquipments\Kvm;use App\Models\NetworkEquipments\Lantv;use App\Models\NetworkEquipments\Lmb;use App\Models\NetworkEquipments\Modem;use App\Models\NetworkEquipments\Nvr;use App\Models\NetworkEquipments\PunchWrench;use App\Models\NetworkEquipments\Rack;use App\Models\NetworkEquipments\RadioWireless;use App\Models\NetworkEquipments\Router;use App\Models\NetworkEquipments\Server;use App\Models\NetworkEquipments\SocketWrench;use App\Models\NetworkEquipments\StripperWrench;use App\Models\NetworkEquipments\Switches;use App\Models\TechnicalFacilities\AirConditioner;use App\Models\TechnicalFacilities\Bed;use App\Models\TechnicalFacilities\Blower;use App\Models\TechnicalFacilities\Book;use App\Models\TechnicalFacilities\Bracket;use App\Models\TechnicalFacilities\Chair;use App\Models\TechnicalFacilities\Closet;use App\Models\TechnicalFacilities\CoatHanger;use App\Models\TechnicalFacilities\Couch;use App\Models\TechnicalFacilities\DrawerFileCabinet;use App\Models\TechnicalFacilities\ElectricPanel;use App\Models\TechnicalFacilities\Fan;use App\Models\TechnicalFacilities\FireExtinguisher;use App\Models\TechnicalFacilities\Flashlight;use App\Models\TechnicalFacilities\FlowerPot;use App\Models\TechnicalFacilities\FrontFurnitureTable;use App\Models\TechnicalFacilities\Heater;use App\Models\TechnicalFacilities\HotGlueBinding;use App\Models\TechnicalFacilities\IranianCooler;use App\Models\TechnicalFacilities\KeyBox;use App\Models\TechnicalFacilities\Ladder;use App\Models\TechnicalFacilities\LaminatingMachine;use App\Models\TechnicalFacilities\Library;use App\Models\TechnicalFacilities\Microwave;use App\Models\TechnicalFacilities\Mihrab;use App\Models\TechnicalFacilities\Noticeboard;use App\Models\TechnicalFacilities\Oven;use App\Models\TechnicalFacilities\PaperCutter;use App\Models\TechnicalFacilities\PingPongTable;use App\Models\TechnicalFacilities\Refrigerator;use App\Models\TechnicalFacilities\Safe;use App\Models\TechnicalFacilities\Samovar;use App\Models\TechnicalFacilities\ShoeCabinet;use App\Models\TechnicalFacilities\Shredder;use App\Models\TechnicalFacilities\SpringBinding;use App\Models\TechnicalFacilities\SuggestionBox;use App\Models\TechnicalFacilities\Table;use App\Models\TechnicalFacilities\TeaMaker;use App\Models\TechnicalFacilities\Television;use App\Models\TechnicalFacilities\Thermometer;use App\Models\TechnicalFacilities\VaccumCleaner;use App\Models\TechnicalFacilities\WaterDispenser;use App\Models\TechnicalFacilities\WaterPurifier;use App\Models\TechnicalFacilities\Whiteboard;use App\Models\TechnicalFacilities\WhiteboardHolder; @endphp
@extends('layouts.PanelMaster')
@section('content')
    @php
        $models = [
            'case' => [
                Cases::class,
                Power::class,
                Cpu::class,
                Ram::class,
                Motherboard::class,
                InternalHardDisk::class,
                Odd::class,
                GraphicCard::class,
            ],
            'laptop' => [
                Laptop::class,
                Ram::class,
                InternalHardDisk::class,
            ],
            'book' => [
                BookSubject::class,
                Publication::class,
            ],
            'simcard' => Simcard::class,
            'monitor' => Monitor::class,
            'mouse' => Mouse::class,
            'keyboard' => Keyboard::class,
            'headset' => Headset::class,
            'printer' => Printer::class,
            'scanner' => Scanner::class,
            'copy_machine' => CopyMachine::class,
            'voip' => Voip::class,
            'switch' => Switches::class,
            'modem' => Modem::class,
            'rack' => Rack::class,
            'dongle' => Dongle::class,
            'external_hard_disk' => ExternalHardDisk::class,
            'tablet' => Tablet::class,
            'phone' => Phone::class,
            'mobile' => Mobile::class,
            'camera_holder' => CameraHolder::class,
            'television' => Television::class,
            'dvb' => DVB::class,
            'fire_extinguisher' => FireExtinguisher::class,
            'radio_wireless' => RadioWireless::class,
            'access_point' => AccessPoint::class,
            'router' => Router::class,
            'attendance_system' => AttendanceSystem::class,
            'battery_charger' => BatteryCharger::class,
            'camera_lens' => CameraLens::class,
            'cctv' => Cctv::class,
            'flash_memory' => FlashMemory::class,
            'microphone' => Microphone::class,
            'recorder' => Recorder::class,
            'satellite_dish' => SatelliteDish::class,
            'satellite_finder' => SatelliteFinder::class,
            'sound_card' => SoundCard::class,
            'speaker' => Speaker::class,
            'ups' => Ups::class,
            'video_projector' => VideoProjector::class,
            'video_projector_curtain' => VideoProjectorCurtain::class,
            'webcam' => Webcam::class,
            'cable_tester' => CableTester::class,
            'dongle' => Dongle::class,
            'Kvm' => Kvm::class,
            'lantv' => Lantv::class,
            'punch_wrench' => PunchWrench::class,
            'socket_wrench' => SocketWrench::class,
            'stripper_wrench' => StripperWrench::class,
            'refrigerator' => Refrigerator::class,
            'blower' => Blower::class,
            'key_box' => KeyBox::class,
            'drawer_file_cabinet' => DrawerFileCabinet::class,
            'air_conditioner' => AirConditioner::class,
            'heater' => Heater::class,
            'ladder' => Ladder::class,
            'ping_pong_table' => PingPongTable::class,
            'microwave' => Microwave::class,
            'fan' => Fan::class,
            'coat_hanger' => CoatHanger::class,
            'shredder' => Shredder::class,
            'oven' => Oven::class,
            'water_purifier' => WaterPurifier::class,
            'tea_maker' => TeaMaker::class,
            'samovar' => Samovar::class,
            'whiteboard' => Whiteboard::class,
            'water_dispenser' => WaterDispenser::class,
            'noticeboard' => Noticeboard::class,
            'paper_cutter' => PaperCutter::class,
            'spring_binding' => SpringBinding::class,
            'hot_glue_binding' => HotGlueBinding::class,
            'suggestion_box' => SuggestionBox::class,
            'closet' => Closet::class,
            'laminating_machine' => LaminatingMachine::class,
            'library' => Library::class,
            'bed' => Bed::class,
            'front_furniture_table' => FrontFurnitureTable::class,
            'book' => Book::class,
            'chair' => Chair::class,
            'table' => Table::class,
            'whiteboard_holder' => WhiteboardHolder::class,
            'vaccum_cleaner' => VaccumCleaner::class,
            'shoe_cabinet' => ShoeCabinet::class,
            'safe' => Safe::class,
            'thermometer' => Thermometer::class,
            'electric_panel' => ElectricPanel::class,
            'flashlight' => Flashlight::class,
            'mihrab' => Mihrab::class,
            'bracket' => Bracket::class,
            'flower_pot' => FlowerPot::class,
            'mobile' => Mobile::class,
            'camera' => Camera::class,
            'kvm' => Kvm::class,
            'camera_ram' => CameraRam::class,
            'pbx' => Pbx::class,
            'satellite_switch' => SatelliteSwitch::class,
            'nvr' => Nvr::class,
            'lmb' => Lmb::class,
            'set_top_box' => SetTopBox::class,
            'light_holder' => LightHolder::class,
            'battery_cabinet' => BatteryCabinet::class,
            'light' => Light::class,
            'camera_sliders' => CameraSlider::class,
            'server' => Server::class,
            'storage' => \App\Models\NetworkEquipments\Storage::class,
            'iranian_cooler' => IranianCooler::class,
            'couch' => Couch::class,
            'digital_pen' => DigitalPen::class,
            'crossover' => Crossover::class,
            'external_writer' => ExternalWriter::class,
        ];
        $equipmentTypeName = $equipmentType->name;
        $items = [];
        if (isset($models[$equipmentTypeName])) {
            $modelData = $models[$equipmentTypeName];

            if (is_array($modelData)) {
                foreach ($modelData as $modelClass) {
                    $items[$modelClass] = $modelClass::get();
                }
            } elseif (is_callable($modelData)) {
                $items[$modelData] = $modelData($equipment);
            } else {
                $items[$modelData] = $modelData::get();
            }
        }
    @endphp

    <main class="flex-1 bg-gray-100 py-6 px-8">
        {{ html()->form('POST')->route('Personnels.equipments.store')->id('equipment-form')->open() }}
        <div class="mx-auto lg:mr-72">
            <h1 class="text-2xl font-bold mb-4">ایجاد {{$equipmentType->persian_name}}
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
                            <input type="text" name="property_code" value="{{ old('property_code') }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="">
                        </div>
                        <div>
                            <label for="delivery_date"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">تاریخ
                                تحویل </label>
                            <input type="text" name="delivery_date" value="{{ old('delivery_date') }}"
                                   class="delivery_date bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   required/>
                        </div>
                        <div>
                            <label for="room_number"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">شماره
                                اتاق </label>
                            <input type="text" name="room_number" value="{{ old('room_number') }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
                        </div>
                        <div>
                            <label for="building"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ساختمان
                                مستقر </label>
                            <select name="building"
                                    class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                <option value="" disabled selected>انتخاب کنید</option>
                                @foreach($buildings as $building)
                                    <option value="{{ $building->id }}"
                                            @if(old('building')==$building->id) selected @endif>{{ $building->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="description"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">توضیحات </label>
                            <textarea type="text" name="description" rows="5"
                                      class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            >{{ old('description') }}</textarea>
                        </div>
                    </div>
                    @switch($equipmentType->name)
                        @case('case')
                            @include('Personnels.Equipments.new.case')
                            @break
                        @case('laptop')
                            @include('Personnels.Equipments.new.laptop')
                            @break
                        @case('simcard')
                            @include('Personnels.Equipments.new.simcard')
                            @break
                        @case('book')
                            @include('Personnels.Equipments.new.book')
                            @break
                        @default
                            @include('Personnels.Equipments.new.default')
                    @endswitch
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <input type="hidden" name="personnel" value="{{$personnel->id}}">
                    <input type="hidden" name="equipment_type" value="{{$equipmentType->id}}">
                    <button type="submit"
                            class="mt-3 w-full inline-flex justify-center px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-green-300 sm:mt-0 sm:w-auto">
                        ایجاد
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
