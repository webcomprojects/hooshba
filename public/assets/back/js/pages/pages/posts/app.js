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
$(document).on('keydown', '.bootstrap-tagsinput input', function(event) {
    if (event.key === 'Enter') {
        event.preventDefault();
    }
});

CKEDITOR.replace('content');

// $('#tags').tagsInput({
//     defaultText: 'افزودن',
//     width: '100%',
//     autocomplete_url: BASE_URL + '/get-tags'
// });

