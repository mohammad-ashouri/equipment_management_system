@php use Morilog\Jalali\Jalalian; @endphp
@extends('layouts.PanelMaster')

@section('content')
    <main class="flex-1 bg-gray-100 py-6 px-8">
        <div class="mx-auto lg:mr-72">
            <h1 class="text-2xl font-bold mb-4">تجهیزات پشتیبانی - مدیریت بر اطلاعات میز</h1>
            @include('layouts.components.errors')
            @include('layouts.components.success')
            <div class="bg-white rounded shadow p-6 flex flex-col ">
                @can('ایجاد میز')
                    <a type="button" href="{{route('Tables.create')}}"
                       class="px-4 py-2 bg-green-500 w-40 mb-2 text-center text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                        میز جدید
                    </a>
                @endcan
                @if(empty($tables) or $tables->isEmpty())
                    <div role="alert" class="alert alert-info">
                        <i style="font-size: 20px" class="las la-info-circle"></i>
                        <span>اطلاعاتی یافت نشد!</span>
                    </div>
                @else
                    <table class="datatable w-full border-collapse rounded-lg overflow-hidden text-center datasheet">
                        <thead>
                        <tr class="bg-gradient-to-r from-blue-400 to-purple-500 items-center text-center text-white">
                            <th class="px-6 py-3  font-bold ">ردیف</th>
                            <th class="px-6 py-3  font-bold ">برند</th>
                            <th class="px-6 py-3  font-bold ">مدل</th>
                            <th class="px-6 py-3  font-bold ">جنس</th>
                            <th class="px-6 py-3  font-bold ">طول</th>
                            <th class="px-6 py-3  font-bold ">عرض</th>
                            <th class="px-6 py-3  font-bold ">ارتفاع</th>
                            <th class="px-6 py-3  font-bold ">وضعیت</th>
                            <th class="px-6 py-3  font-bold ">کاربر ثبت کننده</th>
                            <th class="px-6 py-3  font-bold ">تاریخ ثبت</th>
                            <th class="px-6 py-3  font-bold ">کاربر ویرایش کننده</th>
                            <th class="px-6 py-3  font-bold ">تاریخ ویرایش</th>
                            <th class="px-6 py-3  font-bold action">عملیات</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-300">
                        @foreach ($tables as $table)
                            <tr class="bg-white">
                                <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4">
                                    {{ $table->brandInfo->name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $table->model }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $table->material }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $table->length }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $table->width }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $table->height }}
                                </td>
                                <td class="px-6 py-4">
                                    @switch($table->status)
                                        @case(1)
                                            فعال
                                            @break
                                        @case(0)
                                            غیر فعال
                                            @break
                                    @endswitch
                                </td>
                                <td class="px-6 py-4">
                                    {{ $table->adderInfo->name }} {{ $table->adderInfo->family }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ Jalalian::fromDateTime($table->created_at)->format('H:i:s Y/m/d') }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($table->editorInfo!=null)
                                        {{ $table->editorInfo->name }} {{ $table->editorInfo->family }}
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    {{ Jalalian::fromDateTime($table->updated_at)->format('H:i:s Y/m/d') }}
                                </td>
                                <td class="px-6 py-4">
                                    @can('ویرایش میز')
                                        <a href="{{ route('Tables.edit',$table->id) }}">
                                            <button type="button" data-id="{{ $table->id }}"
                                                    class="px-4 py-2 mr-3 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300 ReferTypeControl">
                                                ویرایش
                                            </button>
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

        </div>
    </main>
@endsection
