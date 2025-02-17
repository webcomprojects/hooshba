$('textarea[name=experience_ai_description]').on('input', function () {

    var text = $(this).val();

    var words = text.split(/\s+/).filter(function (word) {
        return word.length > 0;
    }).length;

    $('#experience_ai_description_length').text('تعداد کلمات: ' + text.length);

    if (words > 550) {
        $(this).val(text.split(/\s+/).slice(0, 550).join(' '));
        $('#experience_ai_description_length').text('تعداد کلمات: 550 (حداکثر تعداد کلمات)');
    }
});


$('#publish_date_picker').pDatepicker({
    toolbox: {
        // enabled: true,
        calendarSwitch: {
            enabled: false
        }
    },
    initialValue: false,
    altField: '#publish_date',
    altFormat: 'YYYY-MM-DD',
    observer: true,
    format: 'YYYY-MM-DD',
    // onSelect: function (unixDate) {
    //     var date = $('#publish_date').val();
    //     $('#publish_date').val(date.toEnglishDigit());
    // }
});

$('.publish_date_picker').pDatepicker({
    toolbox: {
        // enabled: true,
        calendarSwitch: {
            enabled: false
        }
    },
    initialValue: false,
    altField: '#publish_date',
    altFormat: 'YYYY-MM-DD',
    observer: true,
    format: 'YYYY-MM-DD',
    // onSelect: function (unixDate) {
    //     var date = $('#publish_date').val();
    //     $('#publish_date').val(date.toEnglishDigit());
    // }
});


$(document).ready(function () {
    var indexEducational = $('.Educational_background_item').length; // تعداد آیتم‌های موجود

    $('#Add_educational_background').click(function () {
        var template = $('.Educational_background_item').first().clone(); // کپی اولین آیتم
        template.removeAttr('id'); // حذف ID
        template.css('display', 'block'); // نمایش آیتم جدید

        // مقدارهای قبلی را حذف کنیم
        template.find('input').val('');

        // تغییر `name` فیلدها برای ارسال درست داده‌ها
        template.find('input, select, textarea').each(function () {
            var oldName = $(this).attr('name');
            if (oldName) {
                var newName = oldName.replace(/\[\d+\]/, '[' + indexEducational + ']'); // جایگزینی ایندکس جدید
                $(this).attr('name', newName);
            }
        });

        // اضافه کردن دکمه حذف
        template.prepend('<button class="remove_btn_Educational_background_item btn btn-no-arrow"><i class="fa fa-solid fa-trash"></i></button>');
        template.prepend('<hr>');

        // اضافه کردن رویداد حذف به دکمه حذف
        template.find('.remove_btn_Educational_background_item').click(function () {
            template.remove(); // حذف آیتم
        });

        // اضافه کردن آیتم جدید به #Educational_background
        $('#Educational_background').append(template);

        indexEducational++; // افزایش شمارنده
    });

    $('.remove_btn_Educational_background_item').click(function () {
        $(this).parent('.Educational_background_item').remove();
    });


    var indexHistoryItem = $('.career_history_item').length; // شمارش تعداد آیتم‌های موجود

    $('#add_career_history_item').click(function () {
        var template = $('.career_history_item').first().clone(); // کپی اولین آیتم
        template.removeAttr('id'); // حذف ID
        template.css('display', 'block'); // نمایش آیتم جدید

        // مقدارهای قبلی را حذف کنیم
        template.find('input').val('');

        // تغییر `name` فیلدها برای ارسال درست داده‌ها
        template.find('input, select, textarea').each(function () {
            var oldName = $(this).attr('name');
            if (oldName) {
                var newName = oldName.replace(/\[\d+\]/, '[' + indexHistoryItem + ']'); // جایگزینی ایندکس جدید
                $(this).attr('name', newName);
            }
        });

        // اضافه کردن دکمه حذف
        template.prepend('<button class="remove_btn_career_history_item btn btn-no-arrow"><i class="fa fa-solid fa-trash"></i></button>');
        template.prepend('<hr>');

        // اضافه کردن رویداد حذف به دکمه حذف
        template.find('.remove_btn_career_history_item').click(function () {
            template.remove(); // حذف آیتم
        });

        // اضافه کردن آیتم جدید به #career_histories
        $('#career_histories').append(template);

        indexHistoryItem++; // افزایش شمارنده
    });

    $('.remove_btn_career_history_item').click(function () {
        $(this).parent('.career_history_item').remove(); // حذف آیتم
    });



    var indeExperiencesAi = $('.experiencesAi_item').length; // شمارش تعداد آیتم‌های موجود

    $('#add_experiencesAi_item').click(function () {
        var template = $('.experiencesAi_item').first().clone(); // کپی اولین آیتم
        template.removeAttr('id'); // حذف ID
        template.css('display', 'block'); // نمایش آیتم جدید

        // مقدارهای قبلی را حذف کنیم
        template.find('input, textarea, select').val('');

        // تغییر `name` فیلدها برای ارسال درست داده‌ها
        template.find('input, textarea, select').each(function () {
            var oldName = $(this).attr('name');
            if (oldName) {
                var newName = oldName.replace(/\[\d+\]/, '[' + indeExperiencesAi + ']'); // جایگزینی ایندکس جدید
                $(this).attr('name', newName);
            }
        });

        // اضافه کردن دکمه حذف
        template.prepend('<button class="remove_btn_experiencesAi_item btn btn-no-arrow"><i class="fa fa-solid fa-trash"></i></button>');
        template.prepend('<hr>');

        // اضافه کردن رویداد حذف به دکمه حذف
        template.find('.remove_btn_experiencesAi_item').click(function () {
            template.remove(); // حذف آیتم
        });

        // اضافه کردن آیتم جدید به #experiencesAi
        $('#experiencesAi').append(template);

        indeExperiencesAi++; // افزایش شمارنده
    });

    $('.remove_btn_experiencesAi_item').click(function () {
        $(this).parent('.experiencesAi_item').remove(); // حذف آیتم
    });



    var indexCorporateExperiencesAi = $('.corporate_experiencesAi_item').length; // شمارش تعداد آیتم‌های موجود

    $('#add_corporate_experiencesAi_item').click(function () {
        var template = $('.corporate_experiencesAi_item').first().clone(); // کپی اولین آیتم
        template.removeAttr('id'); // حذف ID
        template.css('display', 'block'); // نمایش آیتم جدید

        // مقدارهای قبلی را حذف کنیم
        template.find('input, textarea, select').val('');

        // تغییر `name` فیلدها برای ارسال درست داده‌ها
        template.find('input, textarea, select').each(function () {
            var oldName = $(this).attr('name');
            if (oldName) {
                var newName = oldName.replace(/\[\d+\]/, '[' + indexCorporateExperiencesAi + ']'); // جایگزینی ایندکس جدید
                $(this).attr('name', newName);
            }
        });

        // اضافه کردن دکمه حذف
        template.prepend('<button class="remove_btn_corporate_experiencesAi_item btn btn-no-arrow"><i class="fa fa-solid fa-trash"></i></button>');
        template.prepend('<hr>');

        // اضافه کردن رویداد حذف به دکمه حذف
        template.find('.remove_btn_corporate_experiencesAi_item').click(function () {
            template.remove(); // حذف آیتم
        });

        // اضافه کردن آیتم جدید به #experiencesAi
        $('#corporateExperiencesAi').append(template);

        indexCorporateExperiencesAi++; // افزایش شمارنده
    });

    $('.remove_btn_corporate_experiencesAi_item').click(function () {
        $(this).parent('.corporate_experiencesAi_item').remove(); // حذف آیتم
    });




  function toggleForms() {
        var userType = $('select[name="user_type"]').val();

        if (userType === 'individual') {
            $('#individualForm').removeClass('d-none').find(':input').prop('disabled', false);
            $('#corporateForm').addClass('d-none').find(':input').prop('disabled', true);
        } else {
            $('#corporateForm').removeClass('d-none').find(':input').prop('disabled', false);
            $('#individualForm').addClass('d-none').find(':input').prop('disabled', true);
        }
    }

    // اجرای تابع هنگام بارگذاری صفحه (برای مقادیر old)
    toggleForms();

    // اجرای تابع هنگام تغییر مقدار نوع عضویت
    $('select[name="user_type"]').change(function () {
        toggleForms();
    });

});