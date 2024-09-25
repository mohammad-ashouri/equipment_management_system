<div>
    <label for="tablet"
           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $equipmentType->persian_name }}</label>
    <select name="tablet"
            class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            required>
        <option value="" disabled selected>انتخاب کنید</option>
        @foreach($tablets as $tablet)
            <option value="{{ $tablet->id }}"
                    @if(old('tablet')==$tablet->id) selected @endif>{{ $tablet->brandInfo->name}}
                - {{ $tablet->model}} - مقدار رم: {{ $tablet->ram}} - حافظه داخلی: {{ $tablet->capacity}} - تعداد سیمکارت: {{ $tablet->simcards_number}}</option>
        @endforeach
    </select>
</div>
