<div class="bg-white mt-10 rounded shadow flex flex-col p-4">
    <div class="grid gap-6 mb-6 md:grid-cols-2">
        <div>
            <label for="slider"
                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">نمایش در
                اسلایدر</label>
            <select name="slider" id="slider"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    required>
                <option selected value="0" {{old('status')==0 ? 'selected' : ''}}>خیر</option>
                <option value="1" {{old('status')==1 ? 'selected' : ''}}>بله</option>
            </select>
        </div>
        <div class="hidden slider-image">
            <label for="slider_image"
                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">انتخاب کنید
            </label>
            <input type="file" id="slider_image" name="slider_image" accept=".jpg,.bmp,.jpeg,.svg,.png"
                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        </div>
    </div>
</div>
