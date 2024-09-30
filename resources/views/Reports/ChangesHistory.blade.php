@php use Illuminate\Support\Str;use Morilog\Jalali\Jalalian; @endphp
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
                            <tr>
                                <td class="px-2 py-2">{{ $loop->iteration }}</td>
                                <td class="px-2 py-2">{{ $items->equipmentInfo->equipmentType->persian_name }}</td>
                                <td class="px-2 py-2">
                                    {{ Jalalian::fromDateTime($items->created_at)->format('H:i:s Y/m/d') }}
                                </td>
                                @php
                                    $directory = app_path('Models');
                                    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
                                    $paths=$modelPath=[];
                                    foreach ($files as $file) {
                                        if ($file->isFile()) {
                                            $relativePath = str_replace(app_path() . DIRECTORY_SEPARATOR, '', $file->getRealPath());
                                            $relativePath = str_replace('/', '\\', $relativePath);
                                            $relativePath = str_replace('.php', '', $relativePath);

                                            $paths[] = 'App\\' . $relativePath;
                                        }
                                    }
                                    $changes=translateKeysToPersian(json_decode($items->new,true));
                                    $changesNew=translateKeysToPersian(json_decode($items->new,true));
                                    $changesEdit=translateKeysToPersian(json_decode($items->edit,true));
                                    $changesDelete=translateKeysToPersian(json_decode($items->delete,true));
                                @endphp
                                <td class="px-2 py-2">
                                    @if(isset($changes['وضعیت']) and $changes['وضعیت']=='created')
                                        <table
                                            class="w-full border-collapse rounded-lg overflow-hidden text-center datasheet">
                                            <tr class="bg-gradient-to-r from-red-400 to-yellow-500 items-center text-center text-white">
                                                <th class="px-2 py-1  font-bold ">
                                                    وضعیت
                                                </th>
                                                <th class="px-2 py-1  font-bold ">
                                                    تاریخ تحویل
                                                </th>
                                                <th class="px-2 py-1  font-bold ">
                                                    کد اموال
                                                </th>
                                                <th class="px-2 py-1  font-bold ">
                                                    اطلاعات
                                                </th>
                                            </tr>
                                            <tr>
                                                <td class="px-2 py-2">
                                                    تحویل داده شد به
                                                    <a target="_blank" class="text-blue-600"
                                                       title="کلیک برای نمایش پرسنل"
                                                       href="{{ route('Personnels.edit',$items->equipmentInfo->personnelInfo->id) }}">
                                                        {{ $items->equipmentInfo->personnelInfo->first_name }} {{ $items->equipmentInfo->personnelInfo->last_name }}
                                                    </a>
                                                </td>
                                                <td class="px-2 py-2">
                                                    {{ $changes['تاریخ تحویل'] }}
                                                </td>
                                                <td class="px-2 py-2">
                                                    {{ $changes['کد اموال'] }}
                                                </td>
                                                <td class="px-2 py-2">
                                                    @php
                                                        $originalArray=json_decode($changes['اطلاعات'],true);

                                                        $translatedArray = [];
                                                        foreach (translateKeysToPersian($originalArray) as $key => $value) {
                                                            $translatedArray[] = $key;
                                                        }
                                                    @endphp
                                                    @foreach($originalArray as $index=>$info)
                                                        @php
                                                            $searchTerm = Str::studly($index);

                                                            $result = array_filter($paths, function ($path) use ($searchTerm) {
                                                                return stripos($path, $searchTerm) !== false;
                                                            });
                                                        @endphp
                                                        @if(!empty($result))
                                                            @php
                                                                $equipmentInfo=reset($result)::with('brandInfo')->whereId($info)->first() ;
                                                                if (array_key_exists($index,$originalArray)){
                                                                    $keyIndex = array_search($index, array_keys($originalArray));
                                                                }
                                                            @endphp
                                                            {{ isset($keyIndex) ? $translatedArray[$keyIndex] : '' }}
                                                            = {{ $equipmentInfo->brandInfo->name }}
                                                            {{ $equipmentInfo->model }}
                                                            {{ $equipmentInfo->capacity }}
                                                            {{ $equipmentInfo->generation }}
                                                            {{ $equipmentInfo->ram_size }}
                                                            {{ $equipmentInfo->connectivity_type }}
                                                            {{ $equipmentInfo->cpu_slot_type }}
                                                            {{ $equipmentInfo->cpu_slots_number }}
                                                            {{ $equipmentInfo->ram_slot_type }}
                                                            {{ $equipmentInfo->type }}
                                                            {{ $equipmentInfo->size }}
                                                            {{ $equipmentInfo->frequency }}
                                                            {{ $equipmentInfo->channels ? 'تعداد کانال: '.$equipmentInfo->channels : '' }}
                                                            {{ $equipmentInfo->voltage ? $equipmentInfo->voltage.'w' : '' }}
                                                            <br>
                                                        @endif
                                                    @endforeach
                                                </td>
                                            </tr>
                                        </table>
                                    @else
                                        <table
                                            class="w-full border-collapse rounded-lg overflow-hidden text-center datasheet">
                                            <tr class="bg-gradient-to-r from-red-400 to-yellow-500 items-center text-center text-white">
                                                <th class="px-2 py-1 font-bold">نوع</th>
                                                <th class="px-2 py-1 font-bold">اضافه شده</th>
                                                <th class="px-2 py-1 font-bold">تغییر یافته</th>
                                                <th class="px-2 py-1 font-bold">حذف شده</th>
                                            </tr>

                                            <!-- Added Data -->
                                            @if(!empty($changesNew) and is_array($changesNew))
                                                @foreach($changesNew as $key => $added)
                                                    <tr>
                                                        <td class="px-2 py-2">{{ $key }}</td>
                                                        <td class="px-2 py-2">
                                                            @if(is_array($added))
                                                                @foreach($added as $value)
                                                                    {{ $value }}
                                                                @endforeach
                                                            @else
                                                                {{ $added }}
                                                            @endif
                                                        </td>
                                                        <td class="px-2 py-2">-</td>
                                                        <td class="px-2 py-2">-</td>
                                                    </tr>
                                                @endforeach
                                            @endif

                                            <!-- Edited Data -->

                                            @if(!empty($changesEdit) and is_array($changesEdit))
                                                @php
                                                    $englishKeys = array_keys(translateKeysToEnglish($changesEdit));
                                                    $counter=0;
                                                @endphp
                                                @foreach($changesEdit as $key => $modified)
                                                    <tr>
                                                        <td class="px-2 py-2">{{ $key }}</td>
                                                        <td class="px-2 py-2">-</td>
                                                        <td class="px-2 py-2">
                                                            @if(is_array($modified))
                                                                <table
                                                                    class="w-full border-collapse rounded-lg overflow-hidden text-center datasheet">
                                                                    <tr class="bg-gradient-to-r from-red-400 to-yellow-500 items-center text-center text-white">
                                                                        <th class="px-2 py-1 font-bold">از</th>
                                                                        <th class="px-2 py-1 font-bold">به</th>
                                                                    </tr>
                                                                    <tr>
                                                                        @php
                                                                            $equipmentInfoFrom=$equipmentInfoTo=null;
                                                                                $result = array_filter($paths, function ($path) use ($englishKeys,$counter) {
                                                                                    if ($englishKeys[$counter]!='delivery_date'){
                                                                                            return stripos($path, Str::studly($englishKeys[$counter++])) !== false;
                                                                                    }
                                                                                });
                                                                        @endphp
                                                                        @if(!empty($result))
                                                                            @php
                                                                                if (is_array($modified['from'])){
                                                                                    $equipmentInfoFrom=reset($result)::with('brandInfo')->whereIn('id',$modified['from'])->get()->toArray();
                                                                                }else{
                                                                                    $equipmentInfoFrom=reset($result)::with('brandInfo')->whereId($modified['from'])->first();
                                                                                }

                                                                                if (is_array($modified['to'])){
                                                                                    $equipmentInfoTo=reset($result)::with('brandInfo')->whereIn('id',$modified['to'])->get()->toArray();
                                                                                }else{
                                                                                    $equipmentInfoTo=reset($result)::with('brandInfo')->whereId($modified['to'])->first();
                                                                                }
                                                                            @endphp
                                                                        @endif
                                                                        <td class="px-2 py-2">
                                                                            @if (is_array($equipmentInfoFrom) and $englishKeys[$counter]!='delivery_date')
                                                                                @foreach($equipmentInfoFrom as $from)
                                                                                    {{ $from['brand_info']['name'] }}
                                                                                    {{ $from['model'] }}
                                                                                    {{ isset($from['capacity']) ? $from['capacity'] : '' }}
                                                                                    {{ isset($from['generation']) ? $from['generation'] : '' }}
                                                                                    {{ isset($from['ram_size']) ? $from['ram_size'] : '' }}
                                                                                    {{ isset($from['connectivity_type']) ? $from['connectivity_type'] : '' }}
                                                                                    {{ isset($from['cpu_slot_type']) ? $from['cpu_slot_type'] : '' }}
                                                                                    {{ isset($from['cpu_slots_number']) ? $from['cpu_slots_number'] : '' }}
                                                                                    {{ isset($from['ram_slot_type']) ? $from['ram_slot_type'] : '' }}
                                                                                    {{ isset($from['type']) ? $from['type'] : '' }}
                                                                                    {{ isset($from['size']) ? $from['size'] : '' }}
                                                                                    {{ isset($from['frequency']) ? $from['frequency'] : '' }}
                                                                                    {{ isset($from['channels']) ? 'تعداد کانال: '.$from['channels'] : '' }}
                                                                                    {{ isset($from['voltage']) ? $from['voltage'].'w' : '' }}
                                                                                    <br>
                                                                                @endforeach
                                                                            @else
                                                                                {{ is_array($modified['from']) ? implode(', ', $modified['from']) : $modified['from'] }}
                                                                            @endif
                                                                        </td>
                                                                        <td class="px-2 py-2">
                                                                            @if (is_array($equipmentInfoTo) and $englishKeys[$counter]!='delivery_date')
                                                                                @foreach($equipmentInfoTo as $to)
                                                                                    {{ $to['brand_info']['name'] }}
                                                                                    {{ $to['model'] }}
                                                                                    {{ isset($to['capacity']) ? $to['capacity'] : '' }}
                                                                                    {{ isset($to['generation']) ? $to['generation'] : '' }}
                                                                                    {{ isset($to['ram_size']) ? $to['ram_size'] : '' }}
                                                                                    {{ isset($to['connectivity_type']) ? $to['connectivity_type'] : '' }}
                                                                                    {{ isset($to['cpu_slot_type']) ? $to['cpu_slot_type'] : '' }}
                                                                                    {{ isset($to['cpu_slots_number']) ? $to['cpu_slots_number'] : '' }}
                                                                                    {{ isset($to['ram_slot_type']) ? $to['ram_slot_type'] : '' }}
                                                                                    {{ isset($to['type']) ? $to['type'] : '' }}
                                                                                    {{ isset($to['size']) ? $to['size'] : '' }}
                                                                                    {{ isset($to['frequency']) ? $to['frequency'] : '' }}
                                                                                    {{ isset($to['channels']) ? 'تعداد کانال: '.$to['channels'] : '' }}
                                                                                    {{ isset($to['voltage']) ? $to['voltage'].'w' : '' }}
                                                                                    <br>
                                                                        @endforeach
                                                                        @else
                                                                            {{ is_array($modified['to']) ? implode(', ', $modified['to']) : $modified['to'] }}
                                                                        @endif
                                                                    </tr>
                                                                </table>
                                                            @endif
                                                        </td>
                                                        <td class="px-2 py-2">-</td>
                                                    </tr>
                                                    @php
                                                        $counter++;
                                                    @endphp
                                                @endforeach
                                            @endif

                                            <!-- Removed Data -->
                                            @if(!empty($changesDelete) and is_array($changesDelete))
                                                @foreach($changesDelete as $key => $removed)
                                                    <tr>
                                                        <td class="px-2 py-2">{{ $key }}</td>
                                                        <td class="px-2 py-2">-</td>
                                                        <td class="px-2 py-2">-</td>
                                                        <td class="px-2 py-2">
                                                            @if(is_array($removed))
                                                                @foreach($removed as $value)
                                                                    {{ $value }}
                                                                @endforeach
                                                            @else
                                                                {{ $removed }}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </table>

                                    @endif
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

