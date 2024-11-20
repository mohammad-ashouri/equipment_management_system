@extends('layouts.PanelMaster')

@section('content')
    <main class="flex-1 bg-gray-100 py-6 px-8">
        <div class="mx-auto lg:mr-72">
            <h1 class="text-2xl font-bold mb-4">مدیریت پرسنل</h1>
            @include('layouts.components.errors')
            @include('layouts.components.success')
            <div class="bg-white rounded shadow p-6 flex flex-col ">
                @can('ایجاد پرسنل')
                    <a type="button" href="{{route('Personnels.create')}}"
                       class="px-4 py-2 bg-green-500 w-40 mb-2 text-center text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                        پرسنل جدید
                    </a>
                @endcan
                @if(empty($personnels) or $personnels->isEmpty())
                    <div role="alert" class="alert alert-info">
                        <i style="font-size: 20px" class="las la-info-circle"></i>
                        <span>اطلاعاتی یافت نشد!</span>
                    </div>
                @else
                    <table class="datatable w-full border-collapse rounded-lg overflow-hidden text-center datasheet">
                        <thead>
                        <tr class="bg-gradient-to-r from-blue-400 to-purple-500 items-center text-center text-white">
                            <th class="px-6 py-3  font-bold ">ردیف</th>
                            <th class="px-6 py-3  font-bold ">کد پرسنلی</th>
                            <th class="px-6 py-3  font-bold ">مشخصات</th>
                            <th class="px-6 py-3  font-bold ">ساختمان</th>
                            <th class="px-6 py-3  font-bold ">شماره اتاق</th>
                            <th class="px-6 py-3  font-bold action">عملیات</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-300">
                        @foreach ($personnels as $personnel)
                            <tr class="bg-white">
                                <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4">{{ $personnel->personnel_code }}</td>
                                <td class="px-6 py-4">
                                    {{ $personnel->first_name }} {{ $personnel->last_name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $personnel->buildingInfo->name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $personnel->room_number }}
                                </td>
                                <td class="px-6 py-4">
                                    @can('ویرایش پرسنل')
                                        <a href="{{ route('Personnels.edit',$personnel->id) }}">
                                            <button type="button" data-id="{{ $personnel->id }}"
                                                    class="px-4 py-2 mr-3 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300 ">
                                                ویرایش
                                            </button>
                                        </a>
                                    @endcan
                                    @can('ویرایش تجهیزات پرسنل')
                                        <a href="{{ route('Personnels.equipments',$personnel->id) }}">
                                            <button type="button" data-id="{{ $personnel->id }}"
                                                    class="px-4 py-2 mr-1 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 focus:outline-none focus:ring focus:border-yellow-300 ">
                                                تجهیزات
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
