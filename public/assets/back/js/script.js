// Checkboxes
$(document).on('ifChanged', 'input#btn-check-all-toggle', function (event) {
    var isChecked = $("#btn-check-all-toggle").prop("checked");
    if(isChecked){
        $("table td input[type='checkbox']").iCheck("check").iCheck("update");
    }else{
        $("table td input[type='checkbox']").iCheck("uncheck").iCheck("update");
    }
});

$('.multiple-delete-modal').click(function () {
    let item=this;
    let action=$(item).attr('data-action');
    $('#multiple-delete-modal').find('#multiple-delete-form').attr('action',action)

    var ids = [];
    $('input.item-checked:checked').each(function(index, item) {
        var id = $(item).val(); // مقدار تیک خورده فعلی را بگیرید
        ids.push(id);
    });
    $('#multiple-delete-modal #multiple-delete-form input[name=ids]').val(ids);
});

$(document).on('ifChanged', 'input.item-checked', function (event) {
    var isChecked =  $('input.item-checked:checked').length;
    if(isChecked > 0) {
        $('#datatable-selected-rows').text(isChecked)
        $('.datatable-actions').slideDown('show');
    }else {
        $('.datatable-actions').slideUp('show');
    }
});

$('.delete-modal').click(function () {
    let item=this;
    let action=$(item).attr('data-action');
    $('#delete-modal').find('#delete-form').attr('action',action)
});

$('.btn-check-all-toggle').change(function() {
    var isChecked = $(this).prop("checked"); // وضعیت تیک زده شدن یا برداشته شدن چک باکس اصلی
    // یافتن تمامی چک باکس‌های داخل collapse و تغییر وضعیت آن‌ها بر اساس وضعیت چک باکس اصلی
    $(this).closest('.card').find('.collapse input[type="checkbox"]').prop('checked', isChecked);
});


$(document).ready(function() {
    var selectedColor = localStorage.getItem('selectedColor');
    if (selectedColor) {
        $("body").removeClass (function (index, css) {
            return (css.match (/(^|\s)theme-\S+/g) || []).join(" ");
        });
        $("body").addClass("theme-" + selectedColor);
        $(".theme-colors .btn").removeClass("active");
        $(".theme-colors .btn[data-color='" + selectedColor + "']").addClass("active");
    }

    var storedDarkMode = localStorage.getItem('darkMode');
    if (storedDarkMode) {
        var isDarkMode = (storedDarkMode === 'true');
        window.Modiran.darkMode(isDarkMode);
    }

    var storedBackground = localStorage.getItem('selectedBackground');
    if (storedBackground) {
        $("body").removeClass (function (index, css) {
            return (css.match (/(^|\s)bg-\d+/g) || []).join(" ");
        });
        $("body").addClass("bg-" + storedBackground);
        $(".sidebar-bg li").removeClass("active");
        $(".sidebar-bg li img[data-bg='" + storedBackground + "']").parent().addClass("active");
    }
});


$(document).ready(function() {
    $('#invitation-link-acceptor-copy-btn').click(function () {
        var copyText = $('input[name=invitation-link-acceptor]')[0];
        copyText.select();
        copyText.setSelectionRange(0, 99999); /* For mobile devices */

        document.execCommand('copy');
        notyObj = noty({
            text: copy_link_text,
            type: 'success',
            dismissQueue: true,
            timeout: 3000,
            layout: "bottomLeft",
            closeWith: ["click"],
            maxVisible: 10,
            theme: "flat"
        });

    })
});

function blockUi(selector) {
    $(selector).block({
        message: '',
        css: {
            border: 'none',
            padding: '10px',
            backgroundColor: '#000',
            '-webkit-border-radius': '10px',
            '-moz-border-radius': '10px',
            opacity: .7,
            color: '#fff'
        }
    });
}

function unblockUi(selector) {
    $(selector).unblock();
}