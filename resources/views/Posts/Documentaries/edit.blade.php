@extends('layouts.PanelMaster')
@section('content')
    <main class="flex-1 bg-gray-100 py-6 px-8">
        <div class="mx-auto lg:mr-72">
            <div class="flex mb-4">
                <h1 class="text-2xl font-bold mb-4">جزئیات و ویرایش مستند</h1>
                @if ($documentary->status==2)
                    <x-show-draft-button route="Documentaries"
                                         token="{{ $documentary->draft_token }}"></x-show-draft-button>
                @endif
            </div>
            @include('layouts.components.errors')
            @include('layouts.components.success')
            <div class="bg-gray-300 rounded shadow flex flex-col ">
                {{ html()->form('PATCH')->route('Documentaries.update',$documentary->id)->acceptsFiles()->id('edit-post')->open() }}
                <div class="bg-white rounded shadow flex flex-col p-4">
                    <div class="grid gap-6 mb-6 md:grid-cols-3">
                        <div>
                            <label for="title"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">عنوان
                            </label>
                            <input type="text" id="title" name="title" value="{{ $documentary->title }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="عنوان را وارد کنید" required>
                        </div>
                        <div>
                            <label for="status"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">وضعیت</label>
                            <select name="status"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                <option value="1" {{$documentary->status==1 ? 'selected' : ''}}>منتشر شده</option>
                                <option value="2" {{$documentary->status==2 ? 'selected' : ''}}>پیش نویس</option>
                            </select>
                        </div>
                        <div>
                            <label for="chosen"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">برگزیده</label>
                            <select name="chosen"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                <option value="0" {{$documentary->chosen==0 ? 'selected' : ''}}>خیر</option>
                                <option value="1" {{$documentary->chosen==1 ? 'selected' : ''}}>بله</option>
                            </select>
                        </div>
                        <div>
                            <label for="subject"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">موضوع</label>
                            <select name="subject"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            >
                                @foreach($multimediaSubjects as $multimediaSubject)
                                    <option @if($documentary->subject==$multimediaSubject->id) selected
                                            @endif value="{{$multimediaSubject->id}}">
                                        {{$multimediaSubject->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="type"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">نوع فیلم</label>
                            <select name="type"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            >
                                <option @if($documentary->type=='مستند') selected @endif value="مستند">
                                    مستند
                                </option>
                                <option @if($documentary->type=='فیلم کوتاه') selected @endif value="فیلم کوتاه">
                                    فیلم کوتاه
                                </option>
                            </select>
                        </div>
                        <div>
                            <label for="suggested"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">اضافه شدن به
                                اسلایدر پیشنهادی</label>
                            <select name="suggested"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            >
                                <option @if($documentary->suggested==0) selected @endif value="0">
                                    خیر
                                </option>
                                <option @if($documentary->suggested==1) selected @endif value="1">
                                    بله
                                </option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label for="body" class="block text-gray-700 text-sm font-bold mb-2">متن*:</label>
                        <textarea id="body" name="body" rows="7"
                                  class="border rounded-md w-full px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">{{ $documentary->body }}</textarea>
                    </div>
                </div>
                <div class="bg-white mt-10 rounded shadow flex flex-col p-4">
                    <h3 class="font-bold mb-5">اطلاعات دیگر</h3>
                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label for="keywords"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">کلیدواژه ها
                            </label>
                            <input type="text" id="keywords" name="keywords"
                                   value="@if($documentary->keywords != null){{ implode(', ', array_map('trim', json_decode($documentary->keywords, true))) }}@endif"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="کلیدواژه ها را وارد کنید" required>
                            <p class="text-red-600 text-sm mt-2 mr-4">لطفا از کاراکتر "," برای جداسازی کلیدواژه ها
                                استفاده کنید</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white mt-10 rounded shadow flex flex-col p-4">
                    <h3 class="font-bold mb-5">عکس شاخص</h3>
                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label for="main_image"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">جهت تغییر عکس
                                شاخص انتخاب کنید
                            </label>
                            <input type="file" id="main_image" name="main_image" accept=".jpg,.bmp,.jpeg,.svg,.png"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>
                        <div>
                            <img class="w-full h-96 cursor-pointer" title="برای بزرگنمایی کلیک کنید"
                                 @if($documentary->mainImage!=null) onclick="openModal('{{ env('APP_URL') . $documentary->mainImage->src }}')"
                                 @endif
                                 src="{{$documentary->mainImage!=null ? env('APP_URL').$documentary->mainImage->src : 'not found!'}}"
                                 alt="تصویر یافت نشد!">
                        </div>
                    </div>
                </div>
                <div class="bg-white mt-10 rounded shadow flex flex-col p-4">
                    <h3 class="font-bold mb-5">اطلاعات فیلم</h3>
                    <div class="grid gap-6 mb-6">
                        <div>
                            <label for="video_link"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">کد embed آپارات
                            </label>
                            <input type="text" id="video_link" name="video_link" required
                                   value="{{ $documentary->video_link }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>
                    </div>
                </div>

                {{--                Related items update--}}
                <x-related-items-update :postTypes="$postTypes" :relatedItems="$documentary"/>

                {{--                Documentaries introdcutions update--}}
                <x-similar-documentaries-update :documentaries="$documentaries"/>

                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    @can('ویرایش مستند')
                        <input type="hidden" name="id" value="{{ $documentary->id }}">
                        <button type="submit"
                                class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                            ویرایش
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
