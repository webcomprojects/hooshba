// Nestable in general mode
$(".nestable").nestable({
    group: 1
}).on("change", function (e) {
    saveNewOrder();
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
    formData.append("categories", JSON.stringify(serializedData));

    $.ajax({
        url: BASE_URL+"admin/categories/update-ordering",
        type: 'POST',
        data: formData,
        success: function(response) {
           // toaster.success('دسته‌بندی‌ها با موفقیت به‌روز شدند!');
        },
        beforeSend: function(xhr) {
            blockUi('.edit-form');
            xhr.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
        },
        complete: function() {
            unblockUi('.edit-form');
        },
        cache: false,
        contentType: false,
        processData: false
    });


}

