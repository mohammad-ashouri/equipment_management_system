@extends('layouts.PanelMaster')
@section('content')
    <main class="flex-1 bg-gray-100 py-6 px-8">
        <div class="mx-auto lg:mr-72">
            <h1 class="text-2xl font-bold mb-4">جزئیات و ویرایش دستگاه سلفون کش و لمینیت</h1>
            @include('layouts.components.errors')
            <div class="bg-white rounded shadow flex flex-col ">
                {{ html()->form('PATCH')->route('LaminatingMachines.update',$laminatingMachine->id)->acceptsFiles()->id('edit-catalog')->open() }}
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
                                            @if($laminatingMachine->brand==$brand->id) selected @endif>{{ $brand->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="model"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">مدل </label>
                            <input type="text" name="model" value="{{ $laminatingMachine->model }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="" required>
                        </div>
                        <div>
                            <label for="type"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">نوع </label>
                            <select name="type"
                                    class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                <option value="" disabled selected>انتخاب کنید</option>
                                <option value="دستگاه پرس" @if($laminatingMachine->type=='دستگاه پرس') selected @endif>
                                    پرس
                                </option>
                                <option value="دستگاه سلفون کش حرارتی" @if($laminatingMachine->type=='دستگاه سلفون کش حرارتی') selected @endif>
                                    سلفون کش حرارتی
                                </option>
                                <option value="لمینیت سرد" @if($laminatingMachine->type=='لمینیت سرد') selected @endif>
                                    لمینیت سرد
                                </option>
                                <option value="لمینیت طولی" @if($laminatingMachine->type=='لمینیت طولی') selected @endif>
                                    لمینیت طولی
                                </option>
                            </select>
                        </div>
                        <div>
                            <label for="status"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">وضعیت</label>
                            <select name="status"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                <option value="1" {{$laminatingMachine->status ? 'selected' : ''}}>فعال</option>
                                <option value="0" {{!$laminatingMachine->status ? 'selected' : ''}}>غیر فعال</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    @can('ویرایش دستگاه سلفون کش و لمینیت')
                        <input type="hidden" name="id" value="{{ $laminatingMachine->id }}">
                        <button type="submit"
                                class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                            ویرایش دستگاه سلفون کش و لمینیت
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
