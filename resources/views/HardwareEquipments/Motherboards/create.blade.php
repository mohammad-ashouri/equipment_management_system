@extends('layouts.PanelMaster')
@section('content')
    <main class="flex-1 bg-gray-100 py-6 px-8">
        <div class="mx-auto lg:mr-72">
            <h1 class="text-2xl font-bold mb-4">ایجاد مادربورد</h1>
            @include('layouts.components.errors')
            <div class="bg-white rounded shadow flex flex-col ">
                {{ html()->form('POST')->route('Motherboards.store')->acceptsFiles()->id('create-catalog')->open() }}
                <div class="bg-white rounded shadow flex flex-col p-4">
                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label for="brand"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">برند </label>
                            <select name="brand"
                                    class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                <option value="" disabled selected>انتخاب کنید</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}"
                                            @if(old('brand')==$brand->id) selected @endif>{{ $brand->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="model"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">مدل </label>
                            <input type="text" name="model" value="{{ old('model') }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="" required>
                        </div>
                        <div>
                            <label for="generation"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">نسل
                                مادربورد:</label>
                            <select id="generation"
                                    class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    name="generation">
                                <option value="" disabled selected>انتخاب کنید</option>
                                <option @if(old('generation')=='ATX') selected @endif value="ATX">ATX</option>
                                <option @if(old('generation')=='E-ATX') selected @endif value="E-ATX">E-ATX</option>
                                <option @if(old('generation')=='Mini-ITX') selected @endif value="Mini-ITX">Mini-ITX</option>
                                <option @if(old('generation')=='Micro-ATX') selected @endif value="Micro-ATX">Micro-ATX</option>
                            </select>
                        </div>
                        <div>
                            <label for="ram_slot_type"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">نوع رم </label>
                            <select name="ram_slot_type"
                                    class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                <option value="" disabled selected>انتخاب کنید</option>
                                @for($i=1;$i<=5;$i++)
                                    <option value="{{ 'DDR'.$i }}"
                                            @if(old('ram_slot_type')=='DDR'.$i) selected @endif>DDR{{ $i}}</option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label for="cpu_slot_type"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">نوع سوکت
                                پردازنده </label>
                            <select name="cpu_slot_type"
                                    class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                <option value="" disabled selected>انتخاب کنید</option>
                                <option @if(old('ram_slot_type')=='771') selected @endif value="771">771</option>
                                <option @if(old('ram_slot_type')=='775') selected @endif value="775">775</option>
                                <option @if(old('ram_slot_type')=='1150') selected @endif value="1150">1150</option>
                                <option @if(old('ram_slot_type')=='1151') selected @endif value="1151">1151</option>
                                <option @if(old('ram_slot_type')=='1155') selected @endif value="1155">1155</option>
                                <option @if(old('ram_slot_type')=='1156') selected @endif value="1156">1156</option>
                                <option @if(old('ram_slot_type')=='1200') selected @endif value="1200">1200</option>
                                <option @if(old('ram_slot_type')=='1248') selected @endif value="1248">1248</option>
                                <option @if(old('ram_slot_type')=='1356') selected @endif value="1356">1356</option>
                                <option @if(old('ram_slot_type')=='1567') selected @endif value="1567">1567</option>
                                <option @if(old('ram_slot_type')=='1700') selected @endif value="1700">1700</option>
                                <option @if(old('ram_slot_type')=='1851') selected @endif value="1851">1851</option>
                                <option @if(old('ram_slot_type')=='2011') selected @endif value="2011">2011</option>
                                <option @if(old('ram_slot_type')=='2066') selected @endif value="2066">2066</option>
                                <option @if(old('ram_slot_type')=='3647') selected @endif value="3647">3647</option>
                                <option @if(old('ram_slot_type')=='4189') selected @endif value="4189">4189</option>
                                <option @if(old('ram_slot_type')=='4677') selected @endif value="4677">4677</option>
                                <option @if(old('ram_slot_type')=='7529') selected @endif value="7529">7529</option>
                            </select>
                        </div>
                        <div>
                            <label for="cpu_slots_number"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">تعداد سوکت
                                پردازنده </label>
                            <select name="cpu_slots_number"
                                    class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                <option @if(old('ram_slot_type')=='1') selected @endif value="1">1</option>
                                <option @if(old('ram_slot_type')=='2') selected @endif value="2">2</option>
                            </select>
                        </div>
                        <div>
                            <label for="ram_slots_number"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">تعداد سوکت
                                رم </label>
                            <select name="ram_slots_number"
                                    class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                <option @if(old('ram_slots_number')=='2') selected @endif value="2">2</option>
                                <option @if(old('ram_slots_number')=='4') selected @endif value="4">4</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    @can('ایجاد مادربورد')
                        <button type="submit"
                                class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                            ایجاد مادربورد
                        </button>
                    @endcan
                    <button id="backward_page" type="button"
                            class="mt-3 w-full inline-flex justify-center px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring focus:border-blue-300 sm:mt-0 sm:w-auto">
                        بازگشت
                    </button>
                </div>
                {{ html()->form()->close() }}
            </div>
        </div>
    </main>
@endsection
