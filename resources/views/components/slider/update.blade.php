@props(['image'])
<div class="bg-white mt-10 rounded shadow flex flex-col p-4">
    <div class="grid gap-6 mb-6 md:grid-cols-2">
        <div>
            <label for="slider"
                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">نمایش در
                اسلایدر</label>
            <select name="slider" id="slider"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    required>
                <option selected value="0">خیر</option>
                <option value="1" {{ !empty($image) ? 'selected' : ''}}>بله</option>
            </select>
        </div>
        <div class="{{ !empty($image) ? '' : 'hidden'}} slider-image">
            <label for="slider_image"
                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">انتخاب کنید
            </label>
            <input type="file" id="slider_image" name="slider_image" accept=".jpg,.bmp,.jpeg,.svg,.png"
                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        </div>
        @if(!empty($image))
            <div class="{{ !empty($image) ? '' : 'hidden'}} slider-image-show">
                <img class=" h-96 rounded border border-black other-image cursor-pointer"
                     title="برای بزرگنمایی کلیک کنید"
                     data-id="{{$image->id}}"
                     onclick="openModal('{{ env('APP_URL') . $image->src }}')"
                     src="{{env('APP_URL').$image->src}}" alt="تصویر یافت نشد!">
            </div>
        @endif
    </div>
</div>
