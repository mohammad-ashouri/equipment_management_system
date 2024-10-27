import './bootstrap';
import '@fortawesome/fontawesome-free/css/all.css';
import Swal from 'sweetalert2';
import Alpine from 'alpinejs';
import 'tw-elements';
import Intersect from '@alpinejs/intersect';
// Initialization for ES Users
import {initTE, Modal, Ripple,} from "tw-elements";
// import 'tinymce/tinymce';
// import 'tinymce/skins/ui/oxide/skin.min.css';
// import 'tinymce/skins/content/default/content.min.css';
// import 'tinymce/skins/content/default/content.css';
// import 'tinymce/icons/default/icons';
// import 'tinymce/themes/silver/theme';
// import 'tinymce/models/dom/model';
// import 'tinymce/plugins/table/plugin.js';
// import 'tinymce/plugins/fullscreen/plugin.js';
// import 'tinymce/plugins/autoresize/plugin.js';

initTE({Modal, Ripple});

window.Swal = Swal;

//AlpineJS
Alpine.plugin(Intersect);
Alpine.start();
window.Alpine = Alpine;


document.addEventListener('DOMContentLoaded', () => {
    const currentPath = window.location.pathname;

    // Get all the menu items
    const menuItems = document.querySelectorAll('.menu-item');

    // Loop through the menu items and check if the href matches the current path
    menuItems.forEach(item => {
        const link = item.querySelector('a');
        if (link && currentPath.includes(link.getAttribute('href'))) {
            // If it's a child menu, open the parent details element
            const detailsElement = item.closest('details');
            if (detailsElement) {
                detailsElement.setAttribute('open', true);
            }

            // Add the active class to the matched menu item
            item.classList.add('active');
        }
    });
});

// Function to handle click on menu items
function handleMenuItemClick(event) {
    // Get all the menu items
    const menuItems = document.querySelectorAll('.menu-item');

    // Remove the active class from all menu items
    menuItems.forEach(item => item.classList.remove('active'));

    // Add the active class to the clicked menu item
    event.currentTarget.classList.add('active');

    // Save the selected menu item ID to the sessionStorage
    sessionStorage.setItem('selectedMenuItem', event.currentTarget.id);
}

// Add event listeners to each menu item
const menuItems = document.querySelectorAll('.menu-item');
menuItems.forEach(item => {
    item.addEventListener('click', handleMenuItemClick);
});

// Function to handle click on child menu items
function handleChildMenuItemClick(event) {
    const detailsElement = event.currentTarget.closest('details');
    if (detailsElement) {
        // Set the 'open' attribute for the details element
        detailsElement.setAttribute('open', true);
    }

    // Remove the active class from all child menu items
    const childMenuItems = document.querySelectorAll('.menu-item');
    childMenuItems.forEach(item => item.classList.remove('active'));

    // Add the active class to the clicked child menu item
    event.currentTarget.classList.add('active');

    // Save the selected child menu item ID to the sessionStorage
    sessionStorage.setItem('selectedChildMenuItem', event.currentTarget.id);
}

// Add event listeners to each child menu item
const childMenuItems = document.querySelectorAll('.menu-item');
childMenuItems.forEach(item => {
    item.addEventListener('click', handleChildMenuItemClick);
});

function handleLogout() {
    // Clear the selected menu item and child menu item from sessionStorage
    sessionStorage.removeItem('selectedMenuItem');
    sessionStorage.removeItem('selectedChildMenuItem');
}

// Add event listener to the "خروج" (Logout) menu item
const logoutMenuItem = document.getElementById('logout');
logoutMenuItem.addEventListener('click', handleLogout);


function openModal(imageUrl) {
    const modal = document.querySelector('.modal-container');
    modal.querySelector('img').src = imageUrl;
    modal.parentElement.classList.remove('hidden');
}

function swalFire(title = null, text, icon, confirmButtonText) {
    Swal.fire({
        title: title, text: text, icon: icon, confirmButtonText: confirmButtonText,
    });
}

function toggleModal(modalID) {
    let modal = document.getElementById(modalID);
    if (modal.classList.contains('modal-active')) {
        modal.classList.remove('animate-fade-in');
        modal.classList.add('animate-fade-out');
        setTimeout(() => {
            modal.classList.remove('modal-active');
            modal.classList.remove('animate-fade-out');
        }, 150);
    } else {
        modal.classList.add('modal-active');
        modal.classList.remove('animate-fade-out');
        modal.classList.add('animate-fade-in');
    }
}

function hasOnlyPersianCharacters(input) {
    let persianPattern = /^[\u0600-\u06FF0-9()\s]+$/;
    return persianPattern.test(input);
}

function hasOnlyEnglishCharacters(input) {
    let englishPattern = /^[a-zA-Z0-9\s-]+$/;
    return englishPattern.test(input);
}

function swalFireWithQuestion() {
    Swal.fire({
        title: 'آیا مطمئن هستید؟',
        text: 'این مقدار به صورت دائمی اضافه خواهد شد.',
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'خیر',
        confirmButtonText: 'بله',
    }).then((result) => {
        if (result.isConfirmed) {

        } else if (result.dismiss === Swal.DismissReason.cancel) {

        }
    });
}

function hasNumber(text) {
    return /\d/.test(text);
}

function resetFields() {
    const inputs = document.querySelectorAll('input');
    inputs.forEach(input => input.value = "");
    const selectors = document.querySelectorAll('select');
    selectors.forEach(select => select.value = "");
    const textareas = document.querySelectorAll('textarea');
    textareas.forEach(textarea => textarea.value = "");

    // const radios = document.querySelectorAll('input');
    // radios.forEach(input => input.selected = "");
    // const checkboxes = document.querySelectorAll("input");
    // checkboxes.forEach(input => input.selected = "");
}

function showLoadingPopup() {
    loading_popup.style.display = 'flex';
}

function hideLoadingPopup() {
    loading_popup.style.display = 'none';
}

function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, '\\$&');
    let regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'), results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}

//Get Jalali time and date
function getJalaliDate() {
    return new Promise(function (resolve, reject) {
        $.ajax({
            type: 'GET', url: "/date", success: function (response) {
                resolve(response);
            }, error: function (error) {
                reject(error);
            }
        });
    });
}


$(document).ready(function () {
    hideLoadingPopup();

    $('#keywords').tagsInput({
        selectFirst: true,
        autoFill: true,
        defaultText: 'کلمه کلیدی را وارد کنید و enter را فشار دهید',
        width: '100%',
        interactive: true,
        delimiter: [","],
    });

    $('.image-container').on('mouseenter', function () {
        $(this).find('.other-image').addClass('grayscale'); // تغییر تصویر به سیاه و سفید
        $(this).find('.delete-btn').removeClass('hidden'); // نمایش دکمه حذف
    });

    $('.image-container').on('mouseleave', function () {
        $(this).find('.other-image').removeClass('grayscale'); // بازگردانی تصویر به حالت عادی
        $(this).find('.delete-btn').addClass('hidden'); // مخفی کردن دکمه حذف
    });

    $('#slider').change(function () {
        if ($(this).val() == 1) {
            $('.slider-image').removeClass('hidden');
            $('.slider-image-show').removeClass('hidden');
        } else {
            $('.slider-image').addClass('hidden');
            $('.slider-image-show').addClass('hidden');
        }
    });

    $('#create-post').submit(function (e) {
        e.preventDefault();
        Swal.fire({
            title: 'آیا مطمئن هستید؟',
            text: 'این مورد ایجاد خواهد شد!',
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'خیر',
            confirmButtonText: 'بله',
        }).then((result) => {
            if (result.isConfirmed) {
                $(this).off('submit');
                $(this).submit();
            }
        });
    });

    $('#edit-post').submit(function (e) {
        e.preventDefault();
        Swal.fire({
            title: 'آیا مطمئن هستید؟',
            text: 'این مورد ویرایش خواهد شد!',
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'خیر',
            confirmButtonText: 'بله',
        }).then((result) => {
            if (result.isConfirmed) {
                $(this).off('submit');
                $(this).submit();
            }
        });
    });

    $('.delete-post').submit(function (e) {
        e.preventDefault();
        Swal.fire({
            title: 'آیا مطمئن هستید؟',
            text: 'این مورد حذف خواهد شد!',
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'خیر',
            confirmButtonText: 'بله',
        }).then((result) => {
            if (result.isConfirmed) {
                $(this).off('submit');
                $(this).submit();
            }
        });
    });
    $('#create-catalog').submit(function (e) {
        e.preventDefault();
        Swal.fire({
            title: 'آیا مطمئن هستید؟',
            text: 'این مورد ثبت خواهد شد!',
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'خیر',
            confirmButtonText: 'بله',
        }).then((result) => {
            if (result.isConfirmed) {
                $(this).off('submit');
                $(this).submit();
            }
        });
    });
    $('#edit-catalog').submit(function (e) {
        e.preventDefault();
        Swal.fire({
            title: 'آیا مطمئن هستید؟',
            text: 'این مورد ویرایش خواهد شد!',
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'خیر',
            confirmButtonText: 'بله',
        }).then((result) => {
            if (result.isConfirmed) {
                $(this).off('submit');
                $(this).submit();
            }
        });
    });

    $('#backward_page').on('click', function () {
        window.history.back();
    });
    let pathname = window.location.pathname;
    if (pathname.includes('DocumentTypes')) {

    } else if (pathname.includes('AudiosSubjects')) {
    } else if (pathname.includes('BookIntroductions')) {
        $('.delete-btn').click(function (e) {
            e.preventDefault();
            let $imageContainer = $(this).closest('.image-container');
            let $image = $imageContainer.find('.other-image');
            let imageId = $image.data('id');

            Swal.fire({
                title: 'آیا مطمئن هستید؟',
                text: 'تصویر انتخاب شده برای همیشه حذف خواهد شد!',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'خیر',
                confirmButtonText: 'بله',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'DELETE',
                        url: '/BookIntroductions/destroyImage/' + imageId,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function (response) {
                            if (response.status === 'success') {
                                $imageContainer.remove(); // حذف والدین تصویر
                                swalFire('عملیات موفقیت آمیز بود!', 'تصویر با موفقیت حذف شد.', 'success', 'بستن');
                            } else {
                                swalFire('عملیات با شکست مواجه شد!', 'دوباره تلاش کنید.', 'error', 'بستن');
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error('Error:', error);
                            swalFire('خطا در ارسال درخواست!', 'لطفاً مجدداً تلاش کنید.', 'error', 'بستن');
                        }
                    });
                }
            });
        });
    } else if (pathname.includes('SocialMedia')) {
        $('.delete-btn').click(function (e) {
            e.preventDefault();
            let $imageContainer = $(this).closest('.image-container');
            let $image = $imageContainer.find('.other-image');
            let imageId = $image.data('id');

            Swal.fire({
                title: 'آیا مطمئن هستید؟',
                text: 'تصویر انتخاب شده برای همیشه حذف خواهد شد!',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'خیر',
                confirmButtonText: 'بله',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'DELETE',
                        url: '/SocialMedia/destroyImage/' + imageId,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function (response) {
                            if (response.status === 'success') {
                                $imageContainer.remove(); // حذف والدین تصویر
                                swalFire('عملیات موفقیت آمیز بود!', 'تصویر با موفقیت حذف شد.', 'success', 'بستن');
                            } else {
                                swalFire('عملیات با شکست مواجه شد!', 'دوباره تلاش کنید.', 'error', 'بستن');
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error('Error:', error);
                            swalFire('خطا در ارسال درخواست!', 'لطفاً مجدداً تلاش کنید.', 'error', 'بستن');
                        }
                    });
                }
            });
        });
    } else if (pathname.includes('Documentaries')) {
        $('.delete-btn').click(function (e) {
            e.preventDefault();
            let $imageContainer = $(this).closest('.image-container');
            let $image = $imageContainer.find('.other-image');
            let imageId = $image.data('id');

            Swal.fire({
                title: 'آیا مطمئن هستید؟',
                text: 'تصویر انتخاب شده برای همیشه حذف خواهد شد!',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'خیر',
                confirmButtonText: 'بله',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'DELETE',
                        url: '/Documentaries/destroyImage/' + imageId,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function (response) {
                            if (response.status === 'success') {
                                $imageContainer.remove(); // حذف والدین تصویر
                                swalFire('عملیات موفقیت آمیز بود!', 'تصویر با موفقیت حذف شد.', 'success', 'بستن');
                            } else {
                                swalFire('عملیات با شکست مواجه شد!', 'دوباره تلاش کنید.', 'error', 'بستن');
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error('Error:', error);
                            swalFire('خطا در ارسال درخواست!', 'لطفاً مجدداً تلاش کنید.', 'error', 'بستن');
                        }
                    });
                }
            });
        });
    } else if (pathname.includes('Professors')) {
        $(document).on('click', '.remove-book-row', function () {
            $(this).closest('.book-row').remove();
        });
        $(document).on('click', '.remove-article-row', function () {
            $(this).closest('.article-row').remove();
        });
        $('#new_book').click(function () {
            let newInput = `
                    <div class="flex w-full book-row">
                        <div class="w-full">
                            <label for=""
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">نام کتاب
                            </label>
                            <input type="text" id="book0" name="books[]" value=""
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="کتاب را وارد کنید"
                            >
                        </div>
                        <div class="mt-7 mr-2">
                            <button id="remove" type="button"
                                    class="mt-3 w-96 inline-flex justify-center px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring focus:border-red-300 sm:mt-0 sm:w-auto remove-book-row">
                                حذف
                            </button>
                        </div>
                    </div>
                `;
            $('#booksContainer').append(newInput);
        });
        $('#new_article').click(function () {
            let newInput = `
                    <div class="flex w-full article-row">
                        <div class="w-full">
                            <label for=""
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">نام مقاله
                            </label>
                            <input type="text" id="article0" name="articles[]" value=""
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="مقاله را وارد کنید"
                            >
                        </div>
                        <div class="mt-7 mr-2">
                            <button id="remove" type="button"
                                    class="mt-3 w-96 inline-flex justify-center px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring focus:border-red-300 sm:mt-0 sm:w-auto remove-article-row">
                                حذف
                            </button>
                        </div>
                    </div>
                `;
            $('#articlesContainer').append(newInput);
        });
        $('.delete-btn').click(function (e) {
            e.preventDefault();
            let $imageContainer = $(this).closest('.image-container');
            let $image = $imageContainer.find('.other-image');
            let imageId = $image.data('id');

            Swal.fire({
                title: 'آیا مطمئن هستید؟',
                text: 'تصویر انتخاب شده برای همیشه حذف خواهد شد!',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'خیر',
                confirmButtonText: 'بله',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'DELETE',
                        url: '/Professors/destroyImage/' + imageId,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function (response) {
                            if (response.status === 'success') {
                                $imageContainer.remove(); // حذف والدین تصویر
                                swalFire('عملیات موفقیت آمیز بود!', 'تصویر با موفقیت حذف شد.', 'success', 'بستن');
                            } else {
                                swalFire('عملیات با شکست مواجه شد!', 'دوباره تلاش کنید.', 'error', 'بستن');
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error('Error:', error);
                            swalFire('خطا در ارسال درخواست!', 'لطفاً مجدداً تلاش کنید.', 'error', 'بستن');
                        }
                    });
                }
            });
        });
    } else if (pathname.includes('ResearchSubjects')) {
        $('.delete-btn').click(function (e) {
            e.preventDefault();
            let $imageContainer = $(this).closest('.image-container');
            let $image = $imageContainer.find('.other-image');
            let imageId = $image.data('id');

            Swal.fire({
                title: 'آیا مطمئن هستید؟',
                text: 'تصویر انتخاب شده برای همیشه حذف خواهد شد!',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'خیر',
                confirmButtonText: 'بله',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'DELETE',
                        url: '/ResearchSubjects/destroyImage/' + imageId,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function (response) {
                            if (response.status === 'success') {
                                $imageContainer.remove(); // حذف والدین تصویر
                                swalFire('عملیات موفقیت آمیز بود!', 'تصویر با موفقیت حذف شد.', 'success', 'بستن');
                            } else {
                                swalFire('عملیات با شکست مواجه شد!', 'دوباره تلاش کنید.', 'error', 'بستن');
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error('Error:', error);
                            swalFire('خطا در ارسال درخواست!', 'لطفاً مجدداً تلاش کنید.', 'error', 'بستن');
                        }
                    });
                }
            });
        });
    } else if (pathname.includes('InternationalDocuments')) {
        $('.delete-btn').click(function (e) {
            e.preventDefault();
            let $imageContainer = $(this).closest('.image-container');
            let $image = $imageContainer.find('.other-image');
            let imageId = $image.data('id');

            Swal.fire({
                title: 'آیا مطمئن هستید؟',
                text: 'تصویر انتخاب شده برای همیشه حذف خواهد شد!',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'خیر',
                confirmButtonText: 'بله',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'DELETE',
                        url: '/InternationalDocuments/destroyImage/' + imageId,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function (response) {
                            if (response.status === 'success') {
                                $imageContainer.remove(); // حذف والدین تصویر
                                swalFire('عملیات موفقیت آمیز بود!', 'تصویر با موفقیت حذف شد.', 'success', 'بستن');
                            } else {
                                swalFire('عملیات با شکست مواجه شد!', 'دوباره تلاش کنید.', 'error', 'بستن');
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error('Error:', error);
                            swalFire('خطا در ارسال درخواست!', 'لطفاً مجدداً تلاش کنید.', 'error', 'بستن');
                        }
                    });
                }
            });
        });
    } else if (pathname.includes('ContactUs')) {
        $('.is_read,.is_spam').submit(function (e) {
            e.preventDefault();

            Swal.fire({
                title: 'آیا مطمئن هستید؟',
                text: 'این انتخاب قابل بازگشت نیست!',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'خیر',
                confirmButtonText: 'بله',
            }).then((result) => {
                if (result.isConfirmed) {
                    $(this).off();
                    $(this).submit();
                }
            });
        });
        $('.getHeaders').click(function (e) {
            showLoadingPopup();
            $.ajax({
                type: 'GET',
                url: '/getContactUsHeaders/' + $(this).data('id'),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (response) {
                    Swal.fire({
                        title: 'اطلاعات کاربر',
                        html: "host: " +
                            response['host'] +
                            "<br/>" +
                            "user-agent: " +
                            response['user-agent'] +
                            "<br/>" +
                            "content-length: " +
                            response['content-length'] +
                            "<br/>" +
                            "origin: " +
                            response['origin'] +
                            "<br/>" +
                            "referer: " +
                            response['referer'] +
                            "<br/>" +
                            "sec-fetch-dest: " +
                            response['sec-fetch-dest'] +
                            "<br/>" +
                            "sec-fetch-mode: " +
                            response['sec-fetch-mode'] +
                            "<br/>" +
                            "sec-fetch-site: " +
                            response['sec-fetch-site'] +
                            "<br/>" +
                            "sec-fetch-user: " +
                            response['sec-fetch-user'] +
                            "<br/>" +
                            "priority: " +
                            response['priority'],
                        icon: 'success',
                        confirmButtonText: 'بستن'
                    });
                    hideLoadingPopup();
                },
                error: function (xhr, status, error) {
                    swalFire('خطا در ارسال درخواست!', 'لطفاً مجدداً تلاش کنید.', 'error', 'بستن');
                    hideLoadingPopup();
                }
            });
        });
    } else if (pathname.includes('Posts')) {
        $('.delete-btn').click(function (e) {
            e.preventDefault();
            let $imageContainer = $(this).closest('.image-container');
            let $image = $imageContainer.find('.other-image');
            let imageId = $image.data('id');

            Swal.fire({
                title: 'آیا مطمئن هستید؟',
                text: 'تصویر انتخاب شده برای همیشه حذف خواهد شد!',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'خیر',
                confirmButtonText: 'بله',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'DELETE',
                        url: '/Posts/destroyImage/' + imageId,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function (response) {
                            if (response.status === 'success') {
                                $imageContainer.remove(); // حذف والدین تصویر
                                swalFire('عملیات موفقیت آمیز بود!', 'تصویر با موفقیت حذف شد.', 'success', 'بستن');
                            } else {
                                swalFire('عملیات با شکست مواجه شد!', 'دوباره تلاش کنید.', 'error', 'بستن');
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error('Error:', error);
                            swalFire('خطا در ارسال درخواست!', 'لطفاً مجدداً تلاش کنید.', 'error', 'بستن');
                        }
                    });
                }
            });
        });
    } else if (pathname.includes('DocumentClasses')) {
        $('#new_topic').click(function () {
            let newInput = `
                    <div class="topic flex">
                        <div class="w-full mr-2">
                            <label for=""
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">سرفصل
                            </label>
                            <input type="text" name="topics[]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="سرفصل جدید را وارد کنید" required>
                       </div>
                        <div class="w-full mr-2">
                            <label for=""
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">لینک آپارات
                            </label>
                            <input type="text" name="aparats[]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="لینک فیلم را وارد کنید" required>
                       </div>
                        <div class="w-full mt-7 mr-2">
                           <button type="button"
                                class="mt-3 w-96 inline-flex justify-center px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring focus:border-red-300 sm:mt-0 sm:w-auto delete-topic">
                                حذف
                           </button>
                       </div>
                    </div>
                `;
            $('#topicsContainer').append(newInput);
        });
        $(document).on('click', '.delete-topic', function () {
            $(this).closest('.topic').remove();
        });
        $('#teacher').change(function (e) {
            $.ajax({
                type: 'GET',
                url: '/Teachers/' + $(this).val(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (response) {
                    if (response.image_url) {
                        $('#master_image').attr('src', response.image_url).show();
                    } else {
                        $('#master_image').hide();
                    }
                },
                error: function (xhr, status, error) {
                    swalFire('خطا در ارسال درخواست!', 'لطفاً مجدداً تلاش کنید.', 'error', 'بستن');
                }
            });
        });
    } else if (pathname.includes('Notes')) {
        $('#new_footnote').click(function () {
            let newInput = `
                                <div class="footnote flex">
                                    <div class="w-full">
                                        <label for=""
                                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">پاورقی
                                        </label>
                                        <input type="text" id="footnote0" name="footnotes[]" value=""
                                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                               placeholder="پاورقی را وارد کنید (نیازی به وارد کردن شماره در ابتدای آن نیست)">
                                    </div>
                                    <div class="w-full mt-7 mr-2">
                                        <button type="button"
                                                class="mt-3 w-96 inline-flex justify-center px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring focus:border-red-300 sm:mt-0 sm:w-auto delete-footnote">
                                            حذف
                                        </button>
                                    </div>
                                </div>
                `;
            $('#footnotesContainer').append(newInput);
        });

        $(document).on('click', '.delete-footnote', function () {
            $(this).closest('.footnote').remove();
        });
    } else if (pathname.includes('Permissions')) {
    } else if (pathname.includes('Roles')) {
    } else if (pathname.includes('PictureAlbum')) {
        $('#date').persianDatepicker({
            format: 'YYYY/MM/DD',
            "viewMode": "day",
            "initialValue": false,
            "autoClose": false,
            "position": "auto",
            "altFormat": "lll",
            "altField": "#altfieldExample",
            "onlyTimePicker": false,
            "onlySelectOnDate": false,
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
                        "en": ""
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
            "dayPicker": {
                "enabled": true,
                "titleFormat": "MMMM"
            },
            "monthPicker": {
                "enabled": true,
                "titleFormat": "MMMM"
            },
            "yearPicker": {
                "enabled": true,
                "titleFormat": "YYYY"
            },
            "responsive": true,
        });
    } else {
        switch (pathname) {
            case '/dashboard':
                break;
            case "/Profile":
                resetFields();
                $('#change-password').submit(function (e) {
                    e.preventDefault();
                    let form = $(this);
                    let data = form.serialize();

                    $.ajax({
                        type: 'POST', url: "/ChangePasswordInc", data: data, headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        }, success: function (response) {
                            if (response.success) {
                                swalFire('عملیات موفقیت آمیز بود!', response.errors.passwordChanged[0], 'success', 'بستن');
                                oldPass.value = '';
                                newPass.value = '';
                                repeatNewPass.value = '';
                            } else {
                                if (response.errors.oldPassNull) {
                                    swalFire('خطا!', response.errors.oldPassNull[0], 'error', 'تلاش مجدد');
                                } else if (response.errors.newPassNull) {
                                    swalFire('خطا!', response.errors.newPassNull[0], 'error', 'تلاش مجدد');
                                } else if (response.errors.repeatNewPassNull) {
                                    swalFire('خطا!', response.errors.repeatNewPassNull[0], 'error', 'تلاش مجدد');
                                } else if (response.errors.lowerThan8) {
                                    swalFire('خطا!', response.errors.lowerThan8[0], 'error', 'تلاش مجدد');
                                } else if (response.errors.higherThan12) {
                                    swalFire('خطا!', response.errors.higherThan12[0], 'error', 'تلاش مجدد');
                                } else if (response.errors.wrongRepeat) {
                                    swalFire('خطا!', response.errors.wrongRepeat[0], 'error', 'تلاش مجدد');
                                } else if (response.errors.wrongPassword) {
                                    swalFire('خطا!', response.errors.wrongPassword[0], 'error', 'تلاش مجدد');
                                } else {
                                    location.reload();
                                }
                            }
                        }, error: function (xhr, textStatus, errorThrown) {
                            // console.log(xhr);
                        }
                    });
                });
                $('#change-user-image').submit(function (e) {
                    e.preventDefault();
                    let form = $(this);
                    let formData = new FormData(form[0]);
                    $.ajax({
                        type: 'POST', url: "/ChangeUserImage", data: formData, headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }, contentType: false, processData: false, success: function (response) {
                            if (response.success) {
                                location.reload();
                            } else {
                                if (response.errors.wrongImage) {
                                    swalFire('خطا!', response.errors.wrongImage[0], 'error', 'تلاش مجدد');
                                } else {
                                    location.reload();
                                }
                            }
                        }, error: function (xhr, textStatus, errorThrown) {
                            // console.log(xhr);
                        }
                    });
                });
                break;
            case "/UserManager":
                resetFields();
                //Search In User Manager
                $('#search-Username-UserManager').on('input', function () {
                    let inputUsername = $('#search-Username-UserManager').val().trim().toLowerCase();
                    let type = $('#search-type-UserManager').val();
                    $.ajax({
                        url: '/Search', type: 'GET', data: {
                            username: inputUsername, type: type, work: 'UserManagerSearch'
                        }, success: function (data) {
                            let tableBody = $('.w-full.border-collapse.rounded-lg.overflow-hidden.text-center tbody');
                            tableBody.empty();

                            data.forEach(function (user) {
                                let row = '<tr class="bg-white"><td class="px-6 py-4">' + user.username + '</td><td class="px-6 py-4">' + user.name + ' ' + user.family + '</td><td class="px-6 py-4">' + user.subject + '</td>';
                                if (user.active == 1) {
                                    row += '<td class="px-6 py-4">' + '<button type="submit" data-username="' + user.username + '" class="px-2 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring focus:border-blue-300 ASUM" data-active="1">غیرفعال‌سازی</button>';
                                } else if (user.active == 0) {
                                    row += '<td class="px-6 py-4">' + '<button type="submit" data-username="' + user.username + '" class="px-2 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300 ASUM" data-active="0">فعال‌سازی</button>';
                                }
                                row += '</td>';
                                if (user.ntcp == 1) {
                                    row += '<td class="px-6 py-4">' + '<button type="submit" data-ntcp-username="' + user.username + '" class="px-2 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring focus:border-blue-300 ntcp" data-ntcp="1">می باشد</button>';
                                } else if (user.ntcp == 0) {
                                    row += '<td class="px-6 py-4">' + '<button type="submit" data-ntcp-username="' + user.username + '" class="px-2 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300 ntcp" data-ntcp="0">نمی باشد</button>';
                                }
                                row += '</td>';
                                row += '<td class="px-6 py-4">' + '<button type="submit" data-rp-username="' + user.username + '" class="px-2 py-2 p-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300 rp">بازنشانی رمز</button>';
                                row += '</td>';
                                row += '</tr>';
                                tableBody.append(row);
                            });
                        }, error: function () {
                            console.log('خطا در ارتباط با سرور');
                        }
                    });
                });
                $('#search-type-UserManager').on('change', function () {
                    let inputUsername = $('#search-Username-UserManager').val().trim().toLowerCase();
                    let type = $('#search-type-UserManager').val();
                    $.ajax({
                        url: '/Search', type: 'GET', data: {
                            username: inputUsername, type: type, work: 'UserManagerSearch'
                        }, success: function (data) {
                            let tableBody = $('.w-full.border-collapse.rounded-lg.overflow-hidden.text-center tbody');
                            tableBody.empty();

                            data.forEach(function (user) {
                                let row = '<tr class="bg-white"><td class="px-6 py-4">' + user.username + '</td><td class="px-6 py-4">' + user.name + ' ' + user.family + '</td><td class="px-6 py-4">' + user.subject + '</td>';
                                if (user.active == 1) {
                                    row += '<td class="px-6 py-4">' + '<button type="submit" data-username="' + user.username + '" class="px-2 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring focus:border-blue-300 ASUM" data-active="1">غیرفعال‌سازی</button>';
                                } else if (user.active == 0) {
                                    row += '<td class="px-6 py-4">' + '<button type="submit" data-username="' + user.username + '" class="px-2 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300 ASUM" data-active="0">فعال‌سازی</button>';
                                }
                                row += '</td>';
                                if (user.ntcp == 1) {
                                    row += '<td class="px-6 py-4">' + '<button type="submit" data-ntcp-username="' + user.username + '" class="px-2 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring focus:border-blue-300 ntcp" data-ntcp="1">می باشد</button>';
                                } else if (user.ntcp == 0) {
                                    row += '<td class="px-6 py-4">' + '<button type="submit" data-ntcp-username="' + user.username + '" class="px-2 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300 ntcp" data-ntcp="0">نمی باشد</button>';
                                }
                                row += '</td>';
                                row += '<td class="px-6 py-4">' + '<button type="submit" data-rp-username="' + user.username + '" class="px-2 py-2 p-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300 rp">بازنشانی رمز</button>';
                                row += '</td>';
                                row += '</tr>';
                                tableBody.append(row);
                            });
                        }, error: function () {
                            console.log('خطا در ارتباط با سرور');
                        }
                    });
                });
                $('.absolute.inset-0.bg-gray-500.opacity-75.add').on('click', function () {
                    toggleModal(newUserModal.id)
                });
                $('.absolute.inset-0.bg-gray-500.opacity-75.edit').on('click', function () {
                    toggleModal(editUserModal.id)
                });
                //Activation Status In User Manager
                $(document).on('click', '.ASUM', function (e) {
                    const username = $(this).data('username');
                    const active = $(this).data('active');
                    let status = null;
                    if (active == 1) {
                        status = 'غیرفعال';
                    } else if (active == 0) {
                        status = 'فعال';
                    }
                    e.preventDefault();
                    Swal.fire({
                        title: 'آیا مطمئن هستید؟',
                        text: 'کاربر انتخاب شده ' + status + ' خواهد شد.',
                        icon: 'warning',
                        showCancelButton: true,
                        cancelButtonText: 'خیر',
                        confirmButtonText: 'بله',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: 'POST', url: '/ChangeUserActivationStatus', headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, data: {
                                    username: username,
                                }, success: function (response) {
                                    if (response.success) {
                                        swalFire('عملیات موفقیت آمیز بود!', response.message.changedUserActivation[0], 'success', 'بستن');
                                        const activeButton = $(`button[data-username="${username}"]`);
                                        if (active == 1) {
                                            activeButton.removeClass('bg-red-500').addClass('bg-green-500');
                                            activeButton.removeClass('hover:bg-red-600').addClass('hover:bg-green-600');
                                            activeButton.text('فعال‌سازی');
                                            activeButton.data('active', 0);
                                        } else if (active == 0) {
                                            activeButton.removeClass('bg-green-500').addClass('bg-red-500');
                                            activeButton.removeClass('hover:bg-green-600').addClass('hover:bg-red-600');
                                            activeButton.text('غیرفعال‌سازی');
                                            activeButton.data('active', 1);
                                        }
                                    } else {
                                        swalFire('خطا!', response.errors.changedUserActivationFailed[0], 'error', 'تلاش مجدد');
                                    }
                                }
                            });
                        }
                    });
                });
                //NTCP Status In User Manager
                $(document).on('click', '.ntcp', function (e) {
                    const username = $(this).data('ntcp-username');
                    const NTCP = $(this).data('ntcp');
                    let status = null;
                    if (NTCP == 1) {
                        status = 'نمی باشد';
                    } else if (NTCP == 0) {
                        status = 'می باشد';
                    }
                    e.preventDefault();
                    Swal.fire({
                        title: 'آیا مطمئن هستید؟',
                        text: 'کاربر انتخاب شده نیازمند تغییر رمزعبور ' + status + '؟',
                        icon: 'warning',
                        showCancelButton: true,
                        cancelButtonText: 'خیر',
                        confirmButtonText: 'بله',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: 'POST', url: '/ChangeUserNTCP', headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, data: {
                                    username: username,
                                }, success: function (response) {
                                    if (response.success) {
                                        swalFire('عملیات موفقیت آمیز بود!', response.message.changedUserNTCP[0], 'success', 'بستن');
                                        const ntcpButton = $(`button[data-ntcp-username="${username}"]`);
                                        if (NTCP == 1) {
                                            ntcpButton.removeClass('bg-red-500').addClass('bg-green-500');
                                            ntcpButton.removeClass('hover:bg-red-600').addClass('hover:bg-green-600');
                                            ntcpButton.text('نمی باشد');
                                            ntcpButton.data('ntcp', 0);
                                        } else if (NTCP == 0) {
                                            ntcpButton.removeClass('bg-green-500').addClass('bg-red-500');
                                            ntcpButton.removeClass('hover:bg-green-600').addClass('hover:bg-red-600');
                                            ntcpButton.text('می باشد');
                                            ntcpButton.data('ntcp', 1);
                                        }
                                    } else {
                                        swalFire('خطا!', response.errors.changedUserNTCPFailed[0], 'error', 'تلاش مجدد');
                                    }
                                }
                            });
                        }
                    });
                });
                //Reset Password In User Manager
                $(document).on('click', '.rp', function (e) {
                    const username = $(this).data('rp-username');
                    let status = null;

                    e.preventDefault();
                    Swal.fire({
                        title: 'آیا مطمئن هستید؟',
                        text: 'رمز عبور کاربر انتخاب شده به 12345678 بازنشانی خواهد شد.',
                        icon: 'warning',
                        showCancelButton: true,
                        cancelButtonText: 'خیر',
                        confirmButtonText: 'بله',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: 'POST', url: '/ResetPassword', headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, data: {
                                    username: username,
                                }, success: function (response) {
                                    if (response.success) {
                                        swalFire('عملیات موفقیت آمیز بود!', response.message.passwordResetted[0], 'success', 'بستن');
                                    } else {
                                        swalFire('خطا!', response.errors.resetPasswordFailed[0], 'error', 'تلاش مجدد');
                                    }
                                }
                            });
                        }
                    });
                });
                //Showing Or Hiding Modal
                $('#new-user-button, #cancel-new-user').on('click', function () {
                    toggleModal(newUserModal.id);
                });
                $('#edit-user-button, #cancel-edit-user').on('click', function () {
                    toggleModal(editUserModal.id);
                });
                //New User
                $('#new-user').submit(function (e) {
                    e.preventDefault();
                    let name = document.getElementById('name').value;
                    let family = document.getElementById('family').value;
                    let username = document.getElementById('username').value;
                    let password = document.getElementById('password').value;
                    let type = document.getElementById('type').value;

                    if (name.length === 0) {
                        swalFire('خطا!', 'نام وارد نشده است.', 'error', 'تلاش مجدد');
                    } else if (family.length === 0) {
                        swalFire('خطا!', 'نام وارد نشده است.', 'error', 'تلاش مجدد');
                    } else if (!hasOnlyPersianCharacters(name)) {
                        swalFire('خطا!', 'نام نمی تواند مقدار غیر از کاراکتر فارسی یا عدد داشته باشد.', 'error', 'تلاش مجدد');
                    } else if (!hasOnlyPersianCharacters(family)) {
                        swalFire('خطا!', 'نام خانوادگی نمی تواند مقدار غیر از کاراکتر فارسی یا عدد داشته باشد.', 'error', 'تلاش مجدد');
                    } else if (username.length === 0) {
                        swalFire('خطا!', 'نام کاربری وارد نشده است.', 'error', 'تلاش مجدد');
                    } else if (password.length === 0) {
                        swalFire('خطا!', 'رمز عبور وارد نشده است.', 'error', 'تلاش مجدد');
                    } else if (type.length === 0) {
                        swalFire('خطا!', 'نوع کاربری انتخاب نشده است.', 'error', 'تلاش مجدد');
                    } else if (hasOnlyPersianCharacters(username)) {
                        swalFire('خطا!', 'نام کاربری نمی تواند مقدار فارسی داشته باشد.', 'error', 'تلاش مجدد');
                    } else {
                        let form = $(this);
                        let data = form.serialize();

                        $.ajax({
                            type: 'POST', url: '/NewUser', data: data, headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, success: function (response) {
                                if (response.errors && response.errors.userFounded) {
                                    swalFire('خطا!', response.errors.userFounded[0], 'error', 'تلاش مجدد');
                                } else if (response.success) {
                                    swalFire('عملیات موفقیت آمیز بود!', response.message.userAdded[0], 'success', 'بستن');
                                    toggleModal(newUserModal.id);
                                    resetFields();
                                }

                            }
                        });
                    }
                });
                //Getting User Information
                $('#userIdForEdit').change(function (e) {
                    e.preventDefault();
                    if (userIdForEdit.value === null || userIdForEdit.value === '') {
                        swalFire('خطا!', 'کاربر انتخاب نشده است.', 'error', 'تلاش مجدد');
                    } else {
                        $.ajax({
                            type: 'GET', url: '/GetUserInfo', data: {
                                userID: userIdForEdit.value
                            }, success: function (response) {
                                userEditDiv.hidden = false;
                                editedName.value = response.name;
                                editedFamily.value = response.family;
                                editedType.value = response.type;
                            }
                        });
                    }
                });
                //Edit User
                $('#edit-user').submit(function (e) {
                    e.preventDefault();
                    let userID = userIdForEdit.value;
                    let name = editedName.value;
                    let family = editedFamily.value;
                    let type = editedType.value;

                    if (name.length === 0) {
                        swalFire('خطا!', 'نام وارد نشده است.', 'error', 'تلاش مجدد');
                    } else if (family.length === 0) {
                        swalFire('خطا!', 'نام خانوادگی وارد نشده است.', 'error', 'تلاش مجدد');
                    } else if (!hasOnlyPersianCharacters(name)) {
                        swalFire('خطا!', 'نام نمی تواند مقدار غیر از کاراکتر فارسی یا عدد داشته باشد.', 'error', 'تلاش مجدد');
                    } else if (!hasOnlyPersianCharacters(family)) {
                        swalFire('خطا!', 'نام نمی تواند مقدار غیر از کاراکتر فارسی یا عدد داشته باشد.', 'error', 'تلاش مجدد');
                    } else if (userID.length === 0) {
                        swalFire('خطا!', 'کاربر انتخاب نشده است.', 'error', 'تلاش مجدد');
                    } else if (type.length === 0) {
                        swalFire('خطا!', 'نوع کاربری انتخاب نشده است.', 'error', 'تلاش مجدد');
                    } else {
                        let form = $(this);
                        let data = form.serialize();

                        $.ajax({
                            type: 'POST', url: '/EditUser', data: data, headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, success: function (response) {
                                if (response.errors && response.errors.userFounded) {
                                    swalFire('خطا!', response.errors.userFounded[0], 'error', 'تلاش مجدد');
                                } else if (response.success) {
                                    swalFire('عملیات موفقیت آمیز بود!', response.message.userEdited[0], 'success', 'بستن');
                                    toggleModal(editUserModal.id);
                                    resetFields();
                                }

                            }
                        });
                    }
                });
                break;
            case '/BackupDatabase':
                $('#create-backup').on('click', function (e) {
                    e.preventDefault();
                    showLoadingPopup();
                    $.ajax({
                        type: 'POST', url: '/BackupDatabase', headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        }, success: function (response) {
                            if (response.errors) {
                                if (response.errors.error) {
                                    swalFire('خطا!', response.errors.error[0], 'error', 'تلاش مجدد');
                                }
                            } else {
                                location.reload();
                            }
                        }
                    });
                });

                break;
        }
    }
});
