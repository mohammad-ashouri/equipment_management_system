@props(['route','postType'])
@php
    $inputs = ['id', 'title', 'slug', 'adder', 'editor'];
 foreach ($inputs as $input) {
     $input = $_GET[$input] ?? null;
 }
@endphp
<div class="bg-white rounded shadow p-6 flex flex-col">
    <form method="get" action="{{ route($route.'.index') }}">
        <input type="hidden" name="postType" value="{{ $postType }}">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-7 gap-4">
            <div>
                <label for="id"
                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">آیدی پست
                </label>
                <input type="number" id="id" name="id" min="0"
                       value="{{ @$_GET['id'] }}"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                       placeholder="آیدی پست"
                       >
            </div>
            <div>
                <label for="title"
                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">عنوان
                </label>
                <input type="text" id="title" name="title"
                       value="{{ @$_GET['title'] }}"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                       placeholder="قسمتی از عنوان"
                       >
            </div>
            <div>
                <label for="slug"
                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">slug
                </label>
                <input type="text" id="slug" name="slug"
                       value="{{ @$_GET['slug'] }}"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                       placeholder="قسمتی از slug"
                       >
            </div>
            <div>
                <label for="status"
                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">وضعیت
                </label>
                <select id="status" name="status"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        >
                    <option @if(isset($_GET['status']) and $_GET['status']==0) selected @endif value="0">همه</option>
                    <option @if(isset($_GET['status']) and $_GET['status']==1) selected @endif value="1">منتشر شده</option>
                    <option @if(isset($_GET['status']) and $_GET['status']==2) selected @endif value="2">پیش نویس</option>
                </select>
            </div>
            <div>
                <label for="adder"
                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">کاربر منتشر کننده
                </label>
                <select id="adder" name="adder"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        >
                    <option value="" selected>همه</option>
                    @foreach($users as $user)
                        <option
                            @if(isset($_GET['adder']) and $_GET['adder']==$user->id) selected @endif
                            value="{{ $user->id }}">
                            {{ $user->name }} {{ $user->family }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="editor"
                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">کاربر ویرایش کننده
                </label>
                <select id="editor" name="editor"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        >
                    <option value="" selected>همه</option>
                    @foreach($users as $user)
                        <option
                            @if(isset($_GET['editor']) and $_GET['editor']==$user->id) selected @endif
                            value="{{ $user->id }}">
                            {{ $user->name }} {{ $user->family }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mt-4 sm:mt-7 flex justify-center">
                <button type="submit"
                        class="w-full sm:w-auto inline-flex justify-center px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-green-300">
                    جستجو
                </button>
            </div>
        </div>
    </form>
</div>
