@props(['old'])
<div class="bg-white mt-10 rounded shadow flex flex-col p-4">
    <h3 class="font-bold mb-5">عکس ها</h3>
    <div class="w-full grid grid-cols-2" id="imageContainer">
        @if($old)
            @foreach($old as $index=>$images)
                <div class="">
                    <div class="flex mb-4">
                        <div class="mr-3">
                            <label for="id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">عنوان</label>
                            <input type="text" id="images_title" name="images_title[]" value="{{ old('images_title')[$index] ?? '' }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-48 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="عنوان عکس را وارد کنید" required>
                        </div>
                        <div class="mr-3">
                            <label for="id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">انتخاب
                                عکس</label>
                            <input type="file" id="images_link{{ $index }}" name="images_link[]"
                                   value="{{ old('images_link')[$index] ?? '' }}" accept=".jpeg,.png,.jpg,.gif,.svg"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="عکس را انتخاب کنید" >
                        </div>
                        <div class="mr-3 mt-7">
                            <button type="button"
                                    class="remove-image-row bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                حذف
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
            <script>
                let removeButtons = document.getElementsByClassName('remove-image-row');
                for (let i = 0; i < removeButtons.length; i++) {
                    removeButtons[i].addEventListener('click', function () {
                        this.parentElement.parentElement.remove();
                    });
                }
            </script>
        @endif
    </div>
    <div class="text-center">
        <button id="new_image" type="button"
                class="mt-3 w-96 inline-flex justify-center px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-green-300 sm:mt-0 sm:w-auto">
            عکس جدید
        </button>
    </div>
</div>


<script>
    document.getElementById('new_image').addEventListener('click', function () {
        let newInput = `
<div class="flex mb-4">
    <div class="mr-3">
        <label for="id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">عنوان</label>
        <input type="text" id="images_title" name="images_title[]" value=""
               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-48 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
               placeholder="عنوان عکس را وارد کنید" required>
    </div>
    <div class="mr-3">
        <label for="id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">انتخاب عکس</label>
        <input type="file" id="images_link" name="images_link[]" value="" accept=".jpeg,.png,.jpg,.gif,.svg"
               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
               placeholder="عکس را انتخاب کنید" >
    </div>
    <div class="mr-3 mt-7">
                <button type="button" class="remove-image-row bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    حذف
                </button>
            </div>
</div> `;
        document.getElementById('imageContainer').insertAdjacentHTML('beforeend', newInput);
        let removeButtons = document.getElementsByClassName('remove-image-row');
        for (let i = 0; i < removeButtons.length; i++) {
            removeButtons[i].addEventListener('click', function () {
                this.parentElement.parentElement.remove();
            });
        }
    });
</script>
