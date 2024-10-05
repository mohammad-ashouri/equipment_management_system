@php
    $equipmentInfo=json_decode($equipment->info,true);
@endphp
<div>
    <label for="attendance_system"
           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $equipment->equipmentType->persian_name }} </label>
    <select name="attendance_system"
            class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            required>
        <option value="" disabled selected>انتخاب کنید</option>
        @foreach($attendanceSystems as $attendanceSystem)
            <option value="{{ $attendanceSystem->id }}"
                    @if($equipmentInfo['attendance_system']==$attendanceSystem->id) selected @endif>{{ $attendanceSystem->brandInfo->name}}
                - {{ $attendanceSystem->model}} - {{ $attendanceSystem->type}}</option>
        @endforeach
    </select>
</div>
