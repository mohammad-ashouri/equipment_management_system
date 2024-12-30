@php
    if (!empty($items)){
        $firstKey = array_key_first($items);
        $itemCollection = $items[$firstKey];
    }
@endphp

<div>
    <label for="{{ $equipmentType->name }}"
           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $equipmentType->persian_name }}</label>
    <select name="{{ $equipmentType->name }}"
            class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            required>
        <option value="" disabled selected>انتخاب کنید</option>
        @if(isset($itemCollection))
            @foreach($itemCollection as $item)
                @php
                    $equipmentInfo = $firstKey::with('brandInfo')->whereId($item->id)->first()->toArray();
                @endphp

                {{ isset($keyIndex) ? $translatedArray[$keyIndex] : '' }} = {{ @$equipmentInfo['brand_info']['name'] }}

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

                <option value="{{ $item->id }}" @if(old($equipmentType->name)==$item->id) selected @endif>
                    {{ @$item->brandInfo->name }} -
                    @foreach(translateKeysToPersian($equipmentInfo) as $key => $value)
                        @if($key == 'برند')
                            @continue
                        @endif
                        {{ $key }}: {{ $value }}
                        @if (!$loop->last)
                            -
                        @endif
                    @endforeach
                </option>
            @endforeach
        @endif
    </select>
</div>
