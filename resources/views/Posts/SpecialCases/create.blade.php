@php use App\Models\SpecialCase; @endphp
@extends('layouts.PanelMaster')
@php
    if (isset($id)){
        $model=SpecialCase::find($id);
    }
@endphp
@section('content')
    <main class="flex-1 bg-gray-100 py-6 px-8">
        <div class="mx-auto lg:mr-72">
            <div class="flex mb-4">
            <h1 class="text-2xl font-bold mb-4">ایجاد پرونده ویژه</h1>
                @if (isset($id) and $model->status==2)
                    <x-show-draft-button route="SpecialCases" token="{{ $model->draft_token }}"></x-show-draft-button>
                @endif
            </div>
            @include('layouts.components.errors')
            @include('layouts.components.success')
            <div class="bg-gray-300 rounded shadow flex flex-col ">
                {{ html()->form('POST')->route('SpecialCases.store')->acceptsFiles()->id('create-post')->open() }}
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
                </div>
                <div class="bg-white mt-10 rounded shadow flex flex-col p-4">
                    <h3 class="font-bold mb-5">یادداشت</h3>
                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label for="note_title"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">عنوان
                            </label>
                            <input type="text" id="note_title" name="note_title" value="{{ old('note_title') }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="عنوان را وارد کنید"
                                   required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="note_body" class="block text-gray-700 text-sm font-bold mb-2">متن*:</label>
                        <textarea id="note_body" name="note_body" rows="7"
                                  class="border rounded-md w-full px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">{{ old('body') }}</textarea>
                    </div>
                    <div>
                        <h3 class="font-bold mb-2">عکس شاخص</h3>
                        <div class="grid gap-6 mb-6 md:grid-cols-2">
                            <div>
                                <label for="note_image"
                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">انتخاب کنید
                                </label>
                                <input type="file" id="note_image" name="note_image" accept=".jpg,.bmp,.jpeg,.svg,.png" required
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white mt-10 rounded shadow flex flex-col p-4">
                    <h3 class="font-bold mb-5">مصاحبه</h3>
                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label for="interview_title"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">عنوان
                            </label>
                            <input type="text" id="interview_title" name="interview_title"
                                   value="{{ old('interview_title') }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="عنوان را وارد کنید"
                                   required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="interview_body" class="block text-gray-700 text-sm font-bold mb-2">متن *:</label>
                        <textarea id="interview_body" name="interview_body" rows="7"
                                  class="border rounded-md w-full px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">{{ old('interview_body') }}</textarea>
                    </div>
                    <div>
                        <h3 class="font-bold mb-2">عکس شاخص</h3>
                        <div class="grid gap-6 mb-6 md:grid-cols-2">
                            <div>
                                <label for="interview_image"
                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">انتخاب کنید
                                </label>
                                <input type="file" id="interview_image" name="interview_image"
                                       accept=".jpg,.bmp,.jpeg,.svg,.png" required
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            </div>
                        </div>
                    </div>
                </div>

                {{--                                                Special case movies create--}}
                <x-special-case.special-case-movies-create :old="old('movies[]', [])"/>
                {{--                                                Special case audios create--}}
                <x-special-case.special-case-audios-create :old="old('audios[]', [])"/>
                {{--                                                Special case images create--}}
                <x-special-case.special-case-images-create :old="old('images[]', [])"/>

                {{--                Slider manager--}}
                <x-slider.create/>

                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    @can('ایجاد پرونده ویژه')
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
