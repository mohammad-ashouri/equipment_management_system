@php use Morilog\Jalali\Jalalian; @endphp
@extends('layouts.PanelMaster')

@section('content')
    <main class="flex-1 bg-gray-100 py-6 px-8">
        <div class="mx-auto lg:mr-72">
            <h1 class="text-2xl font-bold mb-4">اسلایدرها</h1>
            @include('layouts.components.errors')
            @include('layouts.components.success')
            <div class="bg-white rounded shadow p-6 flex flex-col ">
                @if(empty($sliders) or $sliders->isEmpty())
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
                            <th class="px-6 py-3  font-bold ">ردیف</th>
                            <th class="px-6 py-3  font-bold ">جدول</th>
                            <th class="px-6 py-3  font-bold ">آیدی پست</th>
                            <th class="px-6 py-3  font-bold ">وضعیت</th>
                            <th class="px-6 py-3  font-bold ">زمان انتشار</th>
                            <th class="px-6 py-3  font-bold ">کاربر منتشر کننده</th>
                            <th class="px-6 py-3  font-bold ">زمان ویرایش</th>
                            <th class="px-6 py-3  font-bold ">کاربر ویرایش کننده</th>
                            <th class="px-6 py-3  font-bold ">عملیات</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-300">
                        @foreach ($sliders as $slider)
                            <tr class="bg-white">
                                <td class="px-6 py-4">
                                    {{ $slider->id }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $slider->model }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $slider->model_id }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $slider->status==1 ? 'فعال' : 'غیر فعال' }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ Jalalian::fromDateTime($slider->created_at)->format('H:i:s Y/m/d') }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $slider->adderInfo->name }} {{ $slider->adderInfo->family }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ Jalalian::fromDateTime($slider->updated_at)->format('H:i:s Y/m/d') }}
                                </td>
                                <td class="px-6 py-4">
                                    @if(!empty($slider->editorInfo->name))
                                        {{ $slider->editorInfo->name }} {{ $slider->editorInfo->family }}
                                    @endif
                                </td>
                                <td class="flex align-center px-6 py-4">
                                    @can('ویرایش اسلایدر')
                                        <a href="{{ route('Sliders.edit',$slider->id) }}">
                                            <button type="button" data-id="{{ $slider->id }}" title="@if($slider->status) غیرفعالسازی @else فعالسازی @endif"
                                                    class="px-1 py-1 ml-3 @if($slider->status) bg-red-500 hover:bg-red-600 focus:border-red-300 @else bg-green-500 hover:bg-green-600 focus:border-green-300 @endif  text-white rounded-md focus:outline-none focus:ring ">
                                                <i style="font-size: 20px" class="las la-power-off"></i>
                                            </button>
                                        </a>
                                    @endcan
                                    @can('حذف اسلایدر')
                                        {{ html()->form('DELETE')->route('Sliders.destroy',$slider->id)->class('delete-post')->open() }}
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
                        {{ $sliders->links() }}
                    </div>
                @endif
            </div>

        </div>
    </main>
@endsection
