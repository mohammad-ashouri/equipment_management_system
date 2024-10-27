@php use App\Models\DocumentClass; @endphp
@extends('layouts.PanelMaster')
@php
    if (isset($id)){
        $model=DocumentClass::find($id);
    }
@endphp
@section('content')
    <main class="flex-1 bg-gray-100 py-6 px-8">
        <div class="mx-auto lg:mr-72">
            <div class="flex mb-4">
                <h1 class="text-2xl font-bold mb-4">ایجاد کلاس اسناد</h1>
                @if (isset($id) and $model->status==2)
                    <x-show-draft-button route="DocumentClasses"
                                         token="{{ $model->draft_token }}"></x-show-draft-button>
                @endif
            </div>
            @include('layouts.components.errors')
            @include('layouts.components.success')
            <div class="bg-gray-300 rounded shadow flex flex-col ">
                {{ html()->form('POST')->route('DocumentClasses.store')->acceptsFiles()->id('create-post')->open() }}
                <div class="bg-white rounded shadow flex flex-col p-4">
                    <div class="grid gap-6 mb-6 md:grid-cols-3">
                        <div>
                            <label for="title"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">عنوان
                            </label>
                            <input type="text" id="title" name="title" value="{{ old('title') }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="عنوان را وارد کنید" required>
                        </div>
                        <div>
                            <label for="short_title"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">توضیح کوتاه
                            </label>
                            <textarea id="short_title" name="short_title" rows="7"
                                      class="border rounded-md w-full px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">{{ old('short_title') }}</textarea>
                        </div>
                        <div class="flex grid-cols-2">
                            <div class="ml-2">
                                <label for=""
                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">زمان
                                    دوره</label>
                                <label for="class_hours"
                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ساعت</label>
                                <input type="number" id="class_hours" name="class_hours"
                                       value="{{ old('class_hours') ? old('class_hours') : 0 }}"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-40 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       required min="0">
                            </div>
                            <div class="mt-7">
                                <label for="class_minutes"
                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">دقیقه</label>
                                <input type="number" id="class_minutes" name="class_minutes"
                                       value="{{ old('class_minutes') ? old('class_minutes') : 0 }}"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-40 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       required min="0" max="59">
                            </div>
                        </div>
                        {{--                        <script>--}}
                        {{--                            document.addEventListener('DOMContentLoaded', function () {--}}
                        {{--                                const form = document.querySelector('form');--}}
                        {{--                                form.addEventListener('submit', function (event) {--}}
                        {{--                                    const hours = document.getElementById('class_hours').value;--}}
                        {{--                                    const minutes = document.getElementById('class_minutes').value;--}}
                        {{--                                    const totalMinutes = (parseInt(hours) * 60) + parseInt(minutes);--}}

                        {{--                                    // Add a hidden input to hold the total time in minutes--}}
                        {{--                                    const hiddenInput = document.createElement('input');--}}
                        {{--                                    hiddenInput.type = 'hidden';--}}
                        {{--                                    hiddenInput.name = 'class_time';--}}
                        {{--                                    hiddenInput.value = totalMinutes;--}}
                        {{--                                    form.appendChild(hiddenInput);--}}
                        {{--                                });--}}
                        {{--                            });--}}
                        {{--                        </script>--}}
                        <div>
                            <label for="status"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">وضعیت</label>
                            <select name="status"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                <option value="1" {{old('status')==1 ? 'selected' : ''}}>منتشر شده</option>
                                <option value="2" {{old('status')==2 ? 'selected' : ''}}>پیش نویس</option>
                            </select>
                        </div>
                        <div>
                            <label for="chosen"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">برگزیده</label>
                            <select name="chosen"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                <option value="0" {{old('chosen')==0 ? 'selected' : ''}}>خیر</option>
                                <option value="1" {{old('chosen')==1 ? 'selected' : ''}}>بله</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label for="body" class="block text-gray-700 text-sm font-bold mb-2">درباره آموزش*:</label>
                        <textarea id="body" name="body" rows="7"
                                  class="border rounded-md w-full px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">{{ old('body') }}</textarea>
                    </div>
                </div>
                <div class="bg-white mt-10 rounded shadow flex flex-col p-4">
                    <h3 class="font-bold mb-5">سرفصل های دوره</h3>
                    <div class="grid gap-6 mb-6 " id="topicsContainer">
                        <div class="grid-cols-2">
                            @if(old('topics'))
                                @foreach(old('topics') as $index => $topic)
                                    <div class="topic flex">
                                        <div class="w-full mr-2">
                                            <label for=""
                                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">سرفصل
                                            </label>
                                            <input type="text" id="topic{{ $index }}" name="topics[]"
                                                   value="{{ $topic }}"
                                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                   placeholder="سرفصل {{ $index + 1 }} را وارد کنید" required>
                                        </div>
                                        <div class="w-full mr-2">
                                            <label for=""
                                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">لینک
                                                آپارات
                                            </label>
                                            <input type="text" id="aparat{{ $index }}" name="aparats[]" value=""
                                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                   placeholder="لینک فیلم {{ $index + 1 }} را وارد کنید" required>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="topic flex">
                                    <div class="w-full mr-2">
                                        <label for=""
                                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">سرفصل
                                        </label>
                                        <input type="text" id="topic0" name="topics[]" value=""
                                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                               placeholder="سرفصل 1 را وارد کنید" required>
                                    </div>
                                    <div class="w-full mr-2">
                                        <label for=""
                                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">لینک
                                            آپارات
                                        </label>
                                        <input type="text" id="aparat0" name="aparats[]" value=""
                                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                               placeholder="لینک فیلم را وارد کنید" required>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="text-center">
                        <button id="new_topic" type="button"
                                class="mt-3 w-96 inline-flex justify-center px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-green-300 sm:mt-0 sm:w-auto">
                            سرفصل جدید
                        </button>
                    </div>
                </div>
                <div class="bg-white mt-10 rounded shadow flex flex-col p-4">
                    <h3 class="font-bold mb-5">عکس شاخص</h3>
                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label for="main_image"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">انتخاب کنید
                            </label>
                            <input type="file" id="main_image" name="main_image" accept=".jpg,.bmp,.jpeg,.svg,.png"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>
                    </div>
                </div>
                {{--                <div class="bg-white mt-10 rounded shadow flex flex-col p-4">--}}
                {{--                    <h3 class="font-bold mb-5">فیلم دوره</h3>--}}
                {{--                    <div class="grid gap-6 mb-6 md:grid-cols-2">--}}
                {{--                        <div>--}}
                {{--                            <label for="video"--}}
                {{--                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">انتخاب کنید--}}
                {{--                            </label>--}}
                {{--                            <input type="file" id="video" name="video"--}}
                {{--                                   accept=".avi,.mp4,.mpeg4,.mkv,.webp"--}}
                {{--                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">--}}
                {{--                            <p class="text-blue-500 text-sm mt-2 mr-4">پسوندهای پشتیبانی شده:--}}
                {{--                                .avi,.mp4,.mpeg4,.mkv,.webp--}}
                {{--                            <p class="text-blue-500 text-sm mt-2 mr-4">حداکثر حجم فایل: 200 مگابایت--}}

                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
                <div class="bg-white mt-10 rounded shadow flex flex-col p-4">
                    <h3 class="font-bold mb-5">اطلاعات مدرس</h3>
                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label for="teacher"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">انتخاب کنید
                            </label>
                            <select name="teacher" id="teacher"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                <option value="" disabled selected>انتخاب کنید</option>
                                @foreach($teachers as $teacher)
                                    <option
                                        value="{{ $teacher->id }}" {{old('status')==$teacher->id ? 'selected' : ''}}>
                                        {{ $teacher->adjectiveInfo->name }} {{ $teacher->name }}
                                        - {{ $teacher->post }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <img class="w-full h-96 cursor-pointer" title="برای بزرگنمایی کلیک کنید"
                                 src="" id="master_image"
                                 alt="تصویر یافت نشد!">
                        </div>
                    </div>
                </div>

                {{--                Slider manager--}}
                <x-slider.create/>

                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    @can('ایجاد کلاس اسناد')
                        <button type="submit"
                                class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                            ایجاد
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
