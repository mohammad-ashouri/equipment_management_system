@php use App\Models\HardwareEquipments\InternalHardDisk;use App\Models\Personnel;use Illuminate\Support\Str;use Morilog\Jalali\Jalalian; @endphp
@extends('layouts.PanelMaster')

@section('content')
    <main class="flex-1 bg-cu-light py-6 px-8">
        <div class="mx-auto lg:mr-72">
            <h1 class="text-2xl font-bold mb-4">گزارش تمامی اقلام موجود در سامانه</h1>
            <div class="bg-white rounded shadow p-6 mb-4">
                <div>
                    <table class="datatable w-full border-collapse rounded-lg overflow-hidden text-center mt-3">
                        <thead>
                        <tr class="bg-gradient-to-r from-blue-400 to-purple-500 items-center text-center text-white">
                            <th class=" px-6 py-3 w-9 font-bold ">ردیف</th>
                            <th class=" px-6 py-3 font-bold ">پرسنل</th>
                            <th class=" px-6 py-3 font-bold ">ساختمان</th>
                            <th class=" px-6 py-3 font-bold ">نوع</th>
                            <th class=" px-6 py-3 font-bold ">کد اموال</th>
                            <th class=" px-6 py-3 font-bold ">تاریخ تحویل</th>
                            <th class=" px-6 py-3 font-bold no-filter">اطلاعات</th>
                            <th class=" px-3 py-3  font-bold ">کاربر ایجاد کننده</th>
                            <th class=" px-3 py-3  font-bold ">تاریخ ایجاد</th>
                            <th class=" px-3 py-3  font-bold ">کاربر ویرایش کننده</th>
                            <th class=" px-3 py-3  font-bold ">تاریخ ویرایش</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($allEquipments as $equipment)
                            <tr class="odd:bg-gray-300 even:bg-white">
                                <td class="py-2">{{ $loop->iteration }}</td>
                                <td class="py-2">{{ $equipment->personnelInfo->personnel_code }}</td>
                                <td class="py-2">{{ $equipment->buildingInfo->name }}</td>
                                <td class="py-2">{{ $equipment->equipmentType->persian_name }}</td>
                                <td class="py-2">{{ $equipment->property_code }}</td>
                                <td class="py-2">{{ $equipment->delivery_date }}</td>
                                <td class="py-2 w-24">@php $directory = app_path('Models'); $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory)); $paths=$modelPath=[]; foreach ($files as $file) { if ($file->isFile()) { $relativePath = str_replace(app_path() . DIRECTORY_SEPARATOR, '', $file->getRealPath()); $relativePath = str_replace('/', '\\', $relativePath); $relativePath = str_replace('.php', '', $relativePath); $paths[] = 'App\\' . $relativePath; } } $originalArray=json_decode($equipment->info,true); $translatedArray = []; foreach (translateKeysToPersian($originalArray) as $key => $value) { $translatedArray[] = $key; } @endphp @foreach($originalArray as $index=>$info) @php $searchTerm = Str::studly($index); $result = array_filter($paths, function ($path) use ($searchTerm) { return basename(str_replace('\\', '/', $path)) === $searchTerm; }); @endphp @if(!empty($result) and $info!='ندارد') @php $equipmentInfo=reset($result)::with('brandInfo')->whereId($info)->first(); if($equipmentInfo){ $equipmentInfo=$equipmentInfo->toArray(); } if (array_key_exists($index,$originalArray)){ $keyIndex = array_search($index, array_keys($originalArray)); } @endphp {{ isset($keyIndex) ? $translatedArray[$keyIndex] : '' }} = {{ isset($equipmentInfo['brand_info']['name']) ? $equipmentInfo['brand_info']['name'] : null }} @php unset( $equipmentInfo['id'], $equipmentInfo['brand'], $equipmentInfo['status'], $equipmentInfo['adder'], $equipmentInfo['editor'], $equipmentInfo['created_at'], $equipmentInfo['updated_at'], $equipmentInfo['brand_info']['id'], $equipmentInfo['brand_info']['status'], $equipmentInfo['brand_info']['adder'], $equipmentInfo['brand_info']['editor'], ); @endphp @foreach(translateKeysToPersian($equipmentInfo) as $key=>$item) @if($key=='برند') @continue @endif {{ $key }}: {{ $item }} @endforeach @elseif($searchTerm=='InternalHardDisks') @foreach($info as $key=>$internalHardDisk) @php $equipmentInfo=InternalHardDisk::with('brandInfo')->whereId($internalHardDisk['id'])->first(); @endphp هارد اینترنال = {{ $equipmentInfo->brandInfo->name }} {{ $equipmentInfo->model }} {{ $equipmentInfo->capacity }} {{ $equipmentInfo->connectivity_type }} {{ $equipmentInfo->type }} {{ $equipmentInfo->size }} ( کد اموال: {{ $info[$key]['property_code'] }} ) @endforeach @endif @endforeach</td>
                                <td class="px-6 py-4">{{ $equipment->adderInfo->name }} {{ $equipment->adderInfo->family }}</td>
                                <td class="px-6 py-4">
                                    {{ Jalalian::fromDateTime($equipment->created_at)->format('H:i:s Y/m/d') }}
                                </td>
                                <td class="px-6 py-4">{{ $equipment->editorInfo?->name }} {{ $equipment->editorInfo?->family }}</td>
                                <td class="px-6 py-4">
                                    {{ !empty($equipment->editor) ? Jalalian::fromDateTime($equipment->updated_at)->format('H:i:s Y/m/d') : null }}
                                </td>
                            </tr>
                        @endforeach
                        @foreach($internalHardDisks as $internalHardDisk)
                            @php
                                $hardDisks=[];
                                $hardDisksInfo=json_decode($internalHardDisk->internalharddisks,true);
                                if ($internalHardDisk->internalharddisks == null){
                                    continue;
                                }
                                foreach ($hardDisksInfo as $info){
                                    $hardInfo=InternalHardDisk::find($info['id']);
                                    $hardDisks[]=['info'=>$hardInfo->brandInfo->name. " - " . $hardInfo->model . " - " . $hardInfo->capacity,"property_code"=>$info['property_code'],"building"=>$internalHardDisk->buildingInfo->name];
                                }
                                $personnel=Personnel::find($internalHardDisk->personnel);
                            @endphp
                            @foreach($hardDisks as $hardDisk)
                                <tr class="odd:bg-gray-300 even:bg-white">
                                    <td class="py-2">{{ $loop->iteration }}</td>
                                    <td class="py-2">{{ $personnel->personnel_code }}
                                        - {{ $personnel->first_name }} {{ $personnel->last_name }}</td>
                                    <td class="py-2">{{ $hardDisk['building'] }}</td>
                                    <td class="py-2">هارد اینترنال</td>
                                    <td class="py-2">{{ $hardDisk['property_code'] }}</td>
                                    <td class="py-2"></td>
                                    <td class="py-2 w-24">{{ $hardDisk['info'] }}</td>
                                    <td class="px-6 py-4"></td>
                                    <td class="px-6 py-4"></td>
                                    <td class="px-6 py-4"></td>
                                    <td class="px-6 py-4"></td>
                                </tr>
                            @endforeach
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection

