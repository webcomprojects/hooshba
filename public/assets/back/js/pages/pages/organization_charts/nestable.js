// Nestable in general mode

$(document).ready(function () {

    var isDragging = false; // تشخیص اینکه کاربر در حال کشیدن است

    $(".nestable")
        .nestable({
            group: 1
        })
        .on("mousedown", function () {
            isDragging = false; // هنگام کلیک مقدار را false قرار می‌دهیم
        })
        .on("mousemove", function () {
            isDragging = true; // هنگام حرکت ماوس مقدار را true می‌کنیم
        })
        .on("change", function () {
            if (isDragging) { // فقط در صورتی که کشیدن انجام شده باشد، درخواست ارسال شود
                saveNewOrder();
            }
        });


    // Nestable for curve mode
    $(".nestable-list.curve").nestable({
        group: 1,
        dragClass: "dd-dragel curve"
    });

    // Nestable for round mode
    $(".nestable-list.round").nestable({
        group: 1,
        dragClass: "dd-dragel round"
    });

    // Nestable via output preview


    function saveNewOrder() {

        var serializedData = $(".nestable").nestable("serialize");

        var formData = new FormData();
        formData.append("organizationCharts", JSON.stringify(serializedData));

        $.ajax({
            url: BASE_URL + "admin/about-us/organization-chart/update-ordering",
            type: 'POST',
            data: formData,
            success: function (response) {
                // toaster.success('دسته‌بندی‌ها با موفقیت به‌روز شدند!');
            },
            beforeSend: function (xhr) {
                blockUi('.edit-form');
                xhr.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
            },
            complete: function () {
                unblockUi('.edit-form');
            },
            cache: false,
            contentType: false,
            processData: false
        });


    }

    $('.edit-category-item').click(function () {
        getCategory($(this)); // $(this) را به عنوان یک شیء jQuery ارسال می‌کنیم
    });

    function getCategory(item) {

        $.ajax({
            url: item.data('data'),
            type: 'GET',
            success: function (response) {

                $('#edit-category-form').attr('action', item.data('action'));
                $('#edit-category-form input[name=name]').val(response.name);
                $('#edit-category-form textarea[name=description]').val(response.description);
                $('#province').val(response.province_id).change();
            },
            beforeSend: function (xhr) {
                $('#edit-category-form input[name=name]').val(' ');
                $('#edit-category-form textarea[name=description]').val(' ');
                blockUi('#edit-category-modal .modal-footer');
                xhr.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
            },
            complete: function () {
                unblockUi('#edit-category-modal .modal-footer');
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }


});


