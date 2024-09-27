@php use Morilog\Jalali\Jalalian; @endphp
@extends('layouts.PanelMaster')

@section('content')
    <main class="flex-1 bg-cu-light py-6 px-8">
        <div class="mx-auto lg:mr-72">
            <h1 class="text-2xl font-bold mb-4">ایجاد بکاپ کامل از دیتابیس</h1>
            <div class="bg-white rounded shadow p-6 mb-4">
                <div>
                    <table class="w-full border-collapse rounded-lg overflow-hidden text-center datasheet">
                        <thead>
                        <tr class="bg-gradient-to-r from-blue-400 to-purple-500 items-center text-center text-white">
                            <th class="px-2 py-3  font-bold ">ردیف</th>
                            <th class="px-2 py-3  font-bold ">تاریخ</th>
                            <th class="px-2 py-3  font-bold ">تغییرات</th>
                            <th class="px-2 py-3  font-bold ">کاربر</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-300">
                        @foreach($history as $items)
                            <td class="px-2 py-4">{{ $loop->iteration }}</td>
                            <td class="px-2 py-4">{{ $items->created_at }}</td>
                            @php
                                $changes=translateJsonKeysToPersian(json_decode($items->changes,true))
                            @endphp
                            <td class="px-2 py-4">
                                @foreach($changes as $index=>$change)
                                    <table
                                        class="w-full border-collapse rounded-lg overflow-hidden text-center datasheet">
                                        <tr class="bg-gradient-to-r from-red-400 to-yellow-500 items-center text-center text-white">
                                            <th class="px-2 py-1  font-bold ">
                                                تاریخ تحویل
                                            </th>
                                            <th class="px-2 py-1  font-bold ">
                                                از
                                            </th>
                                            <th class="px-2 py-1  font-bold ">
                                                به
                                            </th>
                                        </tr>
                                    </table>
                                    {{ $index }} =
                                @endforeach
                            </td>
                            <td class="px-2 py-4">
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

