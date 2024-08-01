@extends('layouts.PanelMaster')
@section('content')
    <main class="flex-1 bg-gray-100 py-6 px-8">
        <div class="mx-auto lg:mr-72">
            <h1 class="text-2xl font-bold mb-4">ایجاد هارد اینترنال</h1>
            @include('layouts.components.errors')
            <div class="bg-white rounded shadow flex flex-col ">
                {{ html()->form('POST')->route('InternalHardDisks.store')->acceptsFiles()->id('create-catalog')->open() }}
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
                            <label for="capacity"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">حافظه </label>
                            <select name="capacity"
                                    class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                <option value="" disabled selected>انتخاب کنید</option>
                                <option @if(old('capacity')=="120GB") selected @endif value="120GB">120GB</option>
                                <option @if(old('capacity')=="128GB") selected @endif value="128GB">128GB</option>
                                <option @if(old('capacity')=="250GB") selected @endif value="250GB">250GB</option>
                                <option @if(old('capacity')=="256GB") selected @endif value="256GB">256GB</option>
                                <option @if(old('capacity')=="480GB") selected @endif value="480GB">480GB</option>
                                <option @if(old('capacity')=="500GB") selected @endif value="500GB">500GB</option>
                                <option @if(old('capacity')=="512GB") selected @endif value="512GB">512GB</option>
                                <option @if(old('capacity')=="1TB") selected @endif value="1TB">1TB</option>
                                <option @if(old('capacity')=="2TB") selected @endif value="2TB">2TB</option>
                                <option @if(old('capacity')=="3TB") selected @endif value="3TB">3TB</option>
                                <option @if(old('capacity')=="4TB") selected @endif value="4TB">4TB</option>
                                <option @if(old('capacity')=="6TB") selected @endif value="6TB">6TB</option>
                                <option @if(old('capacity')=="8TB") selected @endif value="8TB">8TB</option>
                                <option @if(old('capacity')=="10TB") selected @endif value="10TB">10TB</option>
                                <option @if(old('capacity')=="12TB") selected @endif value="12TB">12TB</option>
                                <option @if(old('capacity')=="14TB") selected @endif value="14TB">14TB</option>
                                <option @if(old('capacity')=="16TB") selected @endif value="16TB">16TB</option>
                                <option @if(old('capacity')=="18TB") selected @endif value="18TB">18TB</option>
                                <option @if(old('capacity')=="20TB") selected @endif value="20TB">20TB</option>
                                <option @if(old('capacity')=="24TB") selected @endif value="24TB">24TB</option>
                            </select>
                        </div>
                        <div>
                            <label for="connectivity_type"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">نوع اتصال</label>
                            <select name="connectivity_type"
                                    class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                <option value="" disabled selected>انتخاب کنید</option>
                                <option @if(old('connectivity_type')=="IDE") selected @endif value="IDE">IDE</option>
                                <option @if(old('connectivity_type')=="SATA") selected @endif value="SATA">SATA</option>
                                <option @if(old('connectivity_type')=="M2") selected @endif value="M2">M2</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    @can('ایجاد هارد اینترنال')
                        <button type="submit"
                                class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                            ایجاد هارد اینترنال
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
