@if (session()->has('success'))
    <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md mb-2"
         role="alert">
        <div class="flex">
            <div class="py-1 ml-2">
                <i style="font-size: 24px" class="las la-check-circle"></i>
            </div>
            <div>
                <p class="font-bold mt-1">{{ session()->get('success') }}</p>
            </div>
        </div>
    </div>
@endif
