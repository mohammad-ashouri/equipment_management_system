@extends('layouts.PanelMaster')
@section('content')
    <main class="flex-1 bg-gray-100 py-6 px-8">
        <div class="mx-auto lg:mr-72">
            <h1 class="text-2xl font-bold mb-4">ایجاد لپ تاپ</h1>
            @include('layouts.components.errors')
            <div class="bg-white rounded shadow flex flex-col ">
                {{ html()->form('POST')->route('Laptops.store')->acceptsFiles()->id('create-catalog')->open() }}
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
                            <label for="monitor_size"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">سایز مانیتور
                            </label>
                            <select name="monitor_size"
                                    class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                <option value="" disabled selected>انتخاب کنید</option>
                                <option value="10" @if(old('monitor_size')=='10') selected @endif>
                                    10
                                </option>
                                <option value="11" @if(old('monitor_size')=='11') selected @endif>
                                    11
                                </option>
                                <option value="12" @if(old('monitor_size')=='12') selected @endif>
                                    12
                                </option>
                                <option value="13" @if(old('monitor_size')=='13') selected @endif>
                                    13
                                </option>
                                <option value="13.3" @if(old('monitor_size')=='13.3') selected @endif>
                                    13.3
                                </option>
                                <option value="13.5" @if(old('monitor_size')=='13.5') selected @endif>
                                    13.5
                                </option>
                                <option value="13.6" @if(old('monitor_size')=='13.6') selected @endif>
                                    13.6
                                </option>
                                <option value="14" @if(old('monitor_size')=='14') selected @endif>
                                    14
                                </option>
                                <option value="14.1" @if(old('monitor_size')=='14.1') selected @endif>
                                    14.1
                                </option>
                                <option value="15" @if(old('monitor_size')=='15') selected @endif>
                                    15
                                </option>
                                <option value="15.4" @if(old('monitor_size')=='15.4') selected @endif>
                                    15.4
                                </option>
                                <option value="15.6" @if(old('monitor_size')=='15.6') selected @endif>
                                    15.6
                                </option>
                                <option value="16" @if(old('monitor_size')=='16') selected @endif>
                                    16
                                </option>
                                <option value="16.1" @if(old('monitor_size')=='16.1') selected @endif>
                                    16.1
                                </option>
                                <option value="17" @if(old('monitor_size')=='17') selected @endif>
                                    17
                                </option>
                                <option value="17.3" @if(old('monitor_size')=='17.3') selected @endif>
                                    17.3
                                </option>
                                <option value="18" @if(old('monitor_size')=='18') selected @endif>
                                    18
                                </option>
                            </select>
                        </div>
                        <div>
                            <label for="cpu"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">پردازنده </label>
                            <select name="cpu"
                                    class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                <option value="" disabled selected>انتخاب کنید</option>
                                @foreach($cpus as $cpu)
                                    <option value="{{ $cpu->id }}"
                                            @if(old('cpu')==$cpu->id) selected @endif>{{ $cpu->brandInfo->name}}
                                        - {{ $cpu->model}} {{ !empty($cpu->generation) ?? ' - نسل'.$cpu->generation }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="graphic_card"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">کارت گرافیک </label>
                            <select name="graphic_card"
                                    class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="" disabled selected>انتخاب کنید</option>
                                @foreach($graphicCards as $graphicCard)
                                    <option value="{{ $graphicCard->id }}"
                                            @if(old('graphic_card')==$graphicCard->id) selected @endif>{{ $graphicCard->brandInfo->name}}
                                        - {{ $graphicCard->model}} - {{ $graphicCard->memory }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="odd"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">درایو نوری </label>
                            <select name="odd"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                <option value="دارد" {{ old('odd')=='دارد' ? 'selected' : '' }}>دارد</option>
                                <option value="ندارد" {{ old('odd')=='ندارد' ? 'selected' : '' }}>ندارد</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    @can('ایجاد لپ تاپ')
                        <button type="submit"
                                class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                            ایجاد لپ تاپ
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
