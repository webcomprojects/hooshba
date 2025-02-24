<div id="multiple-delete-modal" class="modal fade" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                <h4 class="modal-title">آیا مطمعن هستید؟</h4>
            </div><!-- /.modal-header -->
            <div class="modal-body">
                <p>{{@$text_body}}</p>
            </div><!-- /.modal-body -->
            <div class="modal-footer">
                <form action="#" id="multiple-delete-form" method="POST">
                    @csrf
                    <input name="ids" type="hidden">
                    <p class="text-right">
                        <button type="button" class="btn btn-success " data-bs-dismiss="modal">خیر</button>

                        <button type="submit" class="btn btn-danger ">بله، حذف شود</button>
                    </p>
                </form>
            </div><!-- /.modal-footer -->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
