@php
    $equipmentInfo=json_decode($equipment->info,true);
@endphp
<div>
    <label for="book"
           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $equipment->equipmentType->persian_name }} </label>
    <select name="book"
            class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            required>
        <option value="" disabled selected>انتخاب کنید</option>
        @foreach($items[App\Models\TechnicalFacilities\Book::class] as $book)
            <option value="{{ $book->id }}"
                    @if($equipmentInfo['book']==$book->id) selected @endif>
                {{ $book->name}} - {{ $book->publicationInfo->name}} - {{ $book->subjectInfo->name}} - {{ $book->writer}} - {{ $book->size}}</option>
        @endforeach
    </select>
</div>
