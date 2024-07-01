<form action="#" class="form-horizontal">
    <div class="form-group">
        <label class="col-sm-3 col-lg-2 control-label">이미지 업로드</label>
        <div class="col-sm-9 col-lg-10 controls">
            <div id="avatar-upload" class="fileupload fileupload-exists" data-provides="fileupload">
                <div id="fileupload-preview" class="fileupload-preview fileupload-exists img-thumbnail" style="width: 200px; height: 200px; overflow: hidden; position: relative;">
                    <img src="http://via.placeholder.com/200x150/EFEFEF/AAAAAA?text=no%2Bimage" alt="no+image" style="width: 100%; height: 100%; object-fit: contain; position: absolute; top: 0; left: 0;">
                </div>
                <div>
                    <span class="btn btn-default btn-file">
                        <span class="fileupload-new" id="select-image">이미지를 선택</span>
                        <span class="fileupload-exists" id="select-image-change">수정</span>
                    </span>
                    
                </div>
                <input type="hidden" name="image_upload">
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 col-lg-2 control-label"></label>
        <div class="col-sm-9 col-lg-10 controls">
            <button type="button" class="btn btn-primary" id="button-edit-image">저장</button>
            <button class="btn btn-gray" data-dismiss="modal" aria-hidden="true">취소</button>
        </div>
    </div>
</form>
