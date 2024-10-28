@props(['contactUsCount'])
<div class="mx-auto mt-7 lg:mr-72">
    <div class="alert drtl alert-info">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <div>
            <h3 class="font-bold text-right">پیام جدید</h3>
            <div class="text-x">شما {{ $contactUsCount }} پیام خوانده نشده دارید.
            <a href="{{ route('ContactUs.index') }}">نمایش پیام ها</a>
            </div>
        </div>
    </div>
</div>
