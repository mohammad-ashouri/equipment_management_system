@php use Morilog\Jalali\Jalalian; @endphp
@extends('layouts.PanelMaster')

@section('content')
    <main class="flex-1 bg-gray-100 py-6 px-8">
        <div class="mx-auto lg:mr-72">
            <h1 class="text-2xl font-bold mb-4">اساتید</h1>
            @include('layouts.components.errors')
            @include('layouts.components.success')
            <x-search-box :postType="'professor'" :route="'Professors'"></x-search-box>
            <div class="bg-white rounded shadow p-6 flex flex-col ">
                @can('ایجاد اساتید')
                    <a type="button" href="{{route('Professors.create')}}"
                       class="px-4 py-2 bg-green-500 w-40 mb-2 text-center text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                        جدید
                    </a>
                @endcan
                @if(empty($professors) or $professors->isEmpty())
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
                            <th class="px-6 py-3  font-bold ">آیدی پست</th>
                            <th class="px-6 py-3  font-bold ">عنوان</th>
                            <th class="px-6 py-3  font-bold ">زمان انتشار</th>
                            <th class="px-6 py-3  font-bold ">کاربر منتشر کننده</th>
                            <th class="px-6 py-3  font-bold ">زمان ویرایش</th>
                            <th class="px-6 py-3  font-bold ">کاربر ویرایش کننده</th>
                            <th class="px-6 py-3  font-bold ">وضعیت</th>
                            <th class="px-6 py-3  font-bold ">عملیات</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-300">
                        @foreach ($professors as $professor)
                            <tr class="bg-white">
                                <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4">
                                    {{ $professor->id }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $professor->title }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ Jalalian::fromDateTime($professor->created_at)->format('H:i:s Y/m/d') }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $professor->adderInfo->name }} {{ $professor->adderInfo->family }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ Jalalian::fromDateTime($professor->updated_at)->format('H:i:s Y/m/d') }}
                                </td>
                                <td class="px-6 py-4">
                                    @if(!empty($professor->editorInfo->name))
                                        {{ $professor->editorInfo->name }} {{ $professor->editorInfo->family }}
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @switch($professor->status)
                                        @case(1)
                                            منتشر شده
                                            @break
                                        @case(2)
                                            پیش نویس
                                            @break
                                    @endswitch
                                </td>
                                <td class="flex align-center px-6 py-4">
                                    @can('ویرایش اساتید')
                                        <a href="{{ route('Professors.edit',$professor->id) }}">
                                            <button type="button" data-id="{{ $professor->id }}"
                                                    class="px-1 py-1 ml-3 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300">
                                                <i style="font-size: 20px" class="las la-edit"></i>
                                            </button>
                                        </a>
                                    @endcan
                                    @can('حذف اساتید')
                                        {{ html()->form('DELETE')->route('Professors.destroy',$professor->id)->class('delete-post')->open() }}
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
                        {{ $professors->links() }}
                    </div>
                @endif
            </div>

        </div>
    </main>
@endsection
