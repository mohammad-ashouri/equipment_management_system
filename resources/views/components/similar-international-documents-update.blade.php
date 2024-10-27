@php use App\Models\InternationalDocument;use App\Models\MediaSubject; @endphp
<div class="bg-white mt-10 rounded shadow flex flex-col p-4">
    <h3 class="font-bold mb-5">سند های مرتبط</h3>
    <div class="grid gap-6 mb-6 md:grid-cols-1" id="internationalDocumentsContainer">
        <div>
            @if(!empty($internationalDocuments))
                @foreach($internationalDocuments as $index => $internationalDocument)
                    <div class="flex" x-data="{
        subject: {},
        posts: [],

        async retrievePosts(value) {
            try {
                let response = await fetch(`/InternationalDocuments/${value}`);
                if (response.ok) {
                    let data = await response.json();
                    this.title = data.title ? 'عنوان سند: ' + data.title : 'سند پیدا نشد';
                } else {
                    this.title = 'سند پیدا نشد';
                    console.error('Error fetching posts:', response.statusText);
                }
            } catch (error) {
                this.title = 'سند پیدا نشد';
                console.error('Error fetching posts:', error);
            }
        }
    }">
                        <div class="flex w-full">
                            <label for="similar_documents{{ $index }}"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">کد سند
                            </label>
                            <input type="text" id="similar_documents{{ $index }}" name="similar_documents[]"
                                   value="{{ $internationalDocument->id }}"
                                   @keyup.ctrl="retrievePosts($event.target.value)"
                                   class="bg-gray-50 border border-gray-300 mb-3 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-48 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="کد سند مربوطه را وارد نموده و ctrl را فشار دهید"
                                   required>
                            <span
                                class="mr-4 text-gray-900 dark:text-white">@php $documentTitle=InternationalDocument::whereId($internationalDocument->id)->first(); @endphp {{ $documentTitle->title }}</span>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    <div class="text-center">
        <button id="new_similar_document" type="button"
                class="mt-3 w-96 inline-flex justify-center px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-green-300 sm:mt-0 sm:w-auto">
            سند جدید
        </button>
    </div>
</div>

<script>
    document.getElementById('new_similar_document').addEventListener('click', function () {
        let uniqueId = `similar_documents_${Date.now()}`;
        let newInput = `
<div class="flex" x-data="{
        subject: {},
        posts: [],
        title: '',
        async retrievePosts(value) {
            loaderSpinner(); // Show loader
            try {
                let response = await fetch(\`/InternationalDocuments/\${value}\`);
                if (response.ok) {
                    let data = await response.json();
                    this.title = data.title ? 'عنوان سند: '+data.title : 'سند پیدا نشد';
                } else {
                    this.title = 'سند پیدا نشد';
                    console.error('Error fetching posts:', response.statusText);
                }
            } catch (error) {
                this.title = 'سند پیدا نشد';
                console.error('Error fetching posts:', error);
            }finally {
                loaderSpinner(false); // Hide loader
            }
        }
    }" x-init>
    <label for="${uniqueId}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">کد سند</label>
    <input type="text" id="${uniqueId}" name="similar_documents[]"
           @keyup.ctrl="retrievePosts($event.target.value)"
           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/4 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
           placeholder="کد سند مربوطه را وارد نموده و ctrl را فشار دهید"
           required>
    <span x-text="title" class="mr-4 text-gray-900 dark:text-white"></span>
</div>
`;
        document.getElementById('internationalDocumentsContainer').insertAdjacentHTML('beforeend', newInput);
        // Initialize Alpine.js for dynamically added content
        Alpine.initTree(document.querySelector(`#${uniqueId}`).closest('[x-data]'));
    });
</script>
