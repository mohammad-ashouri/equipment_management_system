@php
    $equipmentInfo=json_decode($equipment->info,true);
@endphp
<div>
    <label for="seal_code"
           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">کد پلمپ </label>
    <input type="text" name="seal_code" value="{{ $equipmentInfo['seal_code'] }}"
           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
           placeholder="">
</div>
<div>
    <label for="case"
           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">کیس </label>
    <select name="case"
            class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            required>
        <option value="" disabled selected>انتخاب کنید</option>
        @foreach($cases as $case)
            <option value="{{ $case->id }}"
                    @if($equipmentInfo['case']==$case->id) selected @endif>{{ $case->brandInfo->name}}
                - {{ $case->model}}</option>
        @endforeach
    </select>
</div>
<div>
    <label for="power"
           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">منبع تغذیه </label>
    <select name="power"
            class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            required>
        <option value="" disabled selected>انتخاب کنید</option>
        @foreach($powers as $power)
            <option value="{{ $power->id }}"
                    @if($equipmentInfo['power']==$power->id) selected @endif>{{ $power->brandInfo->name}}
                - {{ $power->model}}
                - {{ $power->voltage}}W
            </option>
        @endforeach
    </select>
</div>
<div>
    <label for="motherboard"
           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">مادربورد </label>
    <select name="motherboard"
            class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            required>
        <option value="" disabled selected>انتخاب کنید</option>
        @foreach($motherboards as $motherboard)
            <option value="{{ $motherboard->id }}"
                    @if($equipmentInfo['motherboard']==$motherboard->id) selected @endif>{{ $motherboard->brandInfo->name}}
                - {{ $motherboard->model}}</option>
        @endforeach
    </select>
</div>
<div>
    <label for="cpu"
           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">پردازنده </label>
    <select name="cpu"
            class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            required>
        <option value="" disabled selected>انتخاب کنید</option>
        @foreach($cpus as $cpu)
            <option value="{{ $cpu->id }}"
                    @if($equipmentInfo['cpu']==$cpu->id) selected @endif>{{ $cpu->brandInfo->name}}
                - {{ $cpu->model}} {{ !empty($cpu->generation) ?? ' - نسل'.$cpu->generation }}</option>
        @endforeach
    </select>
</div>
<div>
    <label for="graphicCard"
           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">کارت گرافیک </label>
    <select name="graphicCard"
            class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        <option value="" disabled selected>انتخاب کنید</option>
        @foreach($graphicCards as $graphicCard)
            <option value="{{ $graphicCard->id }}"
                    @if($equipmentInfo['graphicCard']==$graphicCard->id) selected @endif>{{ $graphicCard->brandInfo->name}}
                - {{ $graphicCard->model}} - {{ $graphicCard->memory }}</option>
        @endforeach
    </select>
</div>
<div>
    <label for="odd"
           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">درایو نوری </label>
    <select name="odd"
            class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        <option value="" disabled selected>انتخاب کنید</option>
        @foreach($odds as $odd)
            <option value="{{ $odd->id }}"
                    @if($equipmentInfo['odd']==$odd->id) selected @endif>{{ $odd->brandInfo->name}} - {{ $odd->model}}
                - {{ $odd->connectivity_type }}</option>
        @endforeach
    </select>
</div>
<div>
    <div class="ram-container mx-auto p-4">
        <div id="ram-select-container">
            @foreach($equipmentInfo['ram'] as $index=>$ramEquipment)
                <div class="mt-2 ram-select-wrapper">
                    <label
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">رم {{ ++$index }}</label>
                    <select name="ram[]" required
                            class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="" disabled selected>انتخاب کنید</option>
                        @foreach($rams as $ram)
                            <option value="{{ $ram->id }}"
                                    @if($ramEquipment==$ram->id) selected @endif>{{ $ram->brandInfo->name}}
                                - {{ $ram->model}}
                                - {{ $ram->type }} - {{ $ram->size }}</option>
                        @endforeach
                    </select>
                </div>
            @endforeach
        </div>
        <div class="text-center">
            <button type="button" id="add-ram-select" class="mt-4 bg-blue-500 text-white p-2 rounded">افزودن رم جدید
            </button>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#add-ram-select').on('click', function () {
                const selectContainer = document.getElementById('ram-select-container');
                const selectWrappers = selectContainer.getElementsByClassName('ram-select-wrapper');
                const newIndex = selectWrappers.length + 1;

                const newSelectWrapper = document.createElement('div');
                newSelectWrapper.classList.add('mt-2', 'ram-select-wrapper');

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

                newSelectWrapper.appendChild(newLabel);
                newSelectWrapper.appendChild(newSelect);
                selectContainer.appendChild(newSelectWrapper);

                // Re-initialize select2 on new select elements
                $(newSelect).select2();
            });
        });
    </script>
</div>
<div>
    <div class="hdd-container mx-auto p-4">
        <div id="hdd-select-container">
            @foreach($equipmentInfo['hdd'] as $index=>$hddEquipment)
                <div class="grid grid-cols-2 mt-2 hdd-select-wrapper">
                    <div class="hdd-select-wrapper">
                        <label
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">هارد {{++$index}}</label>
                        <select name="hdd[]" required
                                class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="" disabled selected>انتخاب کنید</option>
                            @foreach($internalHards as $internalHard)
                                <option value="{{ $internalHard->id }}"
                                        @if($hddEquipment==$internalHard->id) selected @endif>{{ $internalHard->brandInfo->name}}
                                    - {{ $internalHard->model}} - {{ $internalHard->capacity }}
                                    - {{ $internalHard->connectivity_type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mr-2">
                        <label for=""
                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">کد اموال
                            هارد {{$index}}</label>
                        <input type="text" name="hdd_property_code[]"
                               value="{{ $equipmentInfo['hdd_property_code'][--$index] }}"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                               placeholder="">
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-center">
            <button type="button" id="add-hdd-select" class="mt-4 bg-blue-500 text-white p-2 rounded">افزودن هارد جدید
            </button>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#add-hdd-select').on('click', function () {
                const selectContainer = document.getElementById('hdd-select-container');
                const selectWrappers = selectContainer.getElementsByClassName('hdd-select-wrapper');
                const newIndex = selectWrappers.length + 1;

                const newSelectWrapper = document.createElement('div');
                newSelectWrapper.classList.add('mt-2', 'hdd-select-wrapper');

                const newLabel = document.createElement('label');
                newLabel.classList.add('block', 'mb-2', 'text-sm', 'font-medium', 'text-gray-900', 'dark:text-white');
                newLabel.innerText = 'هارد ' + newIndex;

                const newSelect = document.createElement('select');
                newSelect.name = 'hdd[]';
                newSelect.classList.add('select2', 'bg-gray-50', 'border', 'border-gray-300', 'text-gray-900', 'text-sm', 'rounded-lg', 'focus:ring-blue-500', 'focus:border-blue-500', 'block', 'w-full', 'p-3', 'dark:bg-gray-700', 'dark:border-gray-600', 'dark:placeholder-gray-400', 'dark:text-white', 'dark:focus:ring-blue-500', 'dark:focus:border-blue-500');

                // Copy options from the first select
                const firstSelect = selectWrappers[0].getElementsByTagName('select')[0];
                Array.from(firstSelect.options).forEach(option => {
                    const newOption = document.createElement('option');
                    newOption.value = option.value;
                    newOption.text = option.text;
                    newSelect.appendChild(newOption);
                });

                newSelectWrapper.appendChild(newLabel);
                newSelectWrapper.appendChild(newSelect);
                selectContainer.appendChild(newSelectWrapper);

                // Re-initialize select2 on new select elements
                $(newSelect).select2();
            });
        });
    </script>
</div>
