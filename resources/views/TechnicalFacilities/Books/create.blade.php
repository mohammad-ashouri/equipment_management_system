@extends('layouts.PanelMaster')
@section('content')
    <main class="flex-1 bg-gray-100 py-6 px-8">
        <div class="mx-auto lg:mr-72">
            <h1 class="text-2xl font-bold mb-4">ایجاد کتاب</h1>
            @include('layouts.components.errors')
            <div class="bg-white rounded shadow flex flex-col ">
                {{ html()->form('POST')->route('Books.store')->acceptsFiles()->id('create-catalog')->open() }}
                <div class="bg-white rounded shadow flex flex-col p-4">
                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label for="name"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">نام </label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="" required>
                        </div>
                        <div>
                            <label for="publication"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">انتشارات </label>
                            <select name="publication"
                                    class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                <option value="" disabled selected>انتخاب کنید</option>
                                @foreach($publications as $publication)
                                    <option value="{{ $publication->id }}"
                                        @selected(old('publication')==$publication->id)>{{ $publication->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="book_subject"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">موضوع </label>
                            <select name="book_subject"
                                    class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                <option value="" disabled selected>انتخاب کنید</option>
                                @foreach($bookSubjects as $bookSubject)
                                    <option value="{{ $bookSubject->id }}"
                                        @selected(old('book_subject')==$bookSubject->id)>{{ $bookSubject->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="writer"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">نویسنده </label>
                            <input type="text" name="writer" value="{{ old('writer') }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="" required>
                        </div>
                        <div>
                            <label for="size"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">قطع </label>
                            <select name="size"
                                    class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                <option value="وزیری" @selected(old('size')=='وزیری')>وزیری</option>
                                <option value="رقعی" @selected(old('size')=='رقعی')>رقعی</option>
                                <option value="جیبی" @selected(old('size')=='جیبی')>جیبی</option>
                                <option value="خشتی" @selected(old('size')=='خشتی')>خشتی</option>
                                <option value="پالتویی" @selected(old('size')=='پالتویی')>پالتویی</option>
                                <option value="سلطانی" @selected(old('size')=='سلطانی')>سلطانی</option>
                                <option value="بیاضی" @selected(old('size')=='بیاضی')>بیاضی</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    @can('ایجاد کتاب')
                        <button type="submit"
                                class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                            ایجاد کتاب
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
