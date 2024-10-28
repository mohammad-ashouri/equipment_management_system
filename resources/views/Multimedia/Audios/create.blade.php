@extends('layouts.PanelMaster')
@section('content')
    <main class="flex-1 bg-gray-100 py-6 px-8">
        <div class="mx-auto lg:mr-72">
            <h1 class="text-2xl font-bold mb-4">ایجاد صوت</h1>
            @include('layouts.components.errors')
            <div class="bg-gray-300 rounded shadow flex flex-col ">
                {{ html()->form('POST')->route('Audios.store')->acceptsFiles()->id('create-post')->open() }}
                <div class="bg-white rounded shadow flex flex-col p-4">
                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label for="title"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">عنوان
                            </label>
                            <input type="text" id="title" name="title" value="{{ old('title') }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="عنوان را وارد کنید" required>
                        </div>
                        <div>
                            <label for="country"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">کشور سازنده
                            </label>
                            <input type="text" id="country" name="country" value="{{ old('country') }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="کشور سازنده را وارد کنید" required>
                        </div>
                        <div>
                            <label for="subject"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">موضوع</label>
                            <select name="subject" id="subject"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                <option value="" selected disabled>انتخاب کنید</option>
                                @foreach($subjects as $subject)
                                    <option value="{{$subject->id}}" {{old('subject')==$subject->id ? 'selected' : ''}}>
                                        {{$subject->name}}</option>
                                @endforeach
                            </select>
                        </div>
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
                    </div>
                </div>
                <div class="bg-white mt-10 rounded shadow flex flex-col p-4">
                    <h3 class="font-bold mb-5">فایل صوت</h3>
                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label for="audio_file"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">انتخاب کنید
                            </label>
                            <input type="file" id="audio_file" name="audio_file" accept=".mpga,.mp3,.wav"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <p class="text-blue-500 text-sm mt-2 mr-4">حداکثر حجم فایل: 100 مگابایت</p>
                            <p class="text-blue-500 text-sm mt-2 mr-4">پسوندهای پشتیبانی شده: wav - mpga - mp3</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    @can('ایجاد صوت ها')
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
