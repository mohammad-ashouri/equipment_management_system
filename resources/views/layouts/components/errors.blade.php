@if (count($errors) > 0)
    <div class="bg-red-100 border-t-4 border-red-500 rounded-b text-red-900 px-4 py-3 shadow-md"
         role="alert">
        <div class="flex">
            <div class="py-1 ml-2">
                <i class="las la-exclamation-triangle"></i>
            </div>
            <div>
                @foreach ($errors->all() as $error)
                    <p class="font-bold">{{ $error }}</p>
                @endforeach
            </div>
        </div>
    </div>
@endif
