import './bootstrap';
import '@fortawesome/fontawesome-free/css/all.css';
import $ from 'jquery';
import Swal from 'sweetalert2';

window.Swal = Swal;

$(document).ready(function () {
    reloadCaptcha();
});

function swalFire(text, icon, confirmButtonText, title = null) {
    Swal.fire({
        title: title, text: text, icon: icon, confirmButtonText: confirmButtonText,
    });
}

function reloadCaptcha() {
    var captchaImg = document.getElementById('captchaImg');
    var captchaUrl = "/captcha";
    captchaImg.src = captchaUrl + '?' + Date.now();
}

$('#reloadCaptcha').click(function () {
    reloadCaptcha();
});

function loaderSpinner() {
    $('#loader').toggleClass('hidden');
}

//Check Login Form
$('#loginForm').submit(function (e) {
    e.preventDefault();
    loaderSpinner();
    let form = $(this);
    let url = form.attr('action');
    let data = form.serialize();

    $.ajax({
        type: 'POST', url: url, data: data, headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }, success: function (response) {
            if (response.success) {
                localStorage.setItem('selectedTab', 1);
                window.location.href = response.redirect;
            } else {
                if (response.errors.username) {
                    swalFire('تلاش مجدد', response.errors.username[0], 'error', 'خطای نام کاربری');
                    reloadCaptcha();
                    captcha.value = '';
                }

                if (response.errors.password) {
                    swalFire('تلاش مجدد', response.errors.password[0], 'error', 'خطای رمز عبور');
                    reloadCaptcha();
                    captcha.value = '';
                }

                if (response.errors.captcha) {
                    swalFire('تلاش مجدد', response.errors.captcha[0], 'error', 'کد امنیتی نامعتبر');
                    reloadCaptcha();
                    captcha.value = '';
                }
                if (response.errors.loginError) {
                    swalFire('تلاش مجدد', response.errors.loginError[0], 'error', 'نام کاربری یا رمز عبور نامعتبر');
                    reloadCaptcha();
                    captcha.value = '';
                }
                loaderSpinner();
            }
        }, error: function (xhr, textStatus, errorThrown) {
            if (xhr.responseJSON['YouAreLocked']) {
                swalFire('تایید', 'آی پی شما به دلیل تعداد درخواست های زیاد بلاک شده است. لطفا یک ساعت دیگر مجددا تلاش کنید.', 'error', 'دسترسی غیرمجاز');
                const fields = [username, password, captcha];
                fields.forEach(field => {
                    field.disabled = true;
                    field.value = null;
                    field.style.backgroundColor = 'gray';
                });
            } else {
                swalFire('تلاش مجدد', 'ارتباط با سرور برقرار نشد.', 'error', 'خطای ناشناخته');
                console.clear();
            }
            loaderSpinner();

        }
    });
});
