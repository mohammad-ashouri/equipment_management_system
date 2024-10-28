@extends('layouts.PanelMaster')
@section('content')
    <main class="flex-1 bg-gray-100 py-6 px-8">
        <div class="mx-auto lg:mr-72">
            <div class="flex mb-4">
                <h1 class="text-2xl font-bold mb-4">جزئیات و ویرایش سند</h1>
                @if ($post->status==2)
                    <x-show-draft-button route="documents"
                                         token="{{ $post->draft_token }}"></x-show-draft-button>
                @endif
            </div>
            @include('layouts.components.errors')
            @include('layouts.components.success')
            <div class="bg-gray-300 rounded shadow flex flex-col ">
                {{ html()->form('PATCH')->route('Posts.update',$post->id)->acceptsFiles()->id('edit-post')->open() }}
                <div class="bg-white rounded shadow flex flex-col p-4">
                    <div class="grid gap-6 mb-6 md:grid-cols-3">
                        <div>
                            <label for="title"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">عنوان
                            </label>
                            <input type="text" id="title" name="title" value="{{ $post->title }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="عنوان را وارد کنید" required>
                        </div>
                        <div>
                            <label for="status"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">وضعیت</label>
                            <select name="status"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                <option value="1" {{$post->status==1 ? 'selected' : ''}}>منتشر شده
                                </option>
                                <option value="2" {{$post->status==2 ? 'selected' : ''}}>پیش نویس
                                </option>
                            </select>
                        </div>
                        <div>
                            <label for="categories"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">دسته
                                بندی</label>
                            <select name="categories" multiple
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full h-96 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            >
                                @foreach($categories as $category)
                                    <option @if(in_array($category->id,$postCategoriesArray)) selected
                                            @endif value="{{$category->id}}">
                                        {{$category->name}}
                                    </option>
                                    @foreach($category->childes as $categoryChild)
                                        <option @if(in_array($categoryChild->id,$postCategoriesArray)) selected
                                                @endif value="{{$categoryChild->id}}">
                                            - {{$categoryChild->name}}
                                        </option>
                                        @foreach($categoryChild->childes as $categoryChild2)
                                            <option @if(in_array($categoryChild2->id,$postCategoriesArray)) selected
                                                    @endif value="{{$categoryChild2->id}}">
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
                                  class="border rounded-md w-full px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">{{ $post->body }}</textarea>
                    </div>
                </div>
                <div class="bg-white mt-10 rounded shadow flex flex-col p-4">
                    <label for="keywords"
                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">کلیدواژه ها
                    </label>
                    <input type="text" id="keywords" name="keywords"
                           value="@foreach($keywords as $keyword){{ $keyword }}{{ !$loop->last ? ',' : '' }} @endforeach"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                           placeholder="کلیدواژه ها را وارد کنید">
                    <p class="text-red-600 text-sm mt-2 mr-4">کلمه کلیدی را وارد کنید و enter را فشار دهید</p>
                </div>
                <script>
                    $(document).ready(function () {
                        $('#person_and_organization,#locations,#times,#events,#equipments,#contracts,#other').tagsInput({
                            selectFirst: true,
                            autoFill: true,
                            defaultText: 'کلمه را وارد کنید و enter را فشار دهید',
                            width: '700px',
                            interactive: true,
                            delimiter: ["-"],
                        });
                    });
                </script>
                <div class="bg-white mt-10 rounded shadow flex flex-col p-4">
                    <h3 class="font-bold mb-5">اعلام</h3>
                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label for="person_and_organization"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">اشخاص و ارگان ها
                            </label>
                            <input type="text" id="person_and_organization" name="person_and_organization"
                                   value="{{ $post->person_and_organization }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="اشخاص و ارگان ها را وارد کنید">
                            <p class="text-blue-600 text-sm mt-2 mr-4">کلمه را وارد کنید و enter را فشار دهید</p>
                        </div>
                        <div>
                            <label for="locations"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                مکان ها
                            </label>
                            <input type="text" id="locations" name="locations"
                                   value="{{$post->locations }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="مکان ها را وارد کنید">
                            <p class="text-blue-600 text-sm mt-2 mr-4">کلمه را وارد کنید و enter را فشار دهید</p>
                        </div>
                        <div>
                            <label for="times"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                زمان ها
                            </label>
                            <input type="text" id="times" name="times"
                                   value="{{$post->times }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="زمان ها را وارد کنید">
                            <p class="text-blue-600 text-sm mt-2 mr-4">کلمه را وارد کنید و enter را فشار دهید</p>
                        </div>
                        <div>
                            <label for="events"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                اتفاقات و حوادث و وقایع
                            </label>
                            <input type="text" id="events" name="events"
                                   value="{{$post->events }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="اتفاقات و حوادث و وقایع را وارد کنید">
                            <p class="text-blue-600 text-sm mt-2 mr-4">کلمه را وارد کنید و enter را فشار دهید</p>
                        </div>
                        <div>
                            <label for="equipments"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                تجهیزات
                            </label>
                            <input type="text" id="equipments" name="equipments"
                                   value="{{$post->equipments }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="تجهیزات را وارد کنید">
                            <p class="text-blue-600 text-sm mt-2 mr-4">کلمه را وارد کنید و enter را فشار دهید</p>
                        </div>
                        <div>
                            <label for="contracts"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                تعارف و قراردادها
                            </label>
                            <input type="text" id="contracts" name="contracts"
                                   value="{{$post->contracts }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="تعارف و قراردادها را وارد کنید">
                            <p class="text-blue-600 text-sm mt-2 mr-4">کلمه را وارد کنید و enter را فشار دهید</p>
                        </div>
                        <div>
                            <label for="other"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                متفرقه
                            </label>
                            <input type="text" id="other" name="other"
                                   value="{{$post->other }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="متفرقه را وارد کنید">
                            <p class="text-blue-600 text-sm mt-2 mr-4">کلمه را وارد کنید و enter را فشار دهید</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white mt-10 rounded shadow flex flex-col p-4">
                    <h3 class="font-bold mb-5">موضوعات</h3>
                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label for="main_subject"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">موضوع اصلی
                            </label>
                            <input type="text" id="main_subject" name="main_subject"
                                   value="{{$post->main_subject }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="موضوع اصلی را وارد کنید">
                        </div>
                        <div>
                            <label for="second_subject"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                موضوع دوم
                            </label>
                            <input type="text" id="second_subject" name="second_subject"
                                   value="{{$post->second_subject }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="موضوع دوم را وارد کنید">
                        </div>
                        <div>
                            <label for="third_subject"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                موضوع سوم
                            </label>
                            <input type="text" id="third_subject" name="third_subject"
                                   value="{{$post->third_subject }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="موضوع سوم را وارد کنید">
                        </div>
                        <div>
                            <label for="fourth_subject"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                موضوع چهارم
                            </label>
                            <input type="text" id="fourth_subject" name="fourth_subject"
                                   value="{{$post->fourth_subject }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="موضوع چهارم را وارد کنید">
                        </div>
                    </div>
                </div>
                <div class="bg-white mt-10 rounded shadow flex flex-col p-4">
                    <h3 class="font-bold mb-5">ویژگی ها</h3>
                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label for="source_book"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">منبع (کتاب)
                            </label>
                            <input type="text" id="source_book" name="source_book"
                                   value="{{$post->source_book }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="منبع (کتاب) را وارد کنید">
                        </div>
                        <div>
                            <label for="volume_number"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                شماره جلد
                            </label>
                            <input type="text" id="volume_number" name="volume_number"
                                   value="{{$post->volume_number }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="شماره جلد را وارد کنید">
                        </div>
                        <div>
                            <label for="book_number"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                شماره کتاب
                            </label>
                            <input type="text" id="book_number" name="book_number"
                                   value="{{$post->book_number }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="شماره کتاب را وارد کنید">
                        </div>
                        <div>
                            <label for="page_number"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                شماره صفحه
                            </label>
                            <input type="text" id="page_number" name="page_number"
                                   value="{{$post->page_number }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="شماره صفحه را وارد کنید">
                        </div>
                        <div>
                            <label for="document_number"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                شماره سند
                            </label>
                            <input type="text" id="document_number" name="document_number"
                                   value="{{$post->document_number }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="شماره سند را وارد کنید">
                        </div>
                        <div>
                            <label for="document_internal_number"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                شماره داخلی سند
                            </label>
                            <input type="text" id="document_internal_number" name="document_internal_number"
                                   value="{{$post->document_internal_number }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="شماره داخلی سند را وارد کنید">
                        </div>
                        <div>
                            <label for="document_type "
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                نوع سند
                            </label>

                            <select name="document_type" id="document_type"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            >
                                @foreach($documentTypes as $documentType)
                                    <option {{ $post->document_type ? 'selected' : '' }} value="{{$documentType->id}}">
                                        {{$documentType->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="document_producer"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                تهیه کننده سند
                            </label>
                            <input type="text" id="document_producer" name="document_producer"
                                   value="{{$post->document_producer }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="تهیه کننده سند را وارد کنید">
                        </div>
                        <div>
                            <label for="recipient_of_document"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                گیرنده سند
                            </label>
                            <input type="text" id="recipient_of_document" name="recipient_of_document"
                                   value="{{$post->recipient_of_document }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="گیرنده سند را وارد کنید">
                        </div>
                        <div>
                            <label for="AD_date"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                تاریخ میلادی
                            </label>
                            <input type="text" id="AD_date" name="AD_date"
                                   value="{{$post->AD_date }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="تاریخ میلادی را وارد کنید">
                        </div>
                        <div>
                            <label for="jalali_date"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                تاریخ شمسی
                            </label>
                            <input type="text" id="jalali_date" name="jalali_date"
                                   value="{{$post->jalali_date }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="تاریخ شمسی را وارد کنید">
                        </div>
                        <div>
                            <label for="description"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                توضیحات
                            </label>
                            <input type="text" id="description" name="description"
                                   value="{{$post->description }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="توضیحات را وارد کنید">
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
                                 @if($post->mainImage!=null) onclick="openModal('{{ env('APP_URL') . $post->mainImage->src }}')"
                                 @endif
                                 src="{{$post->mainImage!=null ? env('APP_URL').$post->mainImage->src : 'not found!'}}"
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
                    @if($post->childImages!=null)
                        <div class="grid grid-cols-4 gap-3">
                            @foreach($post->childImages as $images)
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
                {{--                Related items update--}}
                <x-related-items-update :postTypes="$postTypes" :relatedItems="$post"/>

                {{--                Slider manager--}}
                <x-slider.update :image="$post->sliderImage"/>

                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    @can('ویرایش اسناد')
                        <input type="hidden" name="id" value="{{ $post->id }}">
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
