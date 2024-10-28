@extends('layouts.PanelMaster')
@section('content')
    <main class="flex-1 bg-gray-100 py-6 px-8">
        <div class="mx-auto lg:mr-72">
            <h1 class="text-2xl font-bold mb-4">جزئیات و ویرایش آلبوم تصویر</h1>
            @include('layouts.components.errors')
            <div class="bg-gray-300 rounded shadow flex flex-col ">
                {{ html()->form('PATCH')->route('PictureAlbum.update',$pictureAlbum->id)->acceptsFiles()->id('edit-post')->open() }}
                <div class="bg-white rounded shadow flex flex-col p-4">
                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label for="title"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">عنوان
                            </label>
                            <input type="text" id="title" name="title" value="{{ $pictureAlbum->title }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="عنوان را وارد کنید" required>
                        </div>
                        <div>
                            <label for="date"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">تاریخ
                            </label>
                            <input type="text" id="date" name="date" value="{{ $pictureAlbum->date }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="تاریخ را وارد کنید. به عنوان مثال: 1402/05/04" required>
                        </div>
                        <div>
                            <label for="status"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">وضعیت</label>
                            <select name="status"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                <option value="1" {{$pictureAlbum->status==1 ? 'selected' : ''}}>منتشر شده</option>
                                <option value="2" {{$pictureAlbum->status==2 ? 'selected' : ''}}>پیش نویس</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="bg-white mt-10 rounded shadow flex flex-col p-4">
                    <h3 class="font-bold mb-5">فایل تصویر</h3>
                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label for="image_file"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">انتخاب کنید
                            </label>
                            <input type="file" id="image_file" name="image_file" accept=.jpeg,.png,.jpg,.gif,.svg"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <p class="text-blue-500 text-sm mt-2 mr-4">حداکثر حجم فایل: 10 مگابایت</p>
                            <p class="text-blue-500 text-sm mt-2 mr-4">پسوندهای پشتیبانی شده: .jpeg, png, jpg, gif,
                                svg</p>
                        </div>
                        <div>
                            <label for="image_file"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">تصویر فعلی
                            </label>
                            <img src="{{ env('APP_URL').$pictureAlbum->pictureSrc->src }}" alt="تصویر پیدا نشد!">
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    @can('ویرایش آلبوم تصاویر')
                        <input type="hidden" name="id" value="{{ $pictureAlbum->id }}">
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
