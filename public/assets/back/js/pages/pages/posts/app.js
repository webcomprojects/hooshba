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


CKEDITOR.replace('content');

$('#tags').tagsInput({
    defaultText: 'Ų§ŁŲ²ŁŲÆŁ†',
    width: '100%',
    autocomplete_url: BASE_URL + '/get-tags'
});
