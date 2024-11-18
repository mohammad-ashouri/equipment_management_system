@php use Morilog\Jalali\Jalalian; @endphp
@extends('layouts.PanelMaster')

@section('content')
    <main class="flex-1 bg-gray-100 py-6 px-8">
        <div class="mx-auto lg:mr-72">
            <h1 class="text-2xl font-bold mb-4">تجهیزات پشتیبانی - مدیریت بر اطلاعات فایل کشویی</h1>
            @include('layouts.components.errors')
            @include('layouts.components.success')
            <div class="bg-white rounded shadow p-6 flex flex-col ">
                @can('ایجاد فایل کشویی')
                    <a type="button" href="{{route('DrawerFileCabinets.create')}}"
                       class="px-4 py-2 bg-green-500 w-40 mb-2 text-center text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                        فایل کشویی جدید
                    </a>
                @endcan
                @if(empty($drawerFileCabinets) or $drawerFileCabinets->isEmpty())
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
                            <th class="px-6 py-3  font-bold ">جنس</th>
                            <th class="px-6 py-3  font-bold ">تعداد کشو</th>
                            <th class="px-6 py-3  font-bold ">وضعیت قفل</th>
                            <th class="px-6 py-3  font-bold ">وضعیت</th>
                            <th class="px-6 py-3  font-bold ">کاربر ثبت کننده</th>
                            <th class="px-6 py-3  font-bold ">تاریخ ثبت</th>
                            <th class="px-6 py-3  font-bold ">کاربر ویرایش کننده</th>
                            <th class="px-6 py-3  font-bold ">تاریخ ویرایش</th>
                            <th class="px-6 py-3  font-bold ">عملیات</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-300">
                        @foreach ($drawerFileCabinets as $drawerFileCabinet)
                            <tr class="bg-white">
                                <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4">
                                    {{ $drawerFileCabinet->brandInfo->name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $drawerFileCabinet->material }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $drawerFileCabinet->drawer_number }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $drawerFileCabinet->lock ? 'دارد' : 'ندارد' }}
                                </td>
                                <td class="px-6 py-4">
                                    @switch($drawerFileCabinet->status)
                                        @case(1)
                                            فعال
                                            @break
                                        @case(0)
                                            غیر فعال
                                            @break
                                    @endswitch
                                </td>
                                <td class="px-6 py-4">
                                    {{ $drawerFileCabinet->adderInfo->name }} {{ $drawerFileCabinet->adderInfo->family }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ Jalalian::fromDateTime($drawerFileCabinet->created_at)->format('H:i:s Y/m/d') }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($drawerFileCabinet->editorInfo!=null)
                                        {{ $drawerFileCabinet->editorInfo->name }} {{ $drawerFileCabinet->editorInfo->family }}
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    {{ Jalalian::fromDateTime($drawerFileCabinet->updated_at)->format('H:i:s Y/m/d') }}
                                </td>
                                <td class="px-6 py-4">
                                    @can('ویرایش فایل کشویی')
                                        <a href="{{ route('DrawerFileCabinets.edit',$drawerFileCabinet->id) }}">
                                            <button type="button" data-id="{{ $drawerFileCabinet->id }}"
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
                        {{ $drawerFileCabinets->links() }}
                    </div>
                @endif
            </div>

        </div>
    </main>
@endsection
