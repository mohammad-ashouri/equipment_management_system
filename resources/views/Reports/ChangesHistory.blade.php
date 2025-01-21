@php use App\Models\Catalogs\Building;use App\Models\HardwareEquipments\InternalHardDisk;use App\Models\Personnel;use Illuminate\Support\Str;use Morilog\Jalali\Jalalian;use function Sodium\add; @endphp
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
                                                    ساختمان محل استقرار
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
                                                    {{ Building::find($changes['ساختمان']) ? Building::find($changes['ساختمان'])->name : null }}
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
                                                                return preg_match('/\\\\' . preg_quote($searchTerm, '/') . '$/', $path);
                                                            });

                                                        @endphp
                                                        @if(!empty($result))
                                                            @php
                                                                $equipmentInfo=reset($result)::with('brandInfo')->whereId($info)->first()->toArray();
                                                                if (array_key_exists($index,$originalArray)){
                                                                    $keyIndex = array_search($index, array_keys($originalArray));
                                                                }
                                                            @endphp
                                                            {{ isset($keyIndex) ? $translatedArray[$keyIndex] : '' }}
                                                            = {{ @$equipmentInfo['brand_info']['name'] }}
                                                            @php
                                                                unset(
                                                                    $equipmentInfo['id'],
                                                                    $equipmentInfo['brand'],
                                                                    $equipmentInfo['status'],
                                                                    $equipmentInfo['adder'],
                                                                    $equipmentInfo['editor'],
                                                                    $equipmentInfo['created_at'],
                                                                    $equipmentInfo['updated_at'],
                                                                    $equipmentInfo['brand_info']['id'],
                                                                    $equipmentInfo['brand_info']['status'],
                                                                    $equipmentInfo['brand_info']['adder'],
                                                                    $equipmentInfo['brand_info']['editor'],
                                                                    );
                                                            @endphp
                                                            @foreach(translateKeysToPersian($equipmentInfo) as $key=>$item)
                                                                @if($key=='برند')
                                                                    @continue
                                                                @endif
                                                                {{ $key }}: {{ $item }}
                                                                <br>
                                                            @endforeach
                                                            <br>
                                                        @elseif($searchTerm=='InternalHardDisks')
                                                            @foreach($info as $key=>$internalHardDisk)
                                                                @php
                                                                    $equipmentInfo=InternalHardDisk::with('brandInfo')->whereId($internalHardDisk['id'])->first();
                                                                @endphp
                                                                هارد اینترنال
                                                                = {{ $equipmentInfo->brandInfo->name }}
                                                                {{ $equipmentInfo->model }}
                                                                {{ $equipmentInfo->capacity }}
                                                                {{ $equipmentInfo->connectivity_type }}
                                                                {{ $equipmentInfo->type }}
                                                                {{ $equipmentInfo->size }}
                                                                ( کد اموال: {{ $info[$key]['property_code'] }} )
                                                                <br/>
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                </td>
                                            </tr>
                                        </table>

                                    @elseif(isset($changesEdit['وضعیت']) and $changesEdit['وضعیت']=='moved')
                                        <table
                                            class="w-full border-collapse rounded-lg overflow-hidden text-center datasheet">
                                            <tr class="bg-gradient-to-r from-red-400 to-yellow-500 items-center text-center text-white">
                                                <th class="px-2 py-1  font-bold ">
                                                    وضعیت
                                                </th>
                                                <th class="px-2 py-1  font-bold ">
                                                    اطلاعات
                                                </th>
                                                <th class="px-2 py-1  font-bold ">
                                                    عملیات
                                                </th>
                                            </tr>
                                            <tr>
                                                <td class="px-2 py-2">
                                                    منتقل شده
                                                </td>
                                                <td class="px-2 py-2">
                                                    {{ $changesEdit['اطلاعات'][0] }}
                                                </td>
                                                <td class="px-2 py-2">
                                                    @php
                                                        $secondPersonnelInfo=Personnel::find($changesEdit['second_personnel']);
                                                    @endphp
                                                    <a href="{{ route('Personnels.equipments',['personnel'=>$secondPersonnelInfo->id]) }}">
                                                        <button id="backward_page" type="button"
                                                                class="mt-3 w-full inline-flex justify-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300 sm:mt-0 sm:w-auto">
                                                            تمامی تجهیزات
                                                            {{ $secondPersonnelInfo->first_name }} {{ $secondPersonnelInfo->last_name }}
                                                        </button>
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>

                                    @else
                                        <table
                                            class="w-full border-collapse rounded-lg overflow-hidden text-center datasheet">
                                            <tr class="bg-gradient-to-r from-red-400 to-yellow-500 items-center text-center text-white">
                                                <th class="px-2 py-1 font-bold">نوع</th>
                                                {{--                                                <th class="px-2 py-1 font-bold">اضافه شده</th>--}}
                                                <th class="px-2 py-1 font-bold">تغییر یافته</th>
                                                {{--                                                <th class="px-2 py-1 font-bold">حذف شده</th>--}}
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
                                                                {{ $key=='ساختمان' ? Building::find($added)->name : $added }}
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
                                                        {{--                                                        <td class="px-2 py-2">-</td>--}}
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
                                                                        @if(!empty($result) and $englishKeys[$counter]!='internalHardDisk')
                                                                            @php
                                                                                if (is_array($modified['from'])){
                                                                                    $equipmentInfoFrom=reset($result)::with('brandInfo')->whereIn('id',$modified['from'])->get()->toArray();

                                                                                }else{
                                                                                    $equipmentInfoFrom=reset($result)::with('brandInfo')->whereId($modified['from'])->get()->toArray();
                                                                                }

                                                                                if (is_array($modified['to'])){
                                                                                    $equipmentInfoTo=reset($result)::with('brandInfo')->whereIn('id',$modified['to'])->get()->toArray();
                                                                                }else{
                                                                                    $equipmentInfoTo=reset($result)::with('brandInfo')->whereId($modified['to'])->get()->toArray();
                                                                                }
                                                                            @endphp

                                                                        @endif
                                                                        <td class="px-2 py-2">
                                                                            @if (is_array($equipmentInfoFrom) and $englishKeys[$counter]!='delivery_date' and $englishKeys[$counter]!='building' and $englishKeys[$counter]!='internalHardDisk')
                                                                                @foreach($equipmentInfoFrom as $from)
                                                                                    @php
                                                                                        unset(
                                                                                            $from['id'],
                                                                                            $from['brand'],
                                                                                            $from['status'],
                                                                                            $from['adder'],
                                                                                            $from['editor'],
                                                                                            $from['created_at'],
                                                                                            $from['updated_at'],
                                                                                            $from['brand_info']['id'],
                                                                                            $from['brand_info']['status'],
                                                                                            $from['brand_info']['adder'],
                                                                                            $from['brand_info']['editor'],
                                                                                            );
                                                                                    @endphp
                                                                                    {{ $from['brand_info']['name'] }}
                                                                                    {{ isset($from['model']) ? $from['model'] : null }}
                                                                                    @foreach(translateKeysToPersian($from) as $key=>$item)
                                                                                        @if($key=='برند')
                                                                                            @continue
                                                                                        @endif
                                                                                        {{ $key }}: {{ $item }}
                                                                                    @endforeach
                                                                                    <br>
                                                                                @endforeach
                                                                            @elseif($englishKeys[$counter]=='internalHardDisk')
                                                                                @foreach($modified['from'] as $key=>$internalHardDisk)
                                                                                    @php
                                                                                        $equipmentInfo=InternalHardDisk::with('brandInfo')->whereId($internalHardDisk['id'])->first();
                                                                                    @endphp
                                                                                    {{ $equipmentInfo->brandInfo->name }}
                                                                                    {{ $equipmentInfo->model }}
                                                                                    {{ $equipmentInfo->capacity }}
                                                                                    {{ $equipmentInfo->connectivity_type }}
                                                                                    {{ $equipmentInfo->type }}
                                                                                    {{ $equipmentInfo->size }}
                                                                                    ( کد
                                                                                    اموال: {{ $internalHardDisk['کد اموال'] }}
                                                                                    )
                                                                                    <br/>
                                                                                @endforeach
                                                                            @elseif($englishKeys[$counter]=='building')
                                                                                {{ Building::find($modified['from'])->name }}
                                                                            @else
                                                                                {{ is_array($modified['from']) ? implode(', ', $modified['from']) : $modified['from'] }}
                                                                            @endif
                                                                        </td>
                                                                        <td class="px-2 py-2">
                                                                            @if (is_array($equipmentInfoTo) and $englishKeys[$counter]!='delivery_date' and $englishKeys[$counter]!='building' and $key!='internalHardDisk')
                                                                                @foreach($equipmentInfoTo as $to)

                                                                                    {{ $to['brand_info']['name'] }}
                                                                                    {{ isset($to['model']) ? $to['model'] : null }}
                                                                                    @php
                                                                                        unset(
                                                                                            $to['id'],
                                                                                            $to['brand'],
                                                                                            $to['status'],
                                                                                            $to['adder'],
                                                                                            $to['editor'],
                                                                                            $to['created_at'],
                                                                                            $to['updated_at'],
                                                                                            $to['brand_info']['id'],
                                                                                            $to['brand_info']['status'],
                                                                                            $to['brand_info']['adder'],
                                                                                            $to['brand_info']['editor'],
                                                                                            );
                                                                                    @endphp
                                                                                    @foreach(translateKeysToPersian($to) as $key=>$item)
                                                                                        @if($key=='برند')
                                                                                            @continue
                                                                                        @endif
                                                                                        {{ $key }}: {{ $item }}
                                                                                    @endforeach
                                                                                    <br>
                                                                                @endforeach
                                                                            @elseif($englishKeys[$counter]=='internalHardDisk')
                                                                                @foreach($modified['to'] as $key=>$internalHardDisk)
                                                                                    @php
                                                                                        $equipmentInfo=InternalHardDisk::with('brandInfo')->whereId($internalHardDisk['id'])->first();
                                                                                    @endphp
                                                                                    {{ $equipmentInfo->brandInfo->name }}
                                                                                    {{ $equipmentInfo->model }}
                                                                                    {{ $equipmentInfo->capacity }}
                                                                                    {{ $equipmentInfo->connectivity_type }}
                                                                                    {{ $equipmentInfo->type }}
                                                                                    {{ $equipmentInfo->size }}
                                                                                    ( کد
                                                                                    اموال: {{ $internalHardDisk['کد اموال'] }}
                                                                                    )
                                                                                    <br/>
                                                                        @endforeach
                                                                        @elseif($englishKeys[$counter]=='building')
                                                                            {{ Building::find($modified['to'])->name }}
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
                                                        {{--                                                        <td class="px-2 py-2">{{ $key }}</td>--}}
                                                        {{--                                                        <td class="px-2 py-2">-</td>--}}
                                                        {{--                                                        <td class="px-2 py-2">-</td>--}}
                                                        {{--                                                        <td class="px-2 py-2">--}}
                                                        {{--                                                            @if(is_array($removed))--}}
                                                        {{--                                                                @foreach($removed as $value)--}}
                                                        {{--                                                                    {{ $value }}--}}
                                                        {{--                                                                @endforeach--}}
                                                        {{--                                                            @else--}}
                                                        {{--                                                                {{ $removed }}--}}
                                                        {{--                                                            @endif--}}
                                                        {{--                                                        </td>--}}
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

