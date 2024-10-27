<div class="bg-white mt-10 rounded shadow flex flex-col p-4">
    <h3 class="font-bold mb-5">سوژه های مرتبط (پس از وارد نمودن کد سوژه پژوهشی، کلید ctrl را فشار داده و منتظر پاسخ سرور
        باشید. در صورتی که سوژه شما یافت شود، نام سوژه در مقابل ورودی نمایش داده خواهد شد)</h3>
    <div class="grid gap-6 mb-6 md:grid-cols-1" id="researchSubjectsContainer">
        <div>
            @if(old('research_subjects'))
                @foreach(old('research_subjects') as $index => $researchSubject)
                    <div class="flex">
                        <div class="">
                            <label for="research_subjects{{ $index }}"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">کد سوژه
                                پژوهشی</label>
                            <input type="text" id="research_subjects{{ $index }}" name="research_subjects[]"
                                   value="{{ $researchSubject }}" @keyup.ctrl="retrievePosts($event.target.value)"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="کد سوژه پژوهشی مربوطه را وارد نموده و ctrl را فشار دهید"
                                   required>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    <div class="text-center">
        <button id="new_research_subject" type="button"
                class="mt-3 w-96 inline-flex justify-center px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-green-300 sm:mt-0 sm:w-auto">
            سوژه جدید
        </button>
    </div>
</div>

<script>
    document.getElementById('new_research_subject').addEventListener('click', function () {
        let uniqueId = `research_subjects_${Date.now()}`;
        let newInput = `
<div class="flex" x-data="{
        subject: {},
        posts: [],
        title: '',

        async retrievePosts(value) {
            loaderSpinner(); // Show loader
            try {
                let response = await fetch(\`/ResearchSubjects/\${value}\`);
                if (response.ok) {
                    let data = await response.json();
                    this.title = data.title ? 'عنوان سوژه: '+data.title : 'سوژه پیدا نشد';
                } else {
                    this.title = 'سوژه پیدا نشد';
                    console.error('Error fetching posts:', response.statusText);
                }
            } catch (error) {
                this.title = 'سوژه پیدا نشد';
                console.error('Error fetching posts:', error);
            }finally {
                loaderSpinner(false); // Hide loader
            }
        }
    }" x-init>
    <label for="${uniqueId}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">کد سوژه پژوهشی</label>
    <input type="text" id="${uniqueId}" name="research_subjects[]"
           @keyup.ctrl="retrievePosts($event.target.value)"
           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/4 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
           placeholder="کد سوژه پژوهشی مربوطه را وارد نموده و ctrl را فشار دهید"
           required>
    <span x-text="title" class="mr-4 text-gray-900 dark:text-white"></span>
</div>
`;
        document.getElementById('researchSubjectsContainer').insertAdjacentHTML('beforeend', newInput);
        // Initialize Alpine.js for dynamically added content
        Alpine.initTree(document.querySelector(`#${uniqueId}`).closest('[x-data]'));
    });
</script>
