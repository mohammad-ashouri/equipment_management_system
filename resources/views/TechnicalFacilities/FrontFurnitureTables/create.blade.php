@extends('layouts.PanelMaster')
@section('content')
    <main class="flex-1 bg-gray-100 py-6 px-8">
        <div class="mx-auto lg:mr-72">
            <h1 class="text-2xl font-bold mb-4">ایجاد جلومبلی/میز عسلی</h1>
            @include('layouts.components.errors')
            <div class="bg-white rounded shadow flex flex-col ">
                {{ html()->form('POST')->route('FrontFurnitureTables.store')->acceptsFiles()->id('create-catalog')->open() }}
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
                            <select name="model"
                                    class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                <option value="" disabled selected>انتخاب کنید</option>
                                <option value="جلومبلی" @if(old('model')=='جلومبلی') selected @endif>
                                    جلومبلی
                                </option>
                                <option value="میز عسلی" @if(old('model')=='میز عسلی') selected @endif>
                                    میز عسلی
                                </option>
                            </select>
                        </div>
                        <div>
                            <label for="material"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">جنس </label>
                            <select name="material"
                                    class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                <option value="" disabled selected>انتخاب کنید</option>
                                <option value="فلزی" @if(old('material')=='فلزی') selected @endif>
                                    فلزی
                                </option>
                                <option value="شیشه ای" @if(old('material')=='شیشه ای') selected @endif>
                                    شیشه ای
                                </option>
                                <option value="چوبی" @if(old('material')=='چوبی') selected @endif>
                                    چوبی
                                </option>
                            </select>
                        </div>
                        <div class="grid grid-cols-3">
                            <div>
                                <label for="length"
                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">طول (بر حسب
                                    سانتی متر)
                                </label>
                                <input type="number" name="length" value="{{ old('length') }}"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       placeholder="" required>
                            </div>
                            <div>
                                <label for="width"
                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">عرض (بر حسب
                                    سانتی متر)
                                </label>
                                <input type="number" name="width" value="{{ old('width') }}"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       placeholder="" required>
                            </div>
                            <div>
                                <label for="height"
                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ارتفاع (بر حسب
                                    سانتی متر)
                                </label>
                                <input type="number" name="height" value="{{ old('height') }}"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       placeholder="" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    @can('ایجاد جلومبلی/میز عسلی')
                        <button type="submit"
                                class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                            ایجاد جلومبلی/میز عسلی
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
