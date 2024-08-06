@php use App\Models\HardwareEquipments\Cases;use App\Models\HardwareEquipments\Cpu;use App\Models\HardwareEquipments\GraphicCard;use App\Models\HardwareEquipments\InternalHardDisk;use App\Models\HardwareEquipments\Motherboard;use App\Models\HardwareEquipments\Odd;use App\Models\HardwareEquipments\Power;use App\Models\HardwareEquipments\Ram; @endphp
@extends('layouts.PanelMaster')
@section('content')
    <main class="flex-1 bg-gray-100 py-6 px-8">
        {{ html()->form('POST')->route('Personnels.equipments.store')->open() }}
        <div class="mx-auto lg:mr-72">
            <h1 class="text-2xl font-bold mb-4">ایجاد {{$equipmentType}}
                برای {{ $personnel->first_name }} {{ $personnel->last_name }}
                با کد پرسنلی {{ $personnel->personnel_code }}</h1>
            @include('layouts.components.errors')
            <div class="bg-white rounded shadow flex flex-col p-4">
                <div class="grid gap-6 mb-6 md:grid-cols-2">
                    <div>
                        <label for="property_code"
                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">کد اموال </label>
                        <input type="text" name="property_code" value="{{ old('property_code') }}"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                               placeholder="" required>
                    </div>
                    @switch($equipmentType)
                        @case('کیس')
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
                            @include('Personnels.Equipments.new.case')
                            @break
                    @endswitch
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <input type="hidden" name="personnel" value="{{$personnel->id}}">
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
