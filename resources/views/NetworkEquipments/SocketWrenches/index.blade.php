@php use Morilog\Jalali\Jalalian; @endphp
@extends('layouts.PanelMaster')

@section('content')
    <main class="flex-1 bg-gray-100 py-6 px-8">
        <div class="mx-auto lg:mr-72">
            <h1 class="text-2xl font-bold mb-4">تجهیزات شبکه - مدیریت بر اطلاعات آچار سوکت</h1>
            @include('layouts.components.errors')
            @include('layouts.components.success')
            <div class="bg-white rounded shadow p-6 flex flex-col ">
                @can('ایجاد آچار سوکت')
                    <a type="button" href="{{route('SocketWrenches.create')}}"
                       class="px-4 py-2 bg-green-500 w-40 mb-2 text-center text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                        آچار سوکت جدید
                    </a>
                @endcan
                @if(empty($socketWrenches) or $socketWrenches->isEmpty())
                    <div role="alert" class="alert alert-info">
                        <i style="font-size: 20px" class="las la-info-circle"></i>
                        <span>اطلاعاتی یافت نشد!</span>
                    </div>
                @else
                    <table class="w-full border-collapse rounded-lg overflow-hidden text-center datasheet">
                        <thead>
                        <tr class="bg-gradient-to-r from-blue-400 to-purple-500 items-center text-center text-white">
                            <th class="px-6 py-3  font-bold ">ردیف</th>
                            <th class="px-6 py-3  font-bold ">برند</th>
                            <th class="px-6 py-3  font-bold ">مدل</th>
                            <th class="px-6 py-3  font-bold ">وضعیت</th>
                            <th class="px-6 py-3  font-bold ">کاربر ثبت کننده</th>
                            <th class="px-6 py-3  font-bold ">تاریخ ثبت</th>
                            <th class="px-6 py-3  font-bold ">کاربر ویرایش کننده</th>
                            <th class="px-6 py-3  font-bold ">تاریخ ویرایش</th>
                            <th class="px-6 py-3  font-bold ">عملیات</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-300">
                        @foreach ($socketWrenches as $socketWrench)
                            <tr class="bg-white">
                                <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4">
                                    {{ $socketWrench->brandInfo->name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $socketWrench->model }}
                                </td>
                                <td class="px-6 py-4">
                                    @switch($socketWrench->status)
                                        @case(1)
                                            فعال
                                            @break
                                        @case(0)
                                            غیر فعال
                                            @break
                                    @endswitch
                                </td>
                                <td class="px-6 py-4">
                                    {{ $socketWrench->adderInfo->name }} {{ $socketWrench->adderInfo->family }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ Jalalian::fromDateTime($socketWrench->created_at)->format('H:i:s Y/m/d') }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($socketWrench->editorInfo!=null)
                                        {{ $socketWrench->editorInfo->name }} {{ $socketWrench->editorInfo->family }}
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    {{ Jalalian::fromDateTime($socketWrench->updated_at)->format('H:i:s Y/m/d') }}
                                </td>
                                <td class="px-6 py-4">
                                    @can('ویرایش آچار سوکت')
                                        <a href="{{ route('SocketWrenches.edit',$socketWrench->id) }}">
                                            <button type="button" data-id="{{ $socketWrench->id }}"
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

                    <div class="mt-4 flex justify-center" id="laravel-next-prev">
                        {{ $socketWrenches->links() }}
                    </div>
                @endif
            </div>

        </div>
    </main>
@endsection