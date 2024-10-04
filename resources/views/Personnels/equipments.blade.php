@php use Morilog\Jalali\Jalalian; @endphp
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
                <div class="bg-white rounded shadow flex flex-col p-4">
                    <table class="w-full border-collapse rounded-lg overflow-hidden text-center datasheet">
                        <thead>
                        <tr class="bg-gradient-to-r from-blue-400 to-purple-500 items-center text-center text-white">
                            <th class="px-6 py-3  font-bold ">ردیف</th>
                            <th class="px-6 py-3  font-bold ">کد اموال</th>
                            <th class="px-6 py-3  font-bold ">نوع تجهیزات</th>
                            <th class="px-6 py-3  font-bold ">ثبت کننده</th>
                            <th class="px-6 py-3  font-bold ">تاریخ ثبت</th>
                            <th class="px-6 py-3  font-bold ">عملیات</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-300">
                        @foreach ($equipments as $equipment)
                            <tr class="bg-white">
                                <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4">{{ $equipment->property_code }}</td>
                                <td class="px-6 py-4">{{ $equipment->equipmentType->persian_name }}</td>
                                <td class="px-6 py-4">{{ $equipment->adderInfo->name }} {{ $equipment->adderInfo->family }}</td>
                                <td class="px-6 py-4">
                                    {{ Jalalian::fromDateTime($equipment->created_at)->format('H:i:s Y/m/d') }}
                                </td>
                                <td class="flex px-6 py-4">
                                    <a href="{{ route('Personnels.equipments.edit',['personnel'=>$personnel->id,'equipmentId'=>$equipment->id]) }}">
                                        <button type="button"
                                                class="px-4 py-2 mr-1 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300 ">
                                            ویرایش
                                        </button>
                                    </a>
                                    <a href="{{ route('History.index',['personnel'=>$personnel->id,'equipmentId'=>$equipment->id]) }}">
                                        <button type="button"
                                                class="px-4 py-2 mr-1 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring focus:border-gray-300 ">
                                            تاریخچه
                                        </button>
                                    </a>
                                    <button type="button" data-equipment-id="{{ $equipment->id }}"
                                            class="px-4 py-2 mr-1 bg-orange-500 text-white rounded-md hover:bg-orange-600 focus:outline-none focus:ring focus:border-orange-300 move-equipment">
                                        انتقال
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
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
        $(document).ready(function () {
            $('#new-equipment').click(function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'انتخاب تجهیزات',
                    html: `
                <select id="equipment-select" class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option disabled selected value="">انتخاب کنید</option>
                    @foreach ($equipmentTypes as $equipmentType)
                    <option value="{{ $equipmentType->id }}">{{ $equipmentType->persian_name }}</option>
                    @endforeach
                    </select>
`,
                    showCancelButton: true,
                    confirmButtonText: 'تایید',
                    cancelButtonText: 'لغو',
                    didOpen: () => {
                        // اینجا Select2 را اعمال می‌کنیم
                        $('#equipment-select').select2({
                            dropdownParent: $('.swal2-popup') // تعیین والد برای dropdown
                        });
                    },
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

            $('.move-equipment').click(function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'انتخاب پرسنل',
                    html: `
                <select id="personnel-select" class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option disabled selected value="">انتخاب کنید</option>
                    @foreach ($allPersonnels->get() as $personnel)
                    <option value="{{ $personnel->id }}">{{ $personnel->first_name }} {{ $personnel->last_name }}</option>
                    @endforeach
                    </select>
`,
                    showCancelButton: true,
                    confirmButtonText: 'تایید',
                    cancelButtonText: 'لغو',
                    didOpen: () => {
                        $('#personnel-select').select2({
                            dropdownParent: $('.swal2-popup')
                        });
                    },
                    preConfirm: () => {
                        const selectedOption = document.getElementById('personnel-select').value;
                        if (!selectedOption) {
                            Swal.showValidationMessage('لطفاً یک گزینه را انتخاب کنید');
                        }
                        return selectedOption;
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST',
                            url: "/Personnels/equipments/move",
                            data: {
                                'equipment_id': $(this).data('equipment-id'),
                                'personnel': result.value
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (response) {
                                location.reload();
                            }, error: function (xhr, textStatus, errorThrown) {
                                // console.log(xhr);
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
