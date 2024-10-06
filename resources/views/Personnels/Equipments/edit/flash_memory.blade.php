@php
    $equipmentInfo=json_decode($equipment->info,true);
@endphp
<div>
    <label for="flash_memory"
           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $equipment->equipmentType->persian_name }} </label>
    <select name="flash_memory"
            class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            required>
        <option value="" disabled selected>انتخاب کنید</option>
        @foreach($flash_memories as $flash_memory)
            <option value="{{ $flash_memory->id }}"
                    @if($equipmentInfo['flash_memory']==$flash_memory->id) selected @endif>{{ $flash_memory->brandInfo->name}}
                - {{ $flash_memory->model}} - {{ $flash_memory->capacity}}</option>
        @endforeach
    </select>
</div>
