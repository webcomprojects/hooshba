$(".select2").select2({
    rtl: true
});
$(".select2.round").select2({
    rtl: true,
    containerCssClass: "round"
});
$(".select2.curve").select2({
    rtl: true,
    containerCssClass: "curve"
});

$(".allow-cancel").select2({
    rtl: true,
    allowClear: true,
    placeholder: {
        id: "",
        placeholder: "..."
    }
});


function formatState (state) {
    if (!state.id) {
        return state.text;
    }
    var baseUrl = $('meta[name="baseUrl"]').attr('content')+'back/assets/css/flag-icon';
    var $state = $(
        '<span> <img style="float: left;margin-right: 5px;margin-top: 8px" width="20" src="' + baseUrl + '/' + state.element.value.toLowerCase() + '.svg" class="img-flag" /><span>' + state.text + '</span></span>'
    );



    return $state;
};

$(".select2-img").select2({
    width: '74px',
    minimumResultsForSearch: -1,
    templateResult: formatState
});
$('#change-language').change(function () {
    var lang=$('#change-language').val();
    var Title_lang=$('#select2-change-language-container').attr('title');
    $('#select2-change-language-container').html('<span> <img style="float: left;margin-right: 5px;margin-top: 8px" width="20" src="' + $('meta[name="baseUrl"]').attr('content')+'back/assets/css/flag-icon' + '/' + lang + '.svg" class="img-flag" /><span>' +Title_lang + '</span></span>')

    $(this).parents('form').submit();
})


var lang=$('#change-language').val();
var Title_lang=$('#select2-change-language-container').attr('title');
$('#select2-change-language-container').html('<span> <img style="float: left;margin-right: 5px;margin-top: 8px" width="20" src="' + $('meta[name="baseUrl"]').attr('content')+'back/assets/css/flag-icon' + '/' + lang + '.svg" class="img-flag" /><span>' +Title_lang + '</span></span>')
