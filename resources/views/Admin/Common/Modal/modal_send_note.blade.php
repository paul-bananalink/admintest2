<div id="modal-send-note" class="modal fade">
    <form id="formSendNote" method="POST" action="{{route('admin.note.sendNoteToUser')}}">
        @csrf
        <div class="modal-dialog modal-lg" style="width: 1000px;">
            <div class="modal-content bg-black-darker">
                <div class="modal-header bg-black-darker6 text-light text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="modalLable">쪽지</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="control-label">제목</label>
                                <div class="controls">
                                    <input class="form-control title-note" name="title" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="control-label">내용</label>
                                <div class="controls">
                                    <textarea id="js__editor-noteUser" name="content" rows="5" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <input class="mNo_receive" type="hidden" name="mNo_receive">
                    </div>
                </div>
                <div class="modal-footer" style="border-top: none!important;">
                    <button class="btnstyle1 btnstyle1-white h-31" data-dismiss="modal" aria-hidden="true">취소</button>
                    <button type="submit" class="btnstyle1 btnstyle1-primary btnstyle1-xs text-white">보내기</button>
                </div>
            </div>
        </div>
    </form>
</div>
