@extends('layouts.PanelMaster')
@section('content')
    <main class="flex-1 bg-gray-100 py-6 px-8">
        <div class="mx-auto lg:mr-72">
            <h1 class="text-2xl font-bold mb-4">جزئیات و ویرایش شبکه اجتماعی</h1>
            @include('layouts.components.errors')
            <div class="bg-white rounded shadow flex flex-col ">
                {{ html()->form('PATCH')->route('SocialMediaPlatforms.update',$socialMediaPlatform->id)->acceptsFiles()->id('edit-catalog')->open() }}
                <div class="bg-white rounded shadow flex flex-col p-4">
                    <div class="grid gap-6 mb-6 md:grid-cols-3">
                        <div>
                            <label for="name"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">عنوان</label>
                            <input type="text" id="name" name="name" value="{{ $socialMediaPlatform->name }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="" required>
                        </div>
                        <div>
                            <label for="status"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">وضعیت</label>
                            <select name="status"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                <option value="1" {{$socialMediaPlatform->status ? 'selected' : ''}}>فعال</option>
                                <option value="0" {{!$socialMediaPlatform->status ? 'selected' : ''}}>غیر فعال</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="bg-white mt-10 rounded shadow flex flex-col p-4">
                    <h3 class="font-bold mb-5">در صورت نیاز به تغییر لوگو انتخاب کنید</h3>
                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label for="main_image"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">انتخاب کنید
                            </label>
                            <input type="file" id="main_image" name="main_image" accept=".jpg,.bmp,.jpeg,.svg,.png"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>
                        <div>
                            <img class="w-full h-96 cursor-pointer" title="برای بزرگنمایی کلیک کنید" @if($socialMediaPlatform->icon_src!=null) onclick="openModal('{{ env('APP_URL') . str_replace('public','/storage',$socialMediaPlatform->icon_src) }}')" @endif
                            src="{{$socialMediaPlatform->icon_src!=null ? env('APP_URL').str_replace('public','/storage',$socialMediaPlatform->icon_src) : 'not found!'}}"
                                 alt="تصویر یافت نشد!">
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    @can('ویرایش شبکه اجتماعی')
                        <input type="hidden" name="id" value="{{ $socialMediaPlatform->id }}">
                        <button type="submit"
                                class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                            ویرایش شبکه اجتماعی
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
