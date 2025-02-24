
$(document).on('ifChanged', '.parent-permission', function (event) {
    var checked = $(this).prop('checked');
    var permissionId = $(this).data('id');

    var checked = $(this).prop('checked');
    if(checked){
        $('input[data-permission_id="' + permissionId + '"').iCheck("check").iCheck("update");
    }else{
        $('input[data-permission_id="' + permissionId + '"').iCheck("uncheck").iCheck("update");
    }
});
