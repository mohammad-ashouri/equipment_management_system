@extends('layouts.PanelMaster')
@section('content')
    <main class="flex-1 bg-gray-100 py-6 px-8">
        <div class="mx-auto lg:mr-72">
            <h1 class="text-2xl font-bold mb-4">ایجاد تابلو برق</h1>
            @include('layouts.components.errors')
            <div class="bg-white rounded shadow flex flex-col ">
                {{ html()->form('POST')->route('ElectricPanels.store')->acceptsFiles()->id('create-catalog')->open() }}
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
                            <label for="type"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">نوع </label>
                            <select name="type"
                                    class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                <option value="" disabled selected>انتخاب کنید</option>
                                <option value="تابلو برق" @if(old('type')=='تابلو برق') selected @endif>
                                    تابلو برق
                                </option>
                                <option value="جعبه تقسیم" @if(old('type')=='جعبه تقسیم') selected @endif>
                                    جعبه تقسیم
                                </option>
                                <option value="جعبه فیوز" @if(old('type')=='جعبه فیوز') selected @endif>
                                    جعبه فیوز
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
                                <option value="آلومینیوم" @if(old('material')=='آلومینیوم') selected @endif>
                                    آلومینیوم
                                </option>
                                <option value="آهن" @if(old('material')=='آهن') selected @endif>
                                    آهن
                                </option>
                                <option value="استیل" @if(old('material')=='استیل') selected @endif>
                                    استیل
                                </option>
                                <option value="پلاستیک" @if(old('material')=='پلاستیک') selected @endif>
                                    پلاستیک
                                </option>
                                <option value="سرامیک" @if(old('material')=='سرامیک') selected @endif>
                                    سرامیک
                                </option>
                            </select>
                        </div>
                        <div>
                            <label for="mode"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">حالت </label>
                            <select name="mode"
                                    class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                <option value="" disabled selected>انتخاب کنید</option>
                                <option value="ایستاده" @if(old('mode')=='ایستاده') selected @endif>
                                    ایستاده
                                </option>
                                <option value="توکار" @if(old('mode')=='توکار') selected @endif>
                                    توکار
                                </option>
                                <option value="دیواری" @if(old('mode')=='دیواری') selected @endif>
                                    دیواری
                                </option>
                                <option value="روکار" @if(old('mode')=='روکار') selected @endif>
                                    روکار
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    @can('ایجاد تابلو برق')
                        <button type="submit"
                                class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                            ایجاد تابلو برق
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
