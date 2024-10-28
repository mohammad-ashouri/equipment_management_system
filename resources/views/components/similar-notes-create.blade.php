<div class="bg-white mt-10 rounded shadow flex flex-col p-4">
    <h3 class="font-bold mb-5">یادداشت های مرتبط (پس از وارد نمودن کد یادداشت، کلید ctrl را فشار داده و منتظر پاسخ سرور
        باشید. در صورتی که یادداشت شما یافت شود، نام یادداشت در مقابل ورودی نمایش داده خواهد شد)</h3>
    <div class="grid gap-6 mb-6 md:grid-cols-1" id="notesContainer">
        <div>
            @if(old('notes'))
                @foreach(old('notes') as $index => $note)
                    <div class="flex">
                        <div class="">
                            <label for="notes{{ $index }}"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">کد یادداشت
                            </label>
                            <input type="text" id="notes{{ $index }}" name="notes[]"
                                   value="{{ $note }}" @keyup.ctrl="retrievePosts($event.target.value)"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="کد یادداشت مربوطه را وارد نموده و ctrl را فشار دهید"
                                   required>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    <div class="text-center">
        <button id="new_note" type="button"
                class="mt-3 w-96 inline-flex justify-center px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-green-300 sm:mt-0 sm:w-auto">
            یادداشت جدید
        </button>
    </div>
</div>

<script>
    document.getElementById('new_note').addEventListener('click', function () {
        let uniqueId = `notes_${Date.now()}`;
        let newInput = `
<div class="flex" x-data="{
        subject: {},
        posts: [],
        title: '',

        async retrievePosts(value) {
            loaderSpinner(); // Show loader
            try {
                let response = await fetch(\`/Notes/\${value}\`);
                if (response.ok) {
                    let data = await response.json();
                    this.title = data.title ? 'عنوان یادداشت: '+data.title : 'یادداشت پیدا نشد';
                } else {
                    this.title = 'یادداشت پیدا نشد';
                    console.error('Error fetching posts:', response.statusText);
                }
            } catch (error) {
                this.title = 'یادداشت پیدا نشد';
                console.error('Error fetching posts:', error);
            }finally {
                loaderSpinner(false); // Hide loader
            }
        }
    }" x-init>
    <label for="${uniqueId}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">کد یادداشت</label>
    <input type="text" id="${uniqueId}" name="notes[]"
           @keyup.ctrl="retrievePosts($event.target.value)"
           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/4 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
           placeholder="کد یادداشت مربوطه را وارد نموده و ctrl را فشار دهید"
           required>
    <span x-text="title" class="mr-4 text-gray-900 dark:text-white"></span>
</div>
`;
        document.getElementById('notesContainer').insertAdjacentHTML('beforeend', newInput);
        // Initialize Alpine.js for dynamically added content
        Alpine.initTree(document.querySelector(`#${uniqueId}`).closest('[x-data]'));
    });
</script>
