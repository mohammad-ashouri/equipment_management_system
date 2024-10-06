@php
    $equipmentInfo=json_decode($equipment->info,true);
@endphp
<div>
    <label for="sound_card"
           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $equipment->equipmentType->persian_name }} </label>
    <select name="sound_card"
            class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            required>
        <option value="" disabled selected>انتخاب کنید</option>
        @foreach($soundCards as $soundCard)
            <option value="{{ $soundCard->id }}"
                    @if($equipmentInfo['sound_card']==$soundCard->id) selected @endif>{{ $soundCard->brandInfo->name}}
                - {{ $soundCard->model}} - {{ $soundCard->connectivity_type}}</option>
        @endforeach
    </select>
</div>
