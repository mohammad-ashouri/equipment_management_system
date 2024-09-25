<div>
    <label for="external_hard_disk"
           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $equipmentType->persian_name }}</label>
    <select name="external_hard_disk"
            class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            required>
        <option value="" disabled selected>انتخاب کنید</option>
        @foreach($external_hard_disks as $external_hard_disk)
            <option value="{{ $external_hard_disk->id }}"
                    @if(old('external_hard_disk')==$external_hard_disk->id) selected @endif>{{ $external_hard_disk->brandInfo->name}}
                - {{ $external_hard_disk->model}} - {{ $external_hard_disk->capacity}}</option>
        @endforeach
    </select>
</div>
