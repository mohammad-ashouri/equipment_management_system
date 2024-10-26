<div>
    <label for="laptop"
           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">لپ تاپ </label>
    <select name="laptop"
            class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            required>
        <option value="" disabled selected>انتخاب کنید</option>
        @foreach($items[App\Models\DigitalEquipments\Laptop::class] as $laptop)
            <option value="{{ $laptop->id }}"
                    @if(old('laptop')==$laptop->id) selected @endif>{{ $laptop->brandInfo->name}}
                - {{ $laptop->model}} - سایز مانیتور: {{ $laptop->cpuInfo->brandInfo->name }} {{ $laptop->cpuInfo->model }} - نسل: {{ $laptop->generation }}  - پردازنده: {{ $laptop->graphicCardInfo->brandInfo->name }} {{ $laptop->graphicCardInfo->model }} - سایز رم: {{ $laptop->ram_size }}  - کارت گرافیک: {{ $laptop->monitor_size}}  - درایو نوری: {{ $laptop->odd}} </option>
        @endforeach
    </select>
</div>
<div>
    <div class="ram-container mx-auto p-4">
        <div id="ram-select-container">
            <div class="mt-2 ram-select-wrapper">
                <div class="flex">
                    <div class="w-full">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">رم 1</label>
                        <select name="ram[]" required
                                class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="" disabled selected>انتخاب کنید</option>
                            @foreach($items[App\Models\HardwareEquipments\Ram::class] as $ram)
                                <option value="{{ $ram->id }}"
                                        @if(old('ram1')==$ram->id) selected @endif>{{ $ram->brandInfo->name}}
                                    - {{ $ram->model}}
                                    - {{ $ram->type }} - {{ $ram->size }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center">
            <button type="button" id="add-ram-select" class="mt-4 bg-blue-500 text-white p-2 rounded">افزودن رم جدید
            </button>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // افزودن رم جدید
            $('#add-ram-select').on('click', function () {
                const selectContainer = document.getElementById('ram-select-container');
                const selectWrappers = selectContainer.getElementsByClassName('ram-select-wrapper');
                const newIndex = selectWrappers.length + 1;

                const newSelectWrapper = document.createElement('div');
                newSelectWrapper.classList.add('mt-2', 'ram-select-wrapper');

                const newFlexDiv = document.createElement('div');
                newFlexDiv.classList.add('flex');

                const newLabelDiv = document.createElement('div');
                newLabelDiv.classList.add('w-full');

                const newLabel = document.createElement('label');
                newLabel.classList.add('block', 'mb-2', 'text-sm', 'font-medium', 'text-gray-900', 'dark:text-white');
                newLabel.innerText = 'رم ' + newIndex;

                const newSelect = document.createElement('select');
                newSelect.name = 'ram[]';
                newSelect.classList.add('select2', 'bg-gray-50', 'border', 'border-gray-300', 'text-gray-900', 'text-sm', 'rounded-lg', 'focus:ring-blue-500', 'focus:border-blue-500', 'block', 'w-full', 'p-3', 'dark:bg-gray-700', 'dark:border-gray-600', 'dark:placeholder-gray-400', 'dark:text-white', 'dark:focus:ring-blue-500', 'dark:focus:border-blue-500');

                // Copy options from the first select
                const firstSelect = selectWrappers[0].getElementsByTagName('select')[0];
                Array.from(firstSelect.options).forEach(option => {
                    const newOption = document.createElement('option');
                    newOption.value = option.value;
                    newOption.text = option.text;
                    newSelect.appendChild(newOption);
                });

                // دکمه حذف
                const removeButtonDiv = document.createElement('div');
                removeButtonDiv.classList.add('mt-5', 'mr-2');

                const removeButton = document.createElement('button');
                removeButton.type = 'button';
                removeButton.classList.add('remove-ram', 'bg-red-500', 'text-white', 'p-1', 'rounded', 'mt-2');
                removeButton.innerText = 'حذف';

                removeButtonDiv.appendChild(removeButton);

                // افزودن المان‌ها به FlexDiv
                newLabelDiv.appendChild(newLabel);
                newLabelDiv.appendChild(newSelect);
                newFlexDiv.appendChild(newLabelDiv);
                newFlexDiv.appendChild(removeButtonDiv);

                // افزودن FlexDiv به selectWrapper
                newSelectWrapper.appendChild(newFlexDiv);
                selectContainer.appendChild(newSelectWrapper);

                // Re-initialize select2 on new select elements
                $(newSelect).select2();
            });

        });
    </script>
</div>
<div>
    <div class="internalHardDisk-container mx-auto p-4">
        <div id="internalHardDisk-select-container">
            <div class="w-full grid grid-cols-3 mt-2 internalHardDisk-select-wrapper">
                <div class="w-full">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">هارد </label>
                    <select name="internalHardDisk[]" required
                            class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="" disabled selected>انتخاب کنید</option>
                        @foreach($items[App\Models\HardwareEquipments\InternalHardDisk::class] as $internalHard)
                            <option value="{{ $internalHard->id }}"
                                    @if(old('internalHardDisk')==$internalHard->id) selected @endif>{{ $internalHard->brandInfo->name}}
                                - {{ $internalHard->model}} - {{ $internalHard->capacity }}
                                - {{ $internalHard->connectivity_type }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mr-2 w-full">
                    <label for=""
                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">کد اموال هارد </label>
                    <input type="text" name="internalHardDisk_property_code[]"
                           value="{{ old('internalHardDisk_property_code') }}"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                           placeholder="">
                </div>
            </div>
        </div>
        <div class="text-center">
            <button type="button" id="add-internalHardDisk-select" class="mt-4 bg-blue-500 text-white p-2 rounded">
                افزودن هارد جدید
            </button>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // افزودن هارد جدید
            $('#add-internalHardDisk-select').on('click', function () {
                const selectContainer = document.getElementById('internalHardDisk-select-container');
                const selectWrappers = selectContainer.getElementsByClassName('internalHardDisk-select-wrapper');
                const newIndex = selectWrappers.length + 1;

                const newSelectWrapper = document.createElement('div');
                newSelectWrapper.classList.add('w-full', 'grid', 'grid-cols-3', 'mt-2', 'internalHardDisk-select-wrapper');

                // ساخت المان Select برای انتخاب هارد جدید
                const newSelectDiv = document.createElement('div');
                newSelectDiv.classList.add('w-full');

                const newLabel = document.createElement('label');
                newLabel.classList.add('block', 'mb-2', 'text-sm', 'font-medium', 'text-gray-900', 'dark:text-white');
                newLabel.innerText = 'هارد ';

                const newSelect = document.createElement('select');
                newSelect.name = 'internalHardDisk[]';
                newSelect.required = true;
                newSelect.classList.add('select2', 'bg-gray-50', 'border', 'border-gray-300', 'text-gray-900', 'text-sm', 'rounded-lg', 'focus:ring-blue-500', 'focus:border-blue-500', 'block', 'w-full', 'p-3', 'dark:bg-gray-700', 'dark:border-gray-600', 'dark:placeholder-gray-400', 'dark:text-white', 'dark:focus:ring-blue-500', 'dark:focus:border-blue-500');

                // کپی کردن گزینه‌های موجود از اولین Select
                const firstSelect = selectWrappers[0].getElementsByTagName('select')[0];
                Array.from(firstSelect.options).forEach(option => {
                    const newOption = document.createElement('option');
                    newOption.value = option.value;
                    newOption.text = option.text;
                    newSelect.appendChild(newOption);
                });

                newSelectDiv.appendChild(newLabel);
                newSelectDiv.appendChild(newSelect);

                // ساخت المان Input برای وارد کردن کد اموال
                const newInputDiv = document.createElement('div');
                newInputDiv.classList.add('mr-2', 'w-full');

                const newInputLabel = document.createElement('label');
                newInputLabel.classList.add('block', 'mb-2', 'text-sm', 'font-medium', 'text-gray-900', 'dark:text-white');
                newInputLabel.innerText = 'کد اموال هارد ';

                const newInput = document.createElement('input');
                newInput.type = 'text';
                newInput.name = 'internalHardDisk_property_code[]';
                newInput.classList.add('bg-gray-50', 'border', 'border-gray-300', 'text-gray-900', 'text-sm', 'rounded-lg', 'focus:ring-blue-500', 'focus:border-blue-500', 'block', 'w-full', 'p-2', 'dark:bg-gray-700', 'dark:border-gray-600', 'dark:placeholder-gray-400', 'dark:text-white', 'dark:focus:ring-blue-500', 'dark:focus:border-blue-500');
                newInput.placeholder = '';

                newInputDiv.appendChild(newInputLabel);
                newInputDiv.appendChild(newInput);

                // ساخت دکمه حذف
                const newRemoveDiv = document.createElement('div');
                newRemoveDiv.classList.add('mt-5', 'mr-4');

                const newRemoveButton = document.createElement('button');
                newRemoveButton.type = 'button';
                newRemoveButton.classList.add('remove-internalHardDisk', 'bg-red-500', 'text-white', 'p-2', 'rounded', 'mt-2');
                newRemoveButton.innerText = 'حذف';

                newRemoveDiv.appendChild(newRemoveButton);

                // اضافه کردن همه بخش‌ها به wrapper جدید
                newSelectWrapper.appendChild(newSelectDiv);
                newSelectWrapper.appendChild(newInputDiv);
                newSelectWrapper.appendChild(newRemoveDiv);

                selectContainer.appendChild(newSelectWrapper);

                // اعمال دوباره select2 برای المان‌های جدید
                $(newSelect).select2();
            });

        });
    </script>
</div>
