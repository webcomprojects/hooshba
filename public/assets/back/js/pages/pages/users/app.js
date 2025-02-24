$('.select-user-type select').change(function () {
    var value=$(this).val();
    if (value==="user"){
        $('.select-Agent-parent').removeClass('d-none');
    }else {
        $('.select-Agent-parent').addClass('d-none');
    }
})



function toggleRole() {
    var userType = $('select[name="level"]').val();

    if (userType === 'admin') {
        $('#userRoles').removeClass('d-none').find(':input').prop('disabled', false);
    } else {
        $('#userRoles').addClass('d-none').find(':input').prop('disabled', true);
    }
}

// اجرای تابع هنگام بارگذاری صفحه (برای مقادیر old)
toggleRole();

// اجرای تابع هنگام تغییر مقدار نوع عضویت
$('select[name="level"]').change(function () {
    toggleRole();
});