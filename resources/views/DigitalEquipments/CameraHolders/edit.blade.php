@extends('layouts.PanelMaster')
@section('content')
    <main class="flex-1 bg-gray-100 py-6 px-8">
        <div class="mx-auto lg:mr-72">
            <h1 class="text-2xl font-bold mb-4">جزئیات و ویرایش پایه دوربین</h1>
            @include('layouts.components.errors')
            <div class="bg-white rounded shadow flex flex-col ">
                {{ html()->form('PATCH')->route('CameraHolders.update',$cameraHolder->id)->acceptsFiles()->id('edit-catalog')->open() }}
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
                                            @if($cameraHolder->brand==$brand->id) selected @endif>{{ $brand->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="model"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">مدل </label>
                            <input type="text" name="model" value="{{ $cameraHolder->model }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="" required>
                        </div>
                        <div>
                            <label for="type"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">نوع
                            </label>
                            <select name="type"
                                    class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                <option value="" disabled selected>انتخاب کنید</option>
                                <option value="پایه گوریلی" @if($cameraHolder->type=='پایه گوریلی') selected @endif>
                                    پایه گوریلی
                                </option>
                                <option value="تک پایه" @if($cameraHolder->type=='تک پایه') selected @endif>
                                    تک پایه
                                </option>
                                <option value="سه پایه" @if($cameraHolder->type=='سه پایه') selected @endif>
                                    سه پایه
                                </option>
                                <option value="حرفه ای" @if($cameraHolder->type=='حرفه ای') selected @endif>
                                    حرفه ای
                                </option>
                                <option value="رومیزی" @if($cameraHolder->type=='رومیزی') selected @endif>
                                    رومیزی
                                </option>
                                <option value="سبک" @if($cameraHolder->type=='سبک') selected @endif>
                                    سبک
                                </option>
                                <option value="شانه ای" @if($cameraHolder->type=='شانه ای') selected @endif>
                                    شانه ای
                                </option>
                                <option value="فیلم برداری" @if($cameraHolder->type=='فیلم برداری') selected @endif>
                                    فیلم برداری
                                </option>
                            </select>
                        </div>
                        <div>
                            <label for="parts_number"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">تعداد قطعات پایه
                            </label>
                            <input type="number" name="parts_number" value="{{ $cameraHolder->parts_number }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="" required>
                        </div>
                        <div>
                            <label for="head_type"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">نوع هد
                            </label>
                            <select name="head_type"
                                    class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                <option value="" disabled selected>انتخاب کنید</option>
                                <option value="بال هد" @if($cameraHolder->head_type=='بال هد') selected @endif>
                                    بال هد
                                </option>
                                <option value="پن هد" @if($cameraHolder->head_type=='پن هد') selected @endif>
                                    پن هد
                                </option>
                                <option value="تک چشمی" @if($cameraHolder->head_type=='تک چشمی') selected @endif>
                                    تک چشمی
                                </option>
                                <option value="دو چشمی" @if($cameraHolder->head_type=='دو چشمی') selected @endif>
                                    دو چشمی
                                </option>
                                <option value="سه چشمی" @if($cameraHolder->head_type=='سه چشمی') selected @endif>
                                    سه چشمی
                                </option>
                                <option value="ثابت" @if($cameraHolder->head_type=='ثابت') selected @endif>
                                    ثابت
                                </option>
                                <option value="فاقد هد" @if($cameraHolder->head_type=='فاقد هد') selected @endif>
                                    فاقد هد
                                </option>
                            </select>
                        </div>
                        <div>
                            <label for="status"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">وضعیت</label>
                            <select name="status"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                <option value="1" {{$cameraHolder->status ? 'selected' : ''}}>فعال</option>
                                <option value="0" {{!$cameraHolder->status ? 'selected' : ''}}>غیر فعال</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    @can('ویرایش پایه دوربین')
                        <input type="hidden" name="id" value="{{ $cameraHolder->id }}">
                        <button type="submit"
                                class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                            ویرایش پایه دوربین
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
