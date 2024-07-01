<!-- Modal-->
<div class="modal fade" id="{{$modal_id}}" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{$modal_title}}</h4>
            </div>
            <div class="modal-body">
                @include($modal_content_include_name)
            </div>
        </div>
    </div>
</div>
<!-- END Modal -->
