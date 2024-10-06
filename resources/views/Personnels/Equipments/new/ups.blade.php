<div>
    <label for="ups"
           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $equipmentType->persian_name }}</label>
    <select name="ups"
            class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            required>
        <option value="" disabled selected>انتخاب کنید</option>
        @foreach($ups as $ups1)
            <option value="{{ $ups1->id }}"
                    @if(old('ups')==$ups1->id) selected @endif>{{ $ups1->brandInfo->name}}
                - {{ $ups1->model}} - {{ $ups1->capacity}}</option>
        @endforeach
    </select>
</div>
