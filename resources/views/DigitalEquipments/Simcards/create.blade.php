@extends('layouts.PanelMaster')
@section('content')
    <main class="flex-1 bg-gray-100 py-6 px-8">
        <div class="mx-auto lg:mr-72">
            <h1 class="text-2xl font-bold mb-4">ایجاد سیمکارت</h1>
            @include('layouts.components.errors')
            <div class="bg-white rounded shadow flex flex-col ">
                {{ html()->form('POST')->route('Simcards.store')->acceptsFiles()->id('create-catalog')->open() }}
                <div class="bg-white rounded shadow flex flex-col p-4">
                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label for="brand"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">اپراتور </label>
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
                            <label for="type_use"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">نوع
                                استفاده </label>
                            <select name="type_use"
                                    class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                <option value="" disabled selected>انتخاب کنید</option>
                                <option value="Internet" @if(old('type_use')=='Internet') selected @endif>
                                    اینترنت
                                </option>
                                <option value="Call" @if(old('type_use')=='Call') selected @endif>
                                    تماس
                                </option>
                                <option value="Mixed" @if(old('type_use')=='Mixed') selected @endif>
                                    اینترنت + تماس
                                </option>
                            </select>
                        </div>
                        <div>
                            <label for="number"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">شماره </label>
                            <input type="text" name="number" value="{{ old('number') }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="شماره را به این صورت وارد کنید: +989123456789" required>
                        </div>
                        <div>
                            <label for="puk"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">PUK </label>
                            <input type="text" name="puk" value="{{ old('puk') }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="در صورت نبودن، - وارد کنید" required>
                        </div>
                        <div>
                            <label for="pin"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">PIN </label>
                            <input type="text" name="pin" value="{{ old('pin') }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="در صورت نبودن، - وارد کنید" required>
                        </div>
                        <div>
                            <label for="serial"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">شماره سریال </label>
                            <input type="text" name="serial" value="{{ old('serial') }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="در صورت نبودن، - وارد کنید" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
            @can('ایجاد سیمکارت')
                <button type="submit"
                        class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                    ایجاد سیمکارت
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
