@extends('layouts.PanelMaster')
@section('content')
    <main class="flex-1 bg-gray-100 py-6 px-8">
        <div class="mx-auto lg:mr-72">
            <h1 class="text-2xl font-bold mb-4">جزئیات و ویرایش کپسول آتش نشانی</h1>
            @include('layouts.components.errors')
            <div class="bg-white rounded shadow flex flex-col ">
                {{ html()->form('PATCH')->route('FireExtinguishers.update',$fireExtinguisher->id)->acceptsFiles()->id('edit-catalog')->open() }}
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
                                            @if($fireExtinguisher->brand==$brand->id) selected @endif>{{ $brand->name}}</option>
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
                                <option value="پودر و گاز" @if($fireExtinguisher->model=='پودر و گاز') selected @endif>
                                    پودر و گاز
                                </option>
                                <option value="CO2" @if($fireExtinguisher->model=='CO2') selected @endif>
                                    CO2
                                </option>
                                <option value="فوم" @if($fireExtinguisher->model=='فوم') selected @endif>
                                    فوم
                                </option>
                                <option value="آب و گاز" @if($fireExtinguisher->model=='آب و گاز') selected @endif>
                                    آب و گاز
                                </option>
                                <option value="بیوورسال" @if($fireExtinguisher->model=='بیوورسال') selected @endif>
                                    بیوورسال
                                </option>
                            </select>
                        </div>
                        <div>
                            <label for="weight"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">وزن (بر حسب کیلوگرم)
                            </label>
                            <input type="number" name="weight" value="{{ $fireExtinguisher->weight }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="" required>
                        </div>
                        <div>
                            <label for="status"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">وضعیت</label>
                            <select name="status"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                <option value="1" {{$fireExtinguisher->status ? 'selected' : ''}}>فعال</option>
                                <option value="0" {{!$fireExtinguisher->status ? 'selected' : ''}}>غیر فعال</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    @can('ویرایش کپسول آتش نشانی')
                        <input type="hidden" name="id" value="{{ $fireExtinguisher->id }}">
                        <button type="submit"
                                class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                            ویرایش کپسول آتش نشانی
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
