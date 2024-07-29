import './bootstrap';
import '@fortawesome/fontawesome-free/css/all.css';
import $ from 'jquery';
import Swal from 'sweetalert2';
import Alpine from 'alpinejs'
import Intersect from '@alpinejs/intersect'
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
Alpine.plugin(Intersect)
Alpine.start()
window.Alpine = Alpine

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
    $('#backward_page').on('click', function () {
        window.history.back();
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

    let pathname = window.location.pathname;
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
                                // swalFire('عملیات موفقیت آمیز بود!', response.message.userAdded[0], 'success', 'بستن');
                                // toggleModal(newUserModal.id);
                                // resetFields();
                                location.reload();
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
                            editedBuilding.value = response.building;
                            editedRoomNumber.value = response.room_number;
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

                    showLoadingPopup();
                    $.ajax({
                        type: 'POST', url: '/EditUser', data: data, headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        }, success: function (response) {
                            if (response.errors && response.errors.userFounded) {
                                swalFire('خطا!', response.errors.userFounded[0], 'error', 'تلاش مجدد');
                            } else if (response.success) {
                                // swalFire('عملیات موفقیت آمیز بود!', response.message.userEdited[0], 'success', 'بستن');
                                // toggleModal(editUserModal.id);
                                // resetFields();
                                location.reload();
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
});
