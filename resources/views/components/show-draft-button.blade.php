@props(['route','token'])
<div>
    <a target="_blank" href="{{ env('PUBLIC_SITE_URL')."/$route/$token" }}">
        <button type="button"
                class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
            پیش نمایش
        </button>
    </a>
</div>
