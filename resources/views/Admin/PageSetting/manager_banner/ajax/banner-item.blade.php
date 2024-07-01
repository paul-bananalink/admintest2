@php $uniqid = uniqid() @endphp
<div class="row box-content box-popup" id="banner-{{ $uniqid }}">
    <div class="col-md-4">
        <div class="form-group flex-input">
            <label class="control-label w-1-4">
                <font style="vertical-align: inherit;">
                    <font style="vertical-align: inherit;">배너</font>
                </font>
            </label>
            <div class="controls w-1-4">
                <div id="banner-upload-{{ $uniqid }}" class="fileupload fileupload-new" data-provides="fileupload" data-no="{{ $uniqid }}">
                    <div class="fileupload-new img-thumbnail" style="width: 200px; height: 150px;">
                        <img src="https://via.placeholder.com/200x150/EFEFEF/AAAAAA&text=no+image" alt="image">
                    </div>
                    <div id="fileupload-preview-{{ $uniqid }}" class="fileupload-preview fileupload-exists img-thumbnail" style="max-width: 200px; max-height: 150px; line-height: 10px;"></div>
                    <div>
                        <span class="btn btn-default btn-file">
                            <span class="fileupload-new" id="select-image">이미지를 선택</span>
                            <span class="fileupload-exists" id="select-image-change">수정</span>
                        </span>
                    </div>
                    {{-- <input type="hidden" name="image_upload" value="{{ $item->bImage }}"> --}}
                    <input type="hidden" class="image_upload_{{ $uniqid }}" name="data[{{ $uniqid }}][bImage]" value="">
                </div>
            </div>
            <label class="control-label w-1-4"></label>
            <div class="controls w-1-4">
                <x-common.toggle_switch_button
                    content="open"
                    isCheck="true"
                    name="data[{{ $uniqid }}][bStatus]"
                    id="bStatus"
                    offToggle="true"
                />
            </div>
        </div>
        <div class="form-group flex-input">
            <label class="control-label w-1-4">
                <font style="vertical-align: inherit;">
                    <font style="vertical-align: inherit;">링크</font>
                </font>
            </label>
            <div class="controls w-3-4">
                <input class="form-control" type="text" name="data[{{ $uniqid }}][bLink]">
            </div>
        </div>
        <div class="form-group flex-input">
            <label class="control-label w-1-4">
                <font style="vertical-align: inherit;">
                    <font style="vertical-align: inherit;">Target</font>
                </font>
            </label>
            <div class="controls w-3-4">
                <select class="form-control" name="data[{{ $uniqid }}][bTarget]" tabindex="1" required>
                    <option value="_blank">새창</option>
                    <option value="_self">현재</option>
                </select>
            </div>
        </div>
    </div>
    <div class="btn-toolbar pull-right">
        <div class="btn-group">
            <button type="button" class="remove-banner-btn btn btn-circle btn-danger show-tooltip btn-xlarge" data-no="{{ $uniqid }}">
                <i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
</div>