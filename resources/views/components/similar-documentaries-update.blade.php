@php use App\Models\Documentary; @endphp
@props(['documentaries'])
<div class="bg-white mt-10 rounded shadow flex flex-col p-4">
    <h3 class="font-bold mb-5">مستند های مرتبط</h3>
    <div class="grid gap-6 mb-6 md:grid-cols-1" id="documentariesContainer">
        <div>
            @if(!empty($documentaries))
                @foreach($documentaries as $index => $documentary)
                    <div class="flex" x-data="{
        subject: {},
        posts: [],

        async retrieveDocumentaries(value) {
            try {
                let response = await fetch(`/Documentaries/${value}`);
                if (response.ok) {
                    let data = await response.json();
                    this.title = data.title ? 'عنوان مستند: ' + data.title : 'مستند پیدا نشد';
                } else {
                    this.title = 'مستند پیدا نشد';
                    console.error('Error fetching posts:', response.statusText);
                }
            } catch (error) {
                this.title = 'مستند پیدا نشد';
                console.error('Error fetching posts:', error);
            }
        }
    }">
                        <label for="documentaries{{ $index }}"
                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">کد مستند
                        </label>
                        <input type="text" id="documentaries{{ $index }}" name="documentaries[]"
                               value="{{ $documentary->id }}" @keyup.ctrl="retrieveDocumentaries($event.target.value)"
                               class="bg-gray-50 border border-gray-300 mb-3 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-48 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                               placeholder="کد مستند مربوطه را وارد نموده و ctrl را فشار دهید"
                               required>
                        <span
                            class="mr-4 text-gray-900 dark:text-white">@php $documentaryTitle=Documentary::whereId($documentary->id)->first(); @endphp {{ $documentaryTitle->title }}</span>
                        <div class="mr-3 ">
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
        <button id="new_documentaries" type="button"
                class="mt-3 w-96 inline-flex justify-center px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-green-300 sm:mt-0 sm:w-auto">
            مستند جدید
        </button>
    </div>
</div>

<script>
    document.getElementById('new_documentaries').addEventListener('click', function () {
        let uniqueId = `documentaries_${Date.now()}`;
        let newInput = `
<div class="flex" x-data="{
        subject: {},
        posts: [],
        title: '',
        async retrieveDocumentaries(value) {
            loaderSpinner(); // Show loader
            try {
                let response = await fetch(\`/Documentaries/\${value}\`);
                if (response.ok) {
                    let data = await response.json();
                    this.title = data.title ? 'عنوان مستند: '+data.title : 'مستند پیدا نشد';
                } else {
                    this.title = 'مستند پیدا نشد';
                    console.error('Error fetching posts:', response.statusText);
                }
            } catch (error) {
                this.title = 'مستند پیدا نشد';
                console.error('Error fetching posts:', error);
            }finally {
                loaderSpinner(false); // Hide loader
            }
        }
    }" x-init>
<div class="flex w-full">
    <label for="${uniqueId}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">کد مستند</label>
    <input type="text" id="${uniqueId}" name="documentaries[]"
           @keyup.ctrl="retrieveDocumentaries($event.target.value)"
           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/4 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
           placeholder="کد مستند مربوطه را وارد نموده و ctrl را فشار دهید"
           required>
    <span x-text="title" class="mr-4 text-gray-900 dark:text-white"></span>
                <button type="button" class="remove-row bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    حذف
                </button>
            </div>
</div>
`;
        document.getElementById('documentariesContainer').insertAdjacentHTML('beforeend', newInput);
        // Initialize Alpine.js for dynamically added content
        Alpine.initTree(document.querySelector(`#${uniqueId}`).closest('[x-data]'));
        let removeButtons = document.getElementsByClassName('remove-row');
        for (let i = 0; i < removeButtons.length; i++) {
            removeButtons[i].addEventListener('click', function () {
                this.parentElement.parentElement.remove();
            });
        }
    });
</script>
