@php use Morilog\Jalali\Jalalian; @endphp
@extends('layouts.PanelMaster')

@section('content')
    <main class="flex-1 bg-cu-light py-6 px-8">
        <div class="mx-auto lg:mr-72">
            <h1 class="text-2xl font-bold mb-4">تنظیمات سایت</h1>
            @include('layouts.components.errors')
            @include('layouts.components.success')
            <div class="bg-white rounded shadow p-6">
                <table class="w-full border-collapse rounded-lg overflow-hidden text-center datasheet">
                    <thead>
                    <tr class="bg-gradient-to-r from-blue-400 to-purple-500 items-center text-center text-white">
                        <th class="px-6 py-3  font-bold ">ردیف</th>
                        <th class="px-6 py-3  font-bold ">عنوان</th>
                        <th class="px-6 py-3  font-bold ">مقدار</th>
                        <th class="px-6 py-3  font-bold ">ویرایش کننده</th>
                        <th class="px-6 py-3  font-bold ">تاریخ ویرایش</th>
                        <th class="px-6 py-3  font-bold ">عملیات</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-300">
                    @foreach ($settings as $setting)
                        {{ html()->form('PATCH')->route('SiteSettings.update', $setting->id)->id('edit-catalog')->open() }}
                        <tr class="bg-white">
                            <td class="px-6 py-1">{{ $loop->iteration }}</td>
                            <td class="px-6 py-1">
                                {{ $setting->option }}
                            </td>
                            <td class="px-6 py-1">
                                @if($setting->option=='about_us_text')
                                    <textarea id="option" name="option"
                                              class="border rounded-md w-full px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">{{ $setting->value }}</textarea>
                                @elseif($setting->option=='maintenance_mode')
                                    <select name="option"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            required>
                                        <option value="1" {{$setting->value ? 'selected' : ''}}>فعال</option>
                                        <option value="0" {{!$setting->value ? 'selected' : ''}}>غیر فعال</option>
                                    </select>
                                @else
                                    <input type="text" id="option" name="option" value="{{ $setting->value }}"
                                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                           placeholder="" required>
                                @endif
                            </td>
                            <td class="px-6 py-1">
                                @if($setting->editorInfo!=null)
                                    {{ $setting->editorInfo->name }} {{ $setting->editorInfo->family }}
                                @endif
                            </td>
                            <td class="px-6 py-1">
                                @if($setting->editorInfo!=null)
                                    {{ Jalalian::fromDateTime($setting->updated_at)->format('H:i:s Y/m/d') }}
                                @endif
                            </td>
                            <td class="px-6 py-1">
                                <input type="hidden" value="{{ $setting->id }}" name="id">
                                <button type="submit"
                                        class="px-4 py-2 mr-3 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300 ReferTypeControl">
                                    ویرایش
                                </button>
                            </td>
                        </tr>
                        {{ html()->form()->close() }}
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </main>
@endsection

