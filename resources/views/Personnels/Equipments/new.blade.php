@extends('layouts.PanelMaster')
@section('content')
    <main class="flex-1 bg-gray-100 py-6 px-8">
        {{ html()->form('POST')->route('Personnels.equipments.store')->id('create-catalog')->open() }}
        <div class="mx-auto lg:mr-72">
            <h1 class="text-2xl font-bold mb-4">ایجاد {{$equipmentType}}
                برای {{ $personnel->first_name }} {{ $personnel->last_name }}
                با کد پرسنلی {{ $personnel->personnel_code }}</h1>
            @include('layouts.components.errors')
            <div class="bg-white rounded shadow flex flex-col p-4">
                <div class="grid gap-6 mb-6 md:grid-cols-3">
                    @switch($equipmentType)
                        @case('کیس')
                            @include('Personnels.Equipments.new.case')
                            @break
                    @endswitch
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
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
