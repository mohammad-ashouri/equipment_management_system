@extends('layouts.PanelMaster')
@section('content')
    <main class="flex-1 bg-gray-100 py-6 px-8">
        <div class="mx-auto lg:mr-72">
            <div class="flex mb-4">
                <h1 class="text-2xl font-bold mb-4">جزئیات و ویرایش استاد</h1>
                @if ($professor->status==2)
                    <x-show-draft-button route="Professors"
                                         token="{{ $professor->draft_token }}"></x-show-draft-button>
                @endif
            </div>
            @include('layouts.components.errors')
            @include('layouts.components.success')
            <div class="bg-gray-300 rounded shadow flex flex-col ">
                {{ html()->form('PATCH')->route('Professors.update',$professor->id)->acceptsFiles()->id('edit-post')->open() }}
                <div class="bg-white rounded shadow flex flex-col p-4">
                    <div class="grid gap-6 mb-6 md:grid-cols-3">
                        <div>
                            <label for="title"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">عنوان
                            </label>
                            <input type="text" id="title" name="title" value="{{ $professor->title }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="عنوان را وارد کنید" required>
                        </div>
                        <div>
                            <label for="status"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">وضعیت</label>
                            <select name="status"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                <option value="1" {{$professor->status==1 ? 'selected' : ''}}>منتشر شده</option>
                                <option value="2" {{$professor->status==2 ? 'selected' : ''}}>پیش نویس</option>
                            </select>
                        </div>
                        <div>
                            <label for="chosen"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">برگزیده</label>
                            <select name="chosen"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                <option value="0" {{$professor->chosen==0 ? 'selected' : ''}}>خیر</option>
                                <option value="1" {{$professor->chosen==1 ? 'selected' : ''}}>بله</option>
                            </select>
                        </div>
                        <div>
                            <label for="categories"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">دسته
                                بندی</label>
                            <select name="categories" multiple
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            >
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">
                                        {{$category->name}}
                                    </option>
                                    @foreach($category->childes as $categoryChild)
                                        <option value="{{$categoryChild->id}}">
                                            - {{$categoryChild->name}}
                                        </option>
                                        @foreach($categoryChild->childes as $categoryChild2)
                                            <option value="{{$categoryChild2->id}}">
                                                -- {{$categoryChild2->name}}
                                            </option>
                                        @endforeach
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div>
                        <label for="body" class="block text-gray-700 text-sm font-bold mb-2">متن*:</label>
                        <textarea id="body" name="body" rows="7"
                                  class="border rounded-md w-full px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">{{ $professor->body }}</textarea>
                    </div>
                </div>
                <div class="bg-white mt-10 rounded shadow flex flex-col p-4">
                    <h3 class="font-bold mb-5">اطلاعات دیگر</h3>
                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label for="adjective"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">صفت استاد
                            </label>
                            <select name="adjective"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            >
                                <option selected value="" disabled>انتخاب کنید</option>
                                @foreach($adjectives as $adjective)
                                    <option {{ $professor->adjective ? 'selected' : '' }} value="{{$adjective->id}}">
                                        {{$adjective->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="speciality"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                تخصص استاد*
                            </label>
                            <input type="text" id="speciality" name="speciality" value="{{ $professor->speciality }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="تخصص استاد را وارد کنید" required>
                        </div>
                        <div>
                            <label for="keywords"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">کلیدواژه ها
                            </label>
                            <input type="text" id="keywords" name="keywords"
                                   value="@if($professor->keywords != null){{ implode(', ', array_map('trim', json_decode($professor->keywords, true))) }}@endif"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="کلیدواژه ها را وارد کنید" required>
                            <p class="text-red-600 text-sm mt-2 mr-4">لطفا از کاراکتر "," برای جداسازی کلیدواژه ها
                                استفاده کنید</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white mt-10 rounded shadow flex flex-col p-4">
                    <h3 class="font-bold mb-5">کتاب ها</h3>
                    <div class="grid gap-2 mb-6 grid-cols-2" id="booksContainer">
                        <div>
                            @if($professor->books)
                                @foreach(json_decode($professor->books,true) as $index => $book)
                                    @if($book==null)
                                        @continue
                                    @endif
                                    <div class="flex w-full book-row">
                                        <div class="w-full">
                                            <label for=""
                                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">نام
                                                کتاب
                                            </label>
                                            <input type="text" id="book{{ $index }}" name="books[]"
                                                   value="{{ $book }}"
                                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                   placeholder="کتاب {{ $index + 1 }} را وارد کنید"
                                            >
                                        </div>
                                        <div class="mt-7 mr-2">
                                            <button id="remove" type="button"
                                                    class="mt-3 w-96 inline-flex justify-center px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring focus:border-red-300 sm:mt-0 sm:w-auto remove-book-row">
                                                حذف
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="flex w-full book-row">
                                    <div class="w-full">
                                        <label for=""
                                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">نام
                                            کتاب
                                        </label>
                                        <input type="text" id="book0" name="books[]" value=""
                                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                               placeholder="کتاب را وارد کنید"
                                        >
                                    </div>
                                    <div class="mt-7 mr-2">
                                        <button id="remove" type="button"
                                                class="mt-3 w-96 inline-flex justify-center px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring focus:border-red-300 sm:mt-0 sm:w-auto remove-book-row">
                                            حذف
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="text-center">
                        <button id="new_book" type="button"
                                class="mt-3 w-96 inline-flex justify-center px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-green-300 sm:mt-0 sm:w-auto">
                            کتاب جدید
                        </button>
                    </div>
                </div>
                <div class="bg-white mt-10 rounded shadow flex flex-col p-4">
                    <h3 class="font-bold mb-5">مقالات</h3>
                    <div class="grid gap-2 mb-6 grid-cols-2" id="articlesContainer">
                        <div>
                            @if($professor->articles)
                                @foreach(json_decode($professor->articles,true) as $index => $article)
                                    @if($article==null)
                                        @continue
                                    @endif
                                    <div class="flex w-full article-row">
                                        <div class="w-full">
                                            <label for=""
                                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">نام
                                                مقاله
                                            </label>
                                            <input type="text" id="article{{ $index }}" name="articles[]"
                                                   value="{{ $article }}"
                                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                   placeholder="مقاله {{ $index + 1 }} را وارد کنید"
                                            >
                                        </div>
                                        <div class="mt-7 mr-2">
                                            <button id="remove" type="button"
                                                    class="mt-3 w-96 inline-flex justify-center px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring focus:border-red-300 sm:mt-0 sm:w-auto remove-article-row">
                                                حذف
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="flex w-full book-row">
                                    <div class="w-full">
                                        <label for=""
                                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">نام
                                            مقاله
                                        </label>
                                        <input type="text" id="article0" name="articles[]" value=""
                                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                               placeholder="مقاله را وارد کنید"
                                        >
                                    </div>
                                    <div class="mt-7 mr-2">
                                        <button id="remove" type="button"
                                                class="mt-3 w-96 inline-flex justify-center px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring focus:border-red-300 sm:mt-0 sm:w-auto remove-article-row">
                                            حذف
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="text-center">
                        <button id="new_article" type="button"
                                class="mt-3 w-96 inline-flex justify-center px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-green-300 sm:mt-0 sm:w-auto">
                            مقاله جدید
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
                        <div>
                            <img class="w-full h-96 cursor-pointer" title="برای بزرگنمایی کلیک کنید"
                                 @if($professor->mainImage!=null) onclick="openModal('{{ env('APP_URL') . $professor->mainImage->src }}')"
                                 @endif
                                 src="{{$professor->mainImage!=null ? env('APP_URL').$professor->mainImage->src : 'not found!'}}"
                                 alt="تصویر یافت نشد!">
                        </div>
                    </div>
                </div>
                <div class="bg-white mt-10 rounded shadow flex flex-col p-4">
                    <h3 class="font-bold mb-5">عکس های دیگر</h3>
                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label for="child_images"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">انتخاب کنید
                            </label>
                            <input type="file" id="child_images[]" name="child_images[]" multiple
                                   accept=".jpg,.bmp,.jpeg,.svg,.png"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>
                    </div>
                    @if($professor->childImages!=null)
                        <div class="grid grid-cols-4 gap-3">
                            @foreach($professor->childImages as $images)
                                <div class="relative inline-block image-container">
                                    <img class="w-96 h-96 rounded border border-black other-image cursor-pointer"
                                         title="برای بزرگنمایی کلیک کنید"
                                         data-id="{{$images->id}}"
                                         onclick="openModal('{{ env('APP_URL') . $images->src }}')"
                                         src="{{env('APP_URL').$images->src}}" alt="تصویر یافت نشد!">
                                    <button
                                        class="absolute top-0 right-0 mt-2 mr-2 bg-red-500 text-white px-2 py-1 rounded delete-btn hidden">
                                        حذف
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{--                Slider manager--}}
                <x-slider.update :image="$professor->sliderImage"/>

                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    @can('ویرایش اساتید')
                        <input type="hidden" name="id" value="{{ $professor->id }}">
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
