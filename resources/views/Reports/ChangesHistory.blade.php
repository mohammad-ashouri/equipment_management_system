@php use Morilog\Jalali\Jalalian; @endphp
@php @endphp
@extends('layouts.PanelMaster')

@section('content')
    <main class="flex-1 bg-cu-light py-6 px-8">
        <div class="mx-auto lg:mr-72">
            <h1 class="text-2xl font-bold mb-4">تاریخچه تغییرات
            </h1>
            <div class="bg-white rounded shadow p-6 mb-4">
                <div>
                    <table class="w-full border-collapse rounded-lg overflow-hidden text-center datasheet">
                        <thead>
                        <tr class="bg-gradient-to-r from-blue-400 to-purple-500 items-center text-center text-white">
                            <th class="px-2 py-3  font-bold ">ردیف</th>
                            <th class="px-2 py-3  font-bold ">نوع تجهیزات</th>
                            <th class="px-2 py-3  font-bold ">تاریخ</th>
                            <th class="px-2 py-3  font-bold ">تغییرات</th>
                            <th class="px-2 py-3  font-bold ">کاربر</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-300">
                        @foreach($history as $items)
                            <td class="px-2 py-2">{{ $loop->iteration }}</td>
                            <td class="px-2 py-2">{{ $items->equipmentInfo->equipmentType->persian_name }}</td>
                            <td class="px-2 py-2">
                                {{ Jalalian::fromDateTime($items->created_at)->format('H:i:s Y/m/d') }}
                            </td>
                            @php
                                $changes=translateJsonKeysToPersian(json_decode($items->changes,true))
                            @endphp
                            <td class="px-2 py-2">
                                @foreach($changes as $index=>$change)
                                    @if($index=='تاریخ تحویل')
                                        <table
                                            class="w-full border-collapse rounded-lg overflow-hidden text-center datasheet">
                                            <tr class="bg-gradient-to-r from-red-400 to-yellow-500 items-center text-center text-white">
                                                <th class="px-2 py-1  font-bold ">
                                                    نوع
                                                </th>
                                                <th class="px-2 py-1  font-bold ">
                                                    از
                                                </th>
                                                <th class="px-2 py-1  font-bold ">
                                                    به
                                                </th>
                                            </tr>
                                            <tr>
                                                <td class="px-2 py-2">{{ $index }}</td>
                                                <td class="px-2 py-2">{{ $change['از'] }}</td>
                                                <td class="px-2 py-2">{{ $change['به'] }}</td>
                                            </tr>
                                        </table>
                                    @elseif($index=='کد اموال' and $change['از']!=null)
                                        <table
                                            class="w-full border-collapse rounded-lg overflow-hidden text-center datasheet">
                                            <tr class="bg-gradient-to-r from-red-400 to-yellow-500 items-center text-center text-white">
                                                <th class="px-2 py-1  font-bold ">
                                                    نوع
                                                </th>
                                                <th class="px-2 py-1  font-bold ">
                                                    از
                                                </th>
                                                <th class="px-2 py-1  font-bold ">
                                                    به
                                                </th>
                                            </tr>
                                            <tr>
                                                <td class="px-2 py-2">{{ $index }}</td>
                                                <td class="px-2 py-2">{{ $change['از'] }}</td>
                                                <td class="px-2 py-2">{{ $change['به'] }}</td>
                                            </tr>
                                        </table>
                                    @else
                                        @if($index!='کد اموال' and (isset($change['اضافه شده']) or isset($change['تغییر یافته']) or isset($change['حذف شده'])))
                                            <table
                                                class="w-full border-collapse rounded-lg overflow-hidden text-center datasheet">
                                                <tr class="bg-gradient-to-r from-red-400 to-yellow-500 items-center text-center text-white">
                                                    <th class="px-2 py-1  font-bold ">
                                                        نوع
                                                    </th>
                                                    <th class="px-2 py-1  font-bold ">
                                                        اضافه شده
                                                    </th>
                                                    <th class="px-2 py-1  font-bold ">
                                                        تغییر یافته
                                                    </th>
                                                    <th class="px-2 py-1  font-bold ">
                                                        حذف شده
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <td class="px-2 py-2">{{ $index }}</td>
                                                    <td class="px-2 py-2">
                                                        @if(isset($change['اضافه شده']) and !empty($change['اضافه شده']))
                                                            @foreach($change['اضافه شده'] as $added)
                                                                {{ $added }}
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                    <td class="px-2 py-2">
                                                        @if(isset($change['تغییر یافته']) and !empty($change['تغییر یافته']))
                                                            <table
                                                                class="w-full border-collapse rounded-lg overflow-hidden text-center datasheet">
                                                                <tr class="bg-gradient-to-r from-red-400 to-yellow-500 items-center text-center text-white">
                                                                    <th class="px-2 py-1  font-bold ">
                                                                        از
                                                                    </th>
                                                                    <th class="px-2 py-1  font-bold ">
                                                                        به
                                                                    </th>
                                                                </tr>
                                                                @foreach($change['تغییر یافته'] as $changed)
                                                                    <tr>
                                                                        <td class="px-2 py-2">{{ $changed['از'] }}</td>
                                                                        <td class="px-2 py-2">{{ $changed['به'] }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </table>
                                                        @endif
                                                    </td>
                                                    <td class="px-2 py-2">
                                                        @if(isset($change['حذف شده']) and !empty($change['حذف شده']))
                                                            {{ $change['حذف شده'] }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            </table>
                                        @endif
                                    @endif

                                @endforeach
                            </td>
                            <td class="px-2 py-2">
                                {{ $items->userInfo->name . ' ' . $items->userInfo->family }}
                            </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection

