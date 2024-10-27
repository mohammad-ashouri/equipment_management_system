@props(['audios'])
<div class="bg-white mt-10 rounded shadow flex flex-col p-4">
    <h3 class="font-bold mb-5">صوت ها</h3>
    <div class="w-full grid grid-cols-2" id="audioContainer">
        @if($audios)
            @foreach($audios as $index=>$audio)
                <div class="">
                    <div class=" mb-4">
                        <div class="mr-3">
                            <label for="id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">عنوان</label>
                            <input type="text" id="saved_audios_title" name="saved_audios_title[]" value="{{ $audio['title'] }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="عنوان صوت را وارد کنید" required>
                        </div>
                        <div class="mr-3">
                            <label for="id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                صوت {{ $index+1 }}</label>
                            <audio controls class="w-full mb-4" preload="none">
                                <source src="{{ $audio['path'] }}" type="audio/mpeg">
                                Your browser does not support the audio element.
                            </audio>
                            <input value="{{ $audio['path'] }}" name="saved_audios_link[]" type="hidden">
                        </div>
                        <div class="mr-3 mt-7">
                            <button type="button"
                                    class="remove-audio-row bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                حذف
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
            <script>
                $(document).ready(function () {
                    let removeButtons = document.getElementsByClassName('remove-audio-row');
                    for (let i = 0; i < removeButtons.length; i++) {
                        removeButtons[i].addEventListener('click', function () {
                            this.parentElement.parentElement.remove();
                        });
                    }
                });
            </script>
        @endif
    </div>
    <div class="text-center">
        <button id="new_audio" type="button"
                class="mt-3 w-96 inline-flex justify-center px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-green-300 sm:mt-0 sm:w-auto">
            صوت جدید
        </button>
    </div>
</div>


<script>
    document.getElementById('new_audio').addEventListener('click', function () {
        let newInput = `
<div class="flex mb-4">
    <div class="mr-3">
        <label for="id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">عنوان</label>
        <input type="text" id="audios_title" name="audios_title[]" value=""
               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-48 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
               placeholder="عنوان صوت را وارد کنید" required>
    </div>
    <div class="mr-3">
        <label for="id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">انتخاب صوت</label>
        <input type="file" id="audios_link" name="audios_link[]" value="" accept=".mp3,.ogg,.wav,.aac"
               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
               placeholder="صوت را انتخاب کنید" required>
    </div>
    <div class="mr-3 mt-7">
                <button type="button" class="remove-audio-row bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    حذف
                </button>
            </div>
</div> `;
        document.getElementById('audioContainer').insertAdjacentHTML('beforeend', newInput);
        let removeButtons = document.getElementsByClassName('remove-audio-row');
        for (let i = 0; i < removeButtons.length; i++) {
            removeButtons[i].addEventListener('click', function () {
                this.parentElement.parentElement.remove();
            });
        }
    });
</script>
