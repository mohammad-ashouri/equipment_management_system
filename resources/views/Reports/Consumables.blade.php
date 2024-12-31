@php use Illuminate\Support\Str;use Morilog\Jalali\Jalalian; @endphp
@extends('layouts.PanelMaster')

@section('content')
    <main class="flex-1 bg-cu-light py-6 px-8">
        <div class="mx-auto lg:mr-72">
            <h1 class="text-2xl font-bold mb-4">لوازم و اقلام مصرفی واحد اداری</h1>
            <div class="bg-white rounded shadow p-6 mb-4">
                <div>
                    <table class="datatable w-full border-collapse rounded-lg overflow-hidden text-center mt-3">
                        <thead>
                        <tr class="bg-gradient-to-r from-blue-400 to-purple-500 items-center text-center text-white">
                            <th class=" px-6 py-3 w-9 font-bold ">ردیف</th>
                            <th class=" px-6 py-3 font-bold ">نام</th>
                            <th class=" px-6 py-3 font-bold ">تعداد</th>
                            <th class=" px-3 py-3  font-bold ">کاربر ایجاد کننده</th>
                            <th class=" px-3 py-3  font-bold ">تاریخ ایجاد</th>
                            <th class=" px-3 py-3  font-bold ">کاربر ویرایش کننده</th>
                            <th class=" px-3 py-3  font-bold ">تاریخ ویرایش</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($consumables as $consumable)
                            <tr class="odd:bg-gray-300 even:bg-white">
                                <td class="py-2">{{ $loop->iteration }}</td>
                                <td class="py-2">{{ $consumable->name }}</td>
                                <td class="py-2">{{ $consumable->number }}</td>
                                <td class="px-6 py-4">{{ $consumable->adderInfo->name }} {{ $consumable->adderInfo->family }}</td>
                                <td class="px-6 py-4">
                                    {{ Jalalian::fromDateTime($consumable->created_at)->format('H:i:s Y/m/d') }}
                                </td>
                                <td class="px-6 py-4">{{ $consumable->editorInfo?->name }} {{ $consumable->editorInfo?->family }}</td>
                                <td class="px-6 py-4">
                                    {{ !empty($consumable->editor) ? Jalalian::fromDateTime($consumable->updated_at)->format('H:i:s Y/m/d') : null }}
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

