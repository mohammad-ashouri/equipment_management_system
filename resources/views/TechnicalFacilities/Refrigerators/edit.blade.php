@extends('layouts.PanelMaster')
@section('content')
    <main class="flex-1 bg-gray-100 py-6 px-8">
        <div class="mx-auto lg:mr-72">
            <h1 class="text-2xl font-bold mb-4">جزئیات و ویرایش صندلی</h1>
            @include('layouts.components.errors')
            <div class="bg-white rounded shadow flex flex-col ">
                {{ html()->form('PATCH')->route('Refrigerators.update',$refrigerator->id)->acceptsFiles()->id('edit-catalog')->open() }}
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
                                            @if($refrigerator->brand==$brand->id) selected @endif>{{ $brand->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="model"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">مدل </label>
                            <input type="text" name="model" value="{{ $refrigerator->model }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="" required>
                        </div>
                        <div>
                            <label for="type"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">نوع یخچال </label>
                            <select name="type"
                                    class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                <option value="" disabled selected>انتخاب کنید</option>
                                <option value="ساید بای ساید" @if($refrigerator->type=='ساید بای ساید') selected @endif>
                                    ساید بای ساید
                                </option>
                                <option value="یخچال و فریزر" @if($refrigerator->type=='یخچال و فریزر') selected @endif>
                                    یخچال و فریزر
                                </option>
                                <option value="فقط یخچال (بزرگ)" @if($refrigerator->type=='فقط یخچال (بزرگ)') selected @endif>
                                    فقط یخچال (بزرگ)
                                </option>
                                <option value="فقط فریزر (بزرگ)" @if($refrigerator->type=='فقط فریزر (بزرگ)') selected @endif>
                                    فقط فریزر (بزرگ)
                                </option>
                                <option value="فقط یخچال (مینی)" @if($refrigerator->type=='فقط یخچال (مینی)') selected @endif>
                                    فقط یخچال (مینی)
                                </option>
                                <option value="فقط فریزر (بزرگ)" @if($refrigerator->type=='فقط فریزر (مینی)') selected @endif>
                                    فقط فریزر (مینی)
                                </option>
                                <option value="یخچال بستنی" @if($refrigerator->type=='یخچال بستنی') selected @endif>
                                    یخچال بستنی
                                </option>
                            </select>
                        </div>
                        <div>
                            <label for="status"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">وضعیت</label>
                            <select name="status"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                <option value="1" {{$refrigerator->status ? 'selected' : ''}}>فعال</option>
                                <option value="0" {{!$refrigerator->status ? 'selected' : ''}}>غیر فعال</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    @can('ویرایش صندلی')
                        <input type="hidden" name="id" value="{{ $refrigerator->id }}">
                        <button type="submit"
                                class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                            ویرایش صندلی
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
