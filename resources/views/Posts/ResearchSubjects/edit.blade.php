@extends('layouts.PanelMaster')
@section('content')
    <main class="flex-1 bg-gray-100 py-6 px-8">
        <div class="mx-auto lg:mr-72">
            <div class="flex mb-4">
                <h1 class="text-2xl font-bold mb-4">جزئیات و ویرایش سوژه پژوهشی</h1>
                @if ($researchSubject->status==2)
                    <x-show-draft-button route="ResearchSubjects"
                                         token="{{ $researchSubject->draft_token }}"></x-show-draft-button>
                @endif
            </div>
            @include('layouts.components.errors')
            @include('layouts.components.success')
            <div class="bg-gray-300 rounded shadow flex flex-col ">
                {{ html()->form('PATCH')->route('ResearchSubjects.update',$researchSubject->id)->acceptsFiles()->id('edit-post')->open() }}
                <div class="bg-white rounded shadow flex flex-col p-4">
                    <div class="grid gap-6 mb-6 md:grid-cols-3">
                        <div>
                            <label for="title"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">عنوان
                            </label>
                            <input type="text" id="title" name="title" value="{{ $researchSubject->title }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="عنوان را وارد کنید" required>
                        </div>
                        <div>
                            <label for="status"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">وضعیت</label>
                            <select name="status"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                <option value="1" {{$researchSubject->status==1 ? 'selected' : ''}}>منتشر شده</option>
                                <option value="2" {{$researchSubject->status==2 ? 'selected' : ''}}>پیش نویس</option>
                            </select>
                        </div>
                        <div>
                            <label for="chosen"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">برگزیده</label>
                            <select name="chosen"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                <option value="0" {{$researchSubject->chosen==0 ? 'selected' : ''}}>خیر</option>
                                <option value="1" {{$researchSubject->chosen==1 ? 'selected' : ''}}>بله</option>
                            </select>
                        </div>
                        <div>
                            <label for="section"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">مقطع</label>
                            <select name="section"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                @foreach($sections as $section)
                                    <option
                                        {{$researchSubject->section==$section->id ? 'selected' : ''}}
                                        value="{{ $section->id }}">
                                        {{$section->name}}
                                    </option>
                                @endforeach
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
                                  class="border rounded-md w-full px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">{{ $researchSubject->body }}</textarea>
                    </div>
                </div>
                <div class="bg-white mt-10 rounded shadow flex flex-col p-4">
                    <h3 class="font-bold mb-5">اطلاعات دیگر</h3>
                    <div class="grid gap-6 mb-6 ">
                        <div>
                            <label for="resources"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">منابع
                            </label>
                            <textarea id="resources" name="resources" rows="7"
                                      class="border rounded-md w-full px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">{{ $researchSubject->resources }}</textarea>
                        </div>
                    </div>
                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label for="keywords"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">کلیدواژه ها
                            </label>
                            <input type="text" id="keywords" name="keywords"
                                   value="@if($researchSubject->keywords != null){{ implode(', ', array_map('trim', json_decode($researchSubject->keywords, true))) }}@endif"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="کلیدواژه ها را وارد کنید" required>
                            <p class="text-red-600 text-sm mt-2 mr-4">لطفا از کاراکتر "," برای جداسازی کلیدواژه ها
                                استفاده کنید</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white mt-10 rounded shadow flex flex-col p-4">
                    <h3 class="font-bold mb-5">سوژه های مرتبط</h3>
                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label for="main_image"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">انتخاب کنید
                            </label>

                            <select name="status" multiple
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            >
                                @foreach($allSubjects as $allSubject)
                                    <option value="{{$allSubject->id}}">
                                        {{$allSubject->title}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
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
                                 @if($researchSubject->mainImage!=null) onclick="openModal('{{ env('APP_URL') . $researchSubject->mainImage->src }}')"
                                 @endif
                                 src="{{$researchSubject->mainImage!=null ? env('APP_URL').$researchSubject->mainImage->src : 'not found!'}}"
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
                    @if($researchSubject->childImages!=null)
                        <div class="grid grid-cols-4 gap-3">
                            @foreach($researchSubject->childImages as $images)
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
                {{--                Attached documents update--}}
                <x-attached-documents-update :documents="json_decode($researchSubject->attached_documents,true)"/>

                {{--                Related items update--}}
                <x-related-items-update :postTypes="$postTypes" :relatedItems="$researchSubject->related_items"/>

                {{--                Similar research subjects update--}}
                <x-similar-research-subjects-update :researchSubjects="$researchSubject"/>

                {{--                Slider manager--}}
                <x-slider.update :image="$researchSubject->sliderImage"/>

                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    @can('ویرایش سوژه های پژوهشی')
                        <input type="hidden" name="id" value="{{ $researchSubject->id }}">
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
