<div>
    <label for="chair"
           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $equipmentType->persian_name }}</label>
    <select name="chair"
            class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            required>
        <option value="" disabled selected>انتخاب کنید</option>
        @foreach($chairs as $chair)
            <option value="{{ $chair->id }}"
                    @if(old('chair')==$chair->id) selected @endif>{{ $chair->brandInfo->name}}
                - {{ $chair->model}} - {{ $chair->material}} - {{ $chair->desktop_type}}</option>
        @endforeach
    </select>
</div>
