@php use Morilog\Jalali\Jalalian; @endphp
@extends('layouts.PanelMaster')

@section('content')
    <main class="flex-1 bg-gray-100 py-6 px-8">
        <div class="mx-auto lg:mr-72">
            <h1 class="text-2xl font-bold mb-4">سایر تجهیزات دیجیتال - مدیریت بر اطلاعات لپ تاپ</h1>
            @include('layouts.components.errors')
            @include('layouts.components.success')
            <div class="bg-white rounded shadow p-6 flex flex-col ">
                @can('ایجاد لپ تاپ')
                    <a type="button" href="{{route('Laptops.create')}}"
                       class="px-4 py-2 bg-green-500 w-40 mb-2 text-center text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                        لپ تاپ جدید
                    </a>
                @endcan
                @if(empty($laptops) or $laptops->isEmpty())
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
                            <th class="px-6 py-3  font-bold ">سایز مانیتور</th>
                            <th class="px-6 py-3  font-bold ">پردازنده</th>
                            <th class="px-6 py-3  font-bold ">گرافیک</th>
                            <th class="px-6 py-3  font-bold ">درایو نوری</th>
                            <th class="px-6 py-3  font-bold ">وضعیت</th>
                            <th class="px-6 py-3  font-bold ">کاربر ثبت کننده</th>
                            <th class="px-6 py-3  font-bold ">تاریخ ثبت</th>
                            <th class="px-6 py-3  font-bold ">کاربر ویرایش کننده</th>
                            <th class="px-6 py-3  font-bold ">تاریخ ویرایش</th>
                            <th class="px-6 py-3  font-bold action">عملیات</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-300">
                        @foreach ($laptops as $laptop)
                            <tr class="bg-white">
                                <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4">
                                    {{ $laptop->brandInfo->name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $laptop->model }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $laptop->monitor_size }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $laptop->cpuInfo->brandInfo->name }} {{ $laptop->cpuInfo->model }} - نسل: {{ $laptop->generation }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $laptop->graphicCardInfo->brandInfo->name }} {{ $laptop->graphicCardInfo->model }} - سایز رم: {{ $laptop->ram_size }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $laptop->odd }}
                                </td>
                                <td class="px-6 py-4">
                                    @switch($laptop->status)
                                        @case(1)
                                            فعال
                                            @break
                                        @case(0)
                                            غیر فعال
                                            @break
                                    @endswitch
                                </td>
                                <td class="px-6 py-4">
                                    {{ $laptop->adderInfo->name }} {{ $laptop->adderInfo->family }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ Jalalian::fromDateTime($laptop->created_at)->format('H:i:s Y/m/d') }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($laptop->editorInfo!=null)
                                        {{ $laptop->editorInfo->name }} {{ $laptop->editorInfo->family }}
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    {{ Jalalian::fromDateTime($laptop->updated_at)->format('H:i:s Y/m/d') }}
                                </td>
                                <td class="px-6 py-4">
                                    @can('ویرایش لپ تاپ')
                                        <a href="{{ route('Laptops.edit',$laptop->id) }}">
                                            <button type="button" data-id="{{ $laptop->id }}"
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
