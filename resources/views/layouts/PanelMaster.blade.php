<!DOCTYPE html>
<html dir="rtl" lang="en">
@php
    use Illuminate\Support\Collection;
@endphp
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>
        {{ env('APP_PERSIAN_NAME') }}
    </title>
    <script src="/build/plugins/jquery/dist/jquery.js"></script>
    <link href="/build/plugins/select2/dist/css/select2.min.css" rel="stylesheet"/>
    <script src="/build/plugins/select2/dist/js/select2.min.js"></script>
    {{--    <link rel="stylesheet" href="/build/plugins/jquery-tags-input/dist/jquery.tagsinput.min.css">--}}
    {{--    <script src="/build/plugins/jquery-tags-input/dist/jquery.tagsinput.min.js"></script>--}}
    <script src="/build/plugins/persian-date/dist/persian-date.js"></script>
    <script src="/build/plugins/persian-datepicker/dist/js/persian-datepicker.js"></script>
    <link rel="stylesheet" href="/build/plugins/persian-datepicker/dist/css/persian-datepicker.css"/>

    <link href="/build/plugins/DataTables/datatables.min.css" rel="stylesheet">
    <script src="/build/plugins/DataTables/datatables.min.js"></script>

    <link rel="stylesheet" type="text/css" href="/build/plugins/Buttons-3.1.2/css/buttons.dataTables.min.css"/>
    <script src="/build/plugins/Buttons-3.1.2/js/dataTables.buttons.min.js"></script>
    <script src="/build/plugins/Buttons-3.1.2/js/buttons.dataTables.min.js"></script>
    <script src="/build/plugins/Buttons-3.1.2/js/buttons.html5.min.js"></script>
    <script src="/build/plugins/Buttons-3.1.2/js/buttons.print.min.js"></script>

    <script src="/build/plugins/ColReorder-2.0.4/js/dataTables.colReorder.min.js"></script>
    <script src="/build/plugins/ColReorder-2.0.4/js/colReorder.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/build/plugins/ColReorder-2.0.4/css/colReorder.dataTables.min.css"/>

    <link rel="stylesheet" type="text/css" href="/build/plugins/Select-2.1.0/css/select.dataTables.css"/>
    <script src="/build/plugins/Select-2.1.0/js/dataTables.select.js"></script>
    <script src="/build/plugins/Select-2.1.0/js/select.dataTables.js"></script>

    <script src="/build/plugins/jszip/dist/jszip.min.js"></script>
    <script src="/build/plugins/pdfmake/build/pdfmake.min.js"></script>
    <script src="/build/plugins/pdfmake/build/vfs_fonts.js"></script>
    <script>
        $(document).ready(function () {
            $('.select2').select2({
                language: {
                    noResults: function () {
                        return "نتیجه‌ای یافت نشد";
                    }
                },
                placeholder: 'یک گزینه را انتخاب کنید',
                width: '100%',
                height: '100%'
            });
            $(".delivery_date").pDatepicker(
                {
                    "format": "LLLL",
                    "viewMode": "day",
                    "initialValue": true,
                    "minDate": null,
                    "maxDate": null,
                    "autoClose": false,
                    "position": "auto",
                    "altFormat": "lll",
                    "altField": "#altfieldExample",
                    "onlyTimePicker": false,
                    "onlySelectOnDate": true,
                    "calendarType": "persian",
                    "inputDelay": 800,
                    "observer": false,
                    "calendar": {
                        "persian": {
                            "locale": "fa",
                            "showHint": true,
                            "leapYearMode": "algorithmic"
                        },
                        "gregorian": {
                            "locale": "en",
                            "showHint": false
                        }
                    },
                    "navigator": {
                        "enabled": true,
                        "scroll": {
                            "enabled": true
                        },
                        "text": {
                            "btnNextText": "<",
                            "btnPrevText": ">"
                        }
                    },
                    "toolbox": {
                        "enabled": true,
                        "calendarSwitch": {
                            "enabled": false,
                            "format": "MMMM"
                        },
                        "todayButton": {
                            "enabled": true,
                            "text": {
                                "fa": "امروز",
                                "en": "Today"
                            }
                        },
                        "submitButton": {
                            "enabled": false,
                            "text": {
                                "fa": "تایید",
                                "en": "Submit"
                            }
                        },
                        "text": {
                            "btnToday": "امروز"
                        }
                    },
                    "timePicker": {
                        "enabled": false,
                        "step": 1,
                        "hour": {
                            "enabled": false,
                            "step": null
                        },
                        "minute": {
                            "enabled": false,
                            "step": null
                        },
                        "second": {
                            "enabled": false,
                            "step": null
                        },
                        "meridian": {
                            "enabled": false
                        }
                    },
                    "dayPicker": {
                        "enabled": true,
                        "titleFormat": "YYYY MMMM"
                    },
                    "monthPicker": {
                        "enabled": true,
                        "titleFormat": "YYYY"
                    },
                    "yearPicker": {
                        "enabled": true,
                        "titleFormat": "YYYY"
                    },
                    "responsive": true
                }
            );

            let table = new DataTable('.datatable', {
                "ordering": true,
                "searching": true,
                "paging": true,
                "info": true,
                "pageLength": 25,
                "lengthChange": true,
                select: true,
                colReorder: true,
                "columnDefs": [{
                    "targets": 'action',
                    "searchable": false
                }],
                responsive: true,
                "language": {
                    search: "جستجو:",
                    info: "نمایش _START_ تا _END_ از _TOTAL_ رکورد",
                    infoEmpty: "نمایش 0 تا 0 از 0 رکورد",
                    infoFiltered: "(فیلتر شده از _MAX_ رکورد)",
                    lengthMenu: "نمایش _MENU_ رکورد در هر صفحه",
                    "sZeroRecords": "هیچ رکوردی مطابق با جستجوی شما پیدا نشد",
                    "emptyTable": "اطلاعاتی در جدول موجود نیست",
                    select: {
                        rows: {
                            _: "تعداد %d رکورد انتخاب شده",
                            1: "1 رکورد انتخاب شده"
                        }
                    },
                    paginate: {
                        first: "ابتدا",
                        last: "انتها",
                        next: "بعدی",
                        previous: "قبلی"
                    }
                },
                dom: '<"top"lfB>rt<"bottom"ip><"clear">',
                buttons: [
                    {
                        extend: 'copy',
                        exportOptions: {
                            columns: ':not(.action)'
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        text: 'Excel',
                        title: document.title,
                        filename: function () {
                            let date = new Date();
                            let formattedDate = date.getFullYear() + '-' +
                                (date.getMonth() + 1).toString().padStart(2, '0') + '-' +
                                date.getDate().toString().padStart(2, '0') + '_' +
                                date.getHours().toString().padStart(2, '0') + '-' +
                                date.getMinutes().toString().padStart(2, '0');
                            return document.title + '_' + formattedDate;
                        }, exportOptions: {
                            columns: ':not(.action)'
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: 'PDF (Portrait)',
                        orientation: 'portrait',
                        pageSize: 'A4',
                        title: 'Report (Portrait)',
                        filename: function () {
                            let date = new Date();
                            let formattedDate = date.getFullYear() + '-' +
                                (date.getMonth() + 1).toString().padStart(2, '0') + '-' +
                                date.getDate().toString().padStart(2, '0') + '_' +
                                date.getHours().toString().padStart(2, '0') + '-' +
                                date.getMinutes().toString().padStart(2, '0');
                            return document.title + '_' + formattedDate;
                        },
                        customize: function (doc) {
                            doc.styles.footer = {
                                alignment: 'center',
                                fontSize: 8,
                                margin: [0, 10, 0, 0]
                            };

                            doc.footer = function (currentPage, pageCount) {
                                return {text: currentPage.toString() + ' of ' + pageCount, style: 'footer'};
                            };
                            doc.background = function (currentPage, pageSize) {
                                return {
                                    image: '',
                                    width: 300,
                                    height: 300,
                                    opacity: 0.3,
                                    absolutePosition: {
                                        x: (pageSize.width - 300) / 2,
                                        y: (pageSize.height - 300) / 2
                                    }
                                };
                            };
                        }, exportOptions: {
                            columns: ':not(.action)'
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: 'PDF (Landscape)',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        title: 'Report (Landscape)',
                        filename: function () {
                            let date = new Date();
                            let formattedDate = date.getFullYear() + '-' +
                                (date.getMonth() + 1).toString().padStart(2, '0') + '-' +
                                date.getDate().toString().padStart(2, '0') + '_' +
                                date.getHours().toString().padStart(2, '0') + '-' +
                                date.getMinutes().toString().padStart(2, '0');
                            return document.title + '_' + formattedDate;
                        },
                        customize: function (doc) {
                            doc.styles.footer = {
                                alignment: 'center',
                                fontSize: 8,
                                margin: [0, 10, 0, 0]
                            };

                            doc.footer = function (currentPage, pageCount) {
                                return {text: currentPage.toString() + ' of ' + pageCount, style: 'footer'};
                            };
                            doc.background = function (currentPage, pageSize) {
                                return {
                                    image: '',
                                    width: 300,
                                    height: 300,
                                    opacity: 0.3,
                                    absolutePosition: {
                                        x: (pageSize.width - 300) / 2,
                                        y: (pageSize.height - 300) / 2
                                    }
                                };
                            };
                        }, exportOptions: {
                            columns: ':not(.action)'
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: ':not(.action)'
                        }
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: ':not(.action)'
                        }
                    }
                ]
            });

            $('.datatable thead').prepend('<tr class="filter-row"></tr>');

            table.columns().every(function () {
                let column = this;

                let select = $('<th><select style="background-color: white"><option value="">همه</option></select></th>')
                    .appendTo('.datatable thead tr.filter-row')
                    .find('select')
                    .on('change', function () {
                        let val = $.fn.DataTable.util.escapeRegex($(this).val());
                        column.search(val ? '^' + val + '$' : '', true, false).draw();
                    });

                column.data().unique().sort().each(function (d, j) {
                    let uniqueData = [];
                    if (d) {
                        let cleanData = $('<div>').html(d).text().trim();
                        if (cleanData && !uniqueData.includes(cleanData)) {
                            uniqueData.push(cleanData);
                            select.append('<option value="' + cleanData + '">' + cleanData + '</option>');
                        }
                    }
                });

            });
        });
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
@component('components.loader-spinner') @endcomponent

<body class="flex flex-col min-h-screen mt-14">
<div id="loading_popup" class="hidden">
    <div class="loader_popup"></div>
    <p class="animate-pulse text-blue-700 text-xl mr-3">در حال پردازش اطلاعات...</p>
</div>

<header class="w-full fixed top-0 right-0 bg-cu-light py-5 md:px-2 lg:px-0">
    <div class="flex items-center lg:mx-2 mx-5">
        <div>
            <style>
                ::-webkit-scrollbar {
                    width: 12px;
                }

                ::-webkit-scrollbar-thumb {
                    background-color: #4A90E2;
                    border-radius: 6px;
                }

                ::-webkit-scrollbar-thumb:hover {
                    background-color: #357ABD;
                    border-radius: 10px;
                }

                li.active {
                    /* overflow: hidden; */
                    position: relative;

                    /* width: 100px; */
                    /* height: 100px; */
                }

                li.active a {
                    transition: 0.5s;
                    background: #f0f6fb;
                    color: rgb(27, 27, 27);
                    /* border-radius: 20px; */
                    border-top-right-radius: 50px;
                    border-bottom-right-radius: 50px;

                }

                li.active a:focus {
                    background: #f0f6fb;

                }

                li.active a svg {
                    color: rgb(34, 34, 34);
                }


                li.active:before,
                li.active:after {
                    content: "";
                    display: block;
                    width: 60px;
                    height: 60px;
                    position: absolute;
                    border-radius: 50%;
                }

                li.active:before {
                    bottom: -52px;
                    left: 0px;
                    box-shadow: -30px 26px 0px 0px #f0f6fb;
                    transform: rotateX(180deg);

                }

                li.active:after {
                    top: -52px;
                    left: 0px;
                    box-shadow: -30px 26px 0px 0px #f0f6fb;
                }

                .menu {
                    height: 100vh;
                    max-height: calc(100vh - 8%);
                    position: fixed;
                    top: 8%;
                    right: 0;
                    overflow-y: auto;
                }

                /* .mr-350 {
                    transition: .5s;
                    margin-right: -350px;
                } */
                .drawer-side {
                    position: fixed !important;
                }
            </style>

            <aside data-theme="wireframe" class="bg-cu-light ">
                <div class="drawer lg:drawer-open">
                    <input id="my-drawer-2" type="checkbox" class="drawer-toggle"/>
                    <div class="drawer-content flex flex-col items-center justify-center">
                        <!-- Page content here -->
                        <label for="my-drawer-2" class="cursor-pointer inline lg:hidden drawer-button"
                               id="toggle-menu-n">
                            <svg viewBox="0 0 100 80" width="30" height="40">
                                <rect width="100" height="20" rx="10"></rect>
                                <rect y="30" width="100" height="20" rx="10"></rect>
                                <rect y="60" width="100" height="20" rx="10"></rect>
                            </svg>
                        </label>

                    </div>
                    <div class="drawer-side">
                        <label for="my-drawer-2" class="drawer-overlay"></label>
                        @php
                            $userInfo=\Illuminate\Support\Facades\DB::table('users')
                                    ->where('username', session('username'))
                                    ->first();
                        @endphp
                        <ul id="menu"
                            class="menu pl-0 w-72 bg-cu-blue text-transparent pt-5 overflow-x-hidden rounded-se-3xl block">

                            <div class="ml-7 mb-6 text-center mt-5">
                                <div class="avatar flex justify-center ">
                                    @if($userInfo->user_image)
                                        @php
                                            $src=substr($userInfo->user_image,6);
                                            $src='storage'.$src;
                                        @endphp
                                        <div style="background: url({{ $src }}) no-repeat; background-size: cover;"
                                             class="w-16 h-16 rounded-full">
                                        </div>
                                    @else
                                        <div id="user_icon" class="w-16 h-16 rounded-full">
                                        </div>
                                    @endif

                                </div>
                                <p class="pt-2 text-cu-light">
                                    {{ $userInfo->username.' | '. $userInfo->name . ' '. $userInfo->family }}
                                </p>
                                <p class="pt-1 text-cu-light">
                                    {{ $userInfo->subject }}
                                </p>
                            </div>
                            <li class="menu-item" id="dashboard">
                                <a href="{{ route('dashboard') }}"
                                   class="flex items-center text-cu-light rounded-s-full dark:text-white hover:bg-gray-100 light:hover:bg-gray-700 group">
                                    <i style="font-size: 24px" class="las la-home"></i>
                                    <span class="">صفحه اصلی</span>
                                </a>
                            </li>
                            @foreach (session('menus') as $menu)
                                <li>
                                    @if (isset($menu['childs']) && count($menu['childs']) > 0)
                                        @php
                                            $collator = new \Collator('fa_IR');
                                            $sortedMenu = collect($menu['childs'])->sort(function ($a, $b) use ($collator) {
                                                return $collator->compare($a['title'], $b['title']);
                                            });
                                        @endphp
                                        @can($menu['permission'])
                                            <details id="{{ 'details-' . $menu['title'] }}">
                                                <summary
                                                    class="flex items-center my-1 text-cu-light rounded-s-full dark:text-white hover:bg-gray-100 light:hover:bg-gray-700 group text-nowrap">
                                                    <i style="font-size: 24px" class="{{$menu['icon']}}"></i>
                                                    {{ $menu['title'] }}
                                                </summary>
                                                <ul class="text-white w-full mr-2">
                                                    @foreach ($sortedMenu as $child)
                                                        @if(isset($child['permission']))
                                                            @can($child['permission'])
                                                                <li class="menu-item mr-8" id="{{ $child['title'] }}">
                                                                    <a href="{{ $child['link'] }}"
                                                                       class="flex items-center my-1 text-cu-light rounded-s-full dark:text-white hover:bg-gray-100 light:hover:bg-gray-700 group">
                                                                        <i style="font-size: 24px"
                                                                           class="{{$child['icon']}}"></i>
                                                                        {{ $child['title'] }}</a>
                                                                </li>
                                                            @endcan
                                                        @endif
                                                    @endforeach
                                                </ul>
                                                @endcan
                                                @else
                                                    @if(isset($menu['permission']))
                                                        @can($menu['permission'])
                                                            <li class="menu-item" id="menu{{ $menu['link'] }}">
                                                                <a href="{{ $menu['link'] }}"
                                                                   class="flex items-center my-1 text-cu-light rounded-s-full dark:text-white hover:bg-gray-100 light:hover:bg-gray-700 group">
                                                                    <i style="font-size: 24px"
                                                                       class="{{$menu['icon']}}"></i>
                                                                    <span class="">{{ $menu['title'] }}</span>
                                                                </a>
                                                            </li>
                                                        @endcan
                                                    @endif
                                                @endif
                                            </details>
                                </li>
                            @endforeach

                            <li class="menu-item" id="changePassword">
                                <a href="{{ route('Profile') }}"
                                   class="flex items-center my-1 text-cu-light rounded-s-full dark:text-white hover:bg-gray-100 light:hover:bg-gray-700 group">
                                    <i style="font-size: 24px" class="las la-key"></i>
                                    <span class=" mr-3 ">پروفایل</span>
                                </a>
                            </li>
                            <li class="menu-item logout" id="logout">
                                <a href="{{ route('logout') }}"
                                   class="flex items-center my-1 text-cu-light rounded-s-full dark:text-white hover:bg-gray-100 light:hover:bg-gray-700 group">
                                    <i style="font-size: 24px" class="las la-sign-out-alt"></i>
                                    <span class="">خروج</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <script>

                </script>

            </aside>

        </div>
        <div class="flex justify-center w-full lg:w-auto">
            <h3 class=" text-gray-700 text-center font-bold text-lg">
                    <span class="text-cu-blblack">
                        {{ env('APP_PERSIAN_NAME') }}
                    </span>
            </h3>
        </div>
    </div>
</header>

<!-- Main Content -->

<div class="flex-1 flex overflow-x-scroll">
    @yield('content')
</div>

<footer class="bg-gray-800 text-gray-300 py-4 px-8">
    <div class="max-w-4xl mx-auto text-center">
        <span>{{ env('COPYRIGHT_TEXT') }}</span>
    </div>
</footer>

<!-- Show other images modal -->
<div id="other-images-modal-container" onclick="closeModal()"
     class="fixed top-0 left-0 w-full h-full flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="other-images-modal-container bg-white rounded-lg p-4 max-w-3xl">
        <img id="modal-image" src="" alt="تصویر مودال" class="w-full">
    </div>
</div>

<script>
    function openModal(imageUrl) {
        const modal = document.querySelector('.other-images-modal-container');
        modal.querySelector('img').src = imageUrl;
        modal.parentElement.classList.remove('hidden');
    }

    function closeModal(imageUrl) {
        const modal = document.querySelector('.other-images-modal-container');
        modal.querySelector('img').src = imageUrl;
        modal.parentElement.classList.add('hidden');
    }

    function loaderSpinner() {
        $('#loader').toggleClass('hidden');
    }
</script>
</body>

</html>
