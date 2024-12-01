@php
    $firstKey = array_key_first($items);
    $itemCollection = $items[$firstKey];
    $equipmentInfoMain=json_decode($equipment->info,true);
@endphp
<div>
    <label for="{{ $equipment->equipmentType->name }}"
           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $equipment->equipmentType->persian_name }}</label>
    <select name="{{ $equipment->equipmentType->name }}"
            class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            required>
        <option value="" disabled selected>انتخاب کنید</option>
        @foreach($itemCollection as $item)
            @php
                $equipmentInfo = $firstKey::with('brandInfo')->whereId($item->id)->first()->toArray();
            @endphp

            {{ isset($keyIndex) ? $translatedArray[$keyIndex] : '' }} = {{ $equipmentInfo['brand_info']['name'] }}

            @php
                unset(
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

            <option value="{{ $item->id }}" @if($equipmentInfoMain[$equipment->equipmentType->name]==$item->id) selected @endif>
                {{ $item->brandInfo->name }} -
                @foreach(translateKeysToPersian($equipmentInfo) as $key => $value)
                    @if($key == 'برند' or $key == 'id')
                        @continue
                    @endif
                    {{ $key }}: {{ $value }}
                    @if (!$loop->last)
                        -
                    @endif
                @endforeach
            </option>
        @endforeach
    </select>
</div>
