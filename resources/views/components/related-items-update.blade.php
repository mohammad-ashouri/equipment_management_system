<div class="bg-white mt-10 rounded shadow flex flex-col p-4">
    <h3 class="font-bold mb-5">موارد مرتبط</h3>
    <div class="grid gap-6 mb-6 md:grid-cols-1" id="relatedItemsContainer">
        <div>
            @if(!empty($relatedItems->related_items))
                @foreach(json_decode($relatedItems->related_items, true) as $index => $relatedItem)
                    <div class="flex">
                        <div class="">
                            <label for="related_items{{ $index }}"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">عنوان</label>
                            <input type="text" id="related_items{{ $index }}" name="related_items[]"
                                   value="{{ $relatedItem['related_item'] }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-96 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="عنوان مورد مرتبط را وارد کنید"
                                   required>
                        </div>
                        <div class="mr-3">
                            <label for="post_type{{ $index }}"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">نوع</label>
                            <select id="post_type{{ $index }}" name="post_types[]"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-96 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                <option value="" disabled selected>انتخاب کنید</option>
                                @foreach($postTypes as $postType)
                                    <option
                                        value="{{ $postType->id }}" {{ $relatedItem['post_type'] == $postType->id ? 'selected' : '' }}>
                                        {{ $postType->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mr-3">
                            <label for="link{{ $index }}"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">لینک</label>
                            <input type="text" id="link{{ $index }}" name="links[]"
                                   value="{{ $relatedItem['link'] ?? '' }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-96 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="لینک ارجاع مورد مرتبط را وارد کنید"
                                   required>
                        </div>
                        <div class="mr-3 mt-7">
                            <button type="button"
                                    class="remove-row bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                حذف
                            </button>
                        </div>
                    </div>
                @endforeach
                <script>
                    let removeButtons = document.getElementsByClassName('remove-row');
                    for (let i = 0; i < removeButtons.length; i++) {
                        removeButtons[i].addEventListener('click', function () {
                            this.parentElement.parentElement.remove();
                        });
                    }
                </script>
            @endif
        </div>
    </div>
    <div class="text-center">
        <button id="new_related_item" type="button"
                class="mt-3 w-96 inline-flex justify-center px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-green-300 sm:mt-0 sm:w-auto">
            مورد جدید
        </button>
    </div>
</div>

<script>
    document.getElementById('new_related_item').addEventListener('click', function () {
        let newInput = `
        <div class="flex">
            <div class="">
                <label for="" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">عنوان</label>
                <input type="text" id="related_item0" name="related_items[]" value=""
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-96 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                       placeholder="عنوان مورد مرتبط را وارد کنید" required>
            </div>
            <div class="mr-3">
                <label for="post_type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">نوع</label>
                <select name="post_types[]"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-96 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        required>
                    <option value="" disabled selected>انتخاب کنید</option>
                    @foreach($postTypes as $postType)
        <option value="{{ $postType->id }}">
                            {{ $postType->title }}
        </option>
@endforeach
        </select>
    </div>
    <div class="mr-3">
        <label for="link" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">لینک</label>
        <input type="text" id="link" name="links[]" value=""
               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-96 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
               placeholder="لینک ارجاع مورد مرتبط را وارد کنید" required>
    </div>
    <div class="mr-3 mt-7">
                <button type="button" class="remove-row bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    حذف
                </button>
            </div>
</div>`;
        document.getElementById('relatedItemsContainer').insertAdjacentHTML('beforeend', newInput);
        let removeButtons = document.getElementsByClassName('remove-row');
        for (let i = 0; i < removeButtons.length; i++) {
            removeButtons[i].addEventListener('click', function () {
                this.parentElement.parentElement.remove();
            });
        }
    });
</script>
