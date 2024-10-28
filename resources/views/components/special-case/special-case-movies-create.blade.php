@props(['old'])
<div class="bg-white mt-10 rounded shadow flex flex-col p-4">
    <h3 class="font-bold mb-5">فیلم ها</h3>
    <div class="grid grid-cols-3" id="movieContainer">
        @if($old)
            @foreach($old as $index=>$movies)
                <div>
                    <div class="flex mb-4">
                        <div class="mr-3">
                            <label for="id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">کد آپارات فیلم مربوطه</label>
                            <input type="text" id="movies{{ $index }}" name="movies[]"
                                   value="{{ old('movies')[$index] ?? '' }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-48 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="کد آپارات فیلم را وارد کنید" >
                        </div>
                        <div class="mr-3 mt-7">
                            <button type="button"
                                    class="remove-movie-row bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                حذف
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
            <script>
                let removeButtons = document.getElementsByClassName('remove-movie-row');
                for (let i = 0; i < removeButtons.length; i++) {
                    removeButtons[i].addEventListener('click', function () {
                        this.parentElement.parentElement.remove();
                    });
                }
            </script>
        @endif
    </div>
    <div class="text-center">
        <button id="new_movie" type="button"
                class="mt-3 w-96 inline-flex justify-center px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-green-300 sm:mt-0 sm:w-auto">
            فیلم جدید
        </button>
    </div>
</div>


<script>
    document.getElementById('new_movie').addEventListener('click', function () {
        let newInput = `
<div class="flex mb-4">
    <div class="mr-3">
        <label for="id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">عنوان</label>
        <input type="text" id="movies" name="movies_title[]" value=""
               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-48 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
               placeholder="عنوان فیلم را وارد کنید" required>
    </div>
    <div class="mr-3">
        <label for="id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">کد آپارات فیلم</label>
        <input type="text" id="movies" name="movies_link[]" value=""
               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-48 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
               placeholder="کد آپارات فیلم را وارد کنید" required>
    </div>
    <div class="mr-3 mt-7">
                <button type="button" class="remove-movie-row bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    حذف
                </button>
            </div>
</div> `;
        document.getElementById('movieContainer').insertAdjacentHTML('beforeend', newInput);
        let removeButtons = document.getElementsByClassName('remove-movie-row');
        for (let i = 0; i < removeButtons.length; i++) {
            removeButtons[i].addEventListener('click', function () {
                this.parentElement.parentElement.remove();
            });
        }
    });
</script>
