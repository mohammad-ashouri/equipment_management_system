@php use App\Models\HardwareEquipments\Cases;use App\Models\HardwareEquipments\CopyMachine;use App\Models\HardwareEquipments\Cpu;use App\Models\HardwareEquipments\GraphicCard;use App\Models\HardwareEquipments\Headset;use App\Models\HardwareEquipments\InternalHardDisk;use App\Models\HardwareEquipments\Keyboard;use App\Models\HardwareEquipments\Monitor;use App\Models\HardwareEquipments\Motherboard;use App\Models\HardwareEquipments\Mouse;use App\Models\HardwareEquipments\Odd;use App\Models\HardwareEquipments\Power;use App\Models\HardwareEquipments\Printer;use App\Models\HardwareEquipments\Ram;use App\Models\HardwareEquipments\Scanner; @endphp
@extends('layouts.PanelMaster')
@section('content')
    <script>
        $(document).ready(function () {
            $(".delivery_date").pDatepicker(
                {
                    "format": "LLLL",
                    "viewMode": "day",
                    "initialValue": true,
                    "minDate": null,
                    "maxDate": null,
                    "autoClose": false,
                    "position": "auto",
                    "altFormat": "lll",
                    "altField": "#altfieldExample",
                    "onlyTimePicker": false,
                    "onlySelectOnDate": true,
                    "calendarType": "persian",
                    "inputDelay": 800,
                    "observer": false,
                    "calendar": {
                        "persian": {
                            "locale": "fa",
                            "showHint": true,
                            "leapYearMode": "algorithmic"
                        },
                        "gregorian": {
                            "locale": "en",
                            "showHint": false
                        }
                    },
                    "navigator": {
                        "enabled": true,
                        "scroll": {
                            "enabled": true
                        },
                        "text": {
                            "btnNextText": "<",
                            "btnPrevText": ">"
                        }
                    },
                    "toolbox": {
                        "enabled": true,
                        "calendarSwitch": {
                            "enabled": false,
                            "format": "MMMM"
                        },
                        "todayButton": {
                            "enabled": true,
                            "text": {
                                "fa": "امروز",
                                "en": "Today"
                            }
                        },
                        "submitButton": {
                            "enabled": false,
                            "text": {
                                "fa": "تایید",
                                "en": "Submit"
                            }
                        },
                        "text": {
                            "btnToday": "امروز"
                        }
                    },
                    "timePicker": {
                        "enabled": false,
                        "step": 1,
                        "hour": {
                            "enabled": false,
                            "step": null
                        },
                        "minute": {
                            "enabled": false,
                            "step": null
                        },
                        "second": {
                            "enabled": false,
                            "step": null
                        },
                        "meridian": {
                            "enabled": false
                        }
                    },
                    "dayPicker": {
                        "enabled": true,
                        "titleFormat": "YYYY MMMM"
                    },
                    "monthPicker": {
                        "enabled": true,
                        "titleFormat": "YYYY"
                    },
                    "yearPicker": {
                        "enabled": true,
                        "titleFormat": "YYYY"
                    },
                    "responsive": true
                }
            );
        });
    </script>
    @switch($equipmentType->name)
        @case('case')
            @php
                $cases=Cases::whereStatus(1)->get();
                $powers=Power::whereStatus(1)->get();
                $cpus=Cpu::whereStatus(1)->get();
                $rams=Ram::whereStatus(1)->get();
                $motherboards=Motherboard::whereStatus(1)->get();
                $internalHards=InternalHardDisk::whereStatus(1)->get();
                $odds=Odd::whereStatus(1)->get();
                $graphicCards=GraphicCard::whereStatus(1)->get();
            @endphp
            @break
        @case('monitor')
            @php
                $monitors=Monitor::whereStatus(1)->get();
            @endphp
            @break
        @case('mouse')
            @php
                $mouses=Mouse::whereStatus(1)->get();
            @endphp
            @break
        @case('keyboard')
            @php
                $keyboards=Keyboard::whereStatus(1)->get();
            @endphp
            @break
        @case('headset')
            @php
                $headsets=Headset::whereStatus(1)->get();
            @endphp
            @break
        @case('printer')
            @php
                $printers=Printer::whereStatus(1)->get();
            @endphp
            @break
        @case('scanner')
            @php
                $scanners=Scanner::whereStatus(1)->get();
            @endphp
            @break
        @case('copy_machine')
            @php
                $copyMachines=CopyMachine::whereStatus(1)->get();
            @endphp
            @break
    @endswitch

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
                                   placeholder="" required>
                        </div>
                        <div>
                            <label for="delivery_date"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">تاریخ
                                تحویل </label>
                            <input type="text" name="delivery_date" value="{{ old('delivery_date') }}"
                                   class="delivery_date bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   required/>
                        </div>
                    </div>
                    @include('Personnels.Equipments.new.'.$equipmentType->name)
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
