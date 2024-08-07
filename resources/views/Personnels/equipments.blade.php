@extends('layouts.PanelMaster')
@section('content')
    <main class="flex-1 bg-gray-100 py-6 px-8">
        <div class="mx-auto lg:mr-72">
            <h1 class="text-2xl font-bold mb-4">تمامی تجهیزات {{ $personnel->first_name }} {{ $personnel->last_name }}
                با کد پرسنلی {{ $personnel->personnel_code }}</h1>
            @include('layouts.components.errors')
            @include('layouts.components.success')
            <div class="bg-white rounded shadow flex flex-col ">
                <div class="bg-white rounded shadow flex flex-col p-4">
                    <button type="button" id="new-equipment"
                            class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                        ایجاد تجهیزات
                    </button>
                </div>

                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button id="backward_page" type="button"
                            class="mt-3 w-full inline-flex justify-center px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring focus:border-blue-300 sm:mt-0 sm:w-auto">
                        بازگشت
                    </button>
                </div>
            </div>
        </div>
    </main>

    <script>
        $('#new-equipment').click(function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'انتخاب تجهیزات',
                html: `
            <select id="equipment-select" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option disabled selected value="">انتخاب کنید</option>
                @foreach ($equipmentTypes as $equipmentType)
                    <option value="{{ $equipmentType->id }}">{{ $equipmentType->persian_name }}</option>
                @endforeach
                </select>
`,
                showCancelButton: true,
                confirmButtonText: 'تایید',
                cancelButtonText: 'لغو',
                preConfirm: () => {
                    const selectedOption = document.getElementById('equipment-select').value;
                    if (!selectedOption) {
                        Swal.showValidationMessage('لطفاً یک گزینه را انتخاب کنید');
                    }
                    return selectedOption;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const url = result.value;
                    if (url) {
                        window.location.href = 'equipments/new/' + url;
                    }
                }
            });
        });
    </script>
@endsection
