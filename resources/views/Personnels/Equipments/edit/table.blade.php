@php
    $equipmentInfo=json_decode($equipment->info,true);
@endphp
<div>
    <label for="table"
           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $equipment->equipmentType->persian_name }} </label>
    <select name="table"
            class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            required>
        <option value="" disabled selected>انتخاب کنید</option>
        @foreach($tables as $table)
            <option value="{{ $table->id }}"
                    @if($equipmentInfo['table']==$table->id) selected @endif>{{ $table->brandInfo->name}}
                - {{ $table->model}} - {{ $table->material}} -
                طول: {{ $table->length}} سانتی متر -
                عرض: {{ $table->width}} سانتی متر -
                ارتفاع: {{ $table->height}} سانتی متر
            </option>
        @endforeach
    </select>
</div>
