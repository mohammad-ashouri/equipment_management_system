@php use Morilog\Jalali\Jalalian; @endphp
@extends('layouts.PanelMaster')

@section('content')
    <main class="flex-1 bg-gray-100 py-6 px-8">
        <div class="mx-auto lg:mr-72">
            <h1 class="text-2xl font-bold mb-4">ارتباط با ما</h1>
            @include('layouts.components.errors')
            @include('layouts.components.success')
            <div class="bg-white rounded shadow p-6 flex flex-col ">
                @if(empty($contactUs) or $contactUs->isEmpty())
                    <div role="alert" class="alert alert-info">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            class="h-6 w-6 shrink-0 stroke-current">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>اطلاعاتی یافت نشد!</span>
                    </div>
                @else
                    <table class="w-full border-collapse rounded-lg overflow-hidden text-center datasheet">
                        <thead>
                        <tr class="bg-gradient-to-r from-blue-400 to-purple-500 items-center text-center text-white">
                            <th class="px-6 py-3  font-bold ">#</th>
                            <th class="px-6 py-3  font-bold ">نام و نام خانوادگی</th>
                            <th class="px-6 py-3  font-bold ">ایمیل</th>
                            <th class="px-6 py-3  font-bold ">متن</th>
                            <th class="px-6 py-3  font-bold ">وضعیت</th>
                            <th class="px-6 py-3  font-bold ">کاربر</th>
                            <th class="px-6 py-3  font-bold ">زمان ویرایش</th>
                            <th class="px-6 py-3  font-bold ">عملیات</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-300">
                        @foreach ($contactUs as $contacts)
                            <tr class="bg-white">
                                <td class="px-6 py-4">
                                    {{ $contacts->id }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $contacts->name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $contacts->email }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $contacts->message }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($contacts->is_read)
                                        خوانده شده
                                    @elseif(!$contacts->is_read)
                                        خوانده نشده
                                    @elseif($contacts->is_spam)
                                        اسپم
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if(!empty($contacts->editorInfo->name))
                                        {{ $contacts->editorInfo->name }} {{ $contacts->editorInfo->family }}
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if(!empty($contacts->editorInfo->name))
                                        {{ Jalalian::fromDateTime($contacts->updated_at)->format('H:i:s Y/m/d') }}
                                    @endif
                                </td>
                                <td class="flex align-center px-6 py-4 gap-2">
                                    @can('ارتباط با ما - تغییر وضعیت')
                                        @if(!$contacts->is_read)
                                            <form class="is_read" action="{{ route('ContactUs.update',$contacts->id) }}" method="post">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="edit_command" value="read">
                                                <button type="submit" data-id="{{ $contacts->id }}"
                                                        title="انتخاب به عنوان خوانده شده"
                                                        class="px-1 py-1 bg-green-500 hover:bg-green-600 focus:border-green-300 text-white rounded-md focus:outline-none focus:ring ">
                                                    <i style="font-size: 20px" class="las la-eye"></i>
                                                </button>
                                            </form>
                                        @endif
                                        @if(!$contacts->is_spam)
                                            <form class="is_spam" action="{{ route('ContactUs.update',$contacts->id) }}" method="post">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="edit_command" value="spam">
                                                <button type="submit" data-id="{{ $contacts->id }}"
                                                        title="انتخاب به عنوان اسپم"
                                                        class="px-1 py-1 bg-red-500 hover:bg-red-600 focus:border-red-300 text-white rounded-md focus:outline-none focus:ring ">
                                                    <i style="font-size: 20px" class="las la-ban"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <button type="button" data-id="{{ $contacts->id }}"
                                                title="اطلاعات اضافی"
                                                class="getHeaders px-1 py-1 bg-blue-500 hover:bg-blue-600 focus:border-blue-300 text-white rounded-md focus:outline-none focus:ring ">
                                            <i style="font-size: 20px" class="las la-info"></i>
                                        </button>
                                    @endcan
                                    @can('ارتباط با ما - حذف')
                                        {{ html()->form('DELETE')->route('ContactUs.destroy',$contacts->id)->class('delete-post')->open() }}
                                        <button type="submit"
                                                class="px-1 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring focus:border-red-300">
                                            <i style="font-size: 20px" class="las la-trash"></i>
                                        </button>
                                        {{ html()->form()->close() }}
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4 flex justify-center" id="laravel-next-prev">
                        {{ $contactUs->links() }}
                    </div>
                @endif
            </div>

        </div>
    </main>
@endsection
