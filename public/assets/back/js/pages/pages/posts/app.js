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


$('#tags, select').on('change', function(event) {
    var $element = $(event.target),
      $container = $element.closest('.example');

    if (!$element.data('tagsinput'))
      return;

    var val = $element.val();
    if (val === null)
      val = "null";
    $('code', $('pre.val', $container)).html( ($.isArray(val) ? JSON.stringify(val) : "\"" + val.replace('"', '\\"') + "\"") );
    $('code', $('pre.items', $container)).html(JSON.stringify($element.tagsinput('items')));
  }).trigger('change');