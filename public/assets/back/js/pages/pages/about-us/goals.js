var indeExperiencesAi = $('.goals_item').length; // شمارش تعداد آیتم‌های موجود

$('#Add_goals_item').click(function () {

    var template = $('.goals_item').first().clone(); // کپی اولین آیتم
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
    template.prepend('<div class="btn btn-no-arrow btn-danger remove_btn_goals_item" style="float:left">حذف<i class="fa fa-solid fa-trash"></i></div>');
    template.prepend('<hr>');

    // اضافه کردن رویداد حذف به دکمه حذف
    template.find('.remove_btn_goals_item').click(function () {
        template.remove(); // حذف آیتم
    });

    // اضافه کردن آیتم جدید به #experiencesAi
    $('#goals_items').append(template);

    indeExperiencesAi++; // افزایش شمارنده
});

$('.remove_btn_goals_item').click(function () {
    $(this).parent('.goals_item').remove(); // حذف آیتم
});
