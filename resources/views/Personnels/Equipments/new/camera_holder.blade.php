<div>
    <label for="camera_holder"
           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $equipmentType->persian_name }}</label>
    <select name="camera_holder"
            class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            required>
        <option value="" disabled selected>انتخاب کنید</option>
        @foreach($camera_holders as $camera_holder)
            <option value="{{ $camera_holder->id }}"
                    @if(old('camera_holder')==$camera_holder->id) selected @endif>{{ $camera_holder->brandInfo->name}}
                - {{ $camera_holder->model}} - {{ $camera_holder->type}} - {{ $camera_holder->head_type}} - تعداد قطعات پایه:  {{ $camera_holder->parts_number}}</option>
        @endforeach
    </select>
</div>
