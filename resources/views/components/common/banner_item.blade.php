<div class="row box-content box-popup" id="banner-{{ $item->bNo }}">
    <div class="col-md-4">
        <div class="form-group flex-input">
            <label class="control-label w-1-4">
                <font style="vertical-align: inherit;">
                    <font style="vertical-align: inherit;">배너</font>
                </font>
            </label>
            <div class="controls w-1-4">
                <div id="banner-upload-{{ $item->bNo }}" class="fileupload {{ $item->bImage ? 'fileupload-exists' : 'fileupload-new' }}" data-provides="fileupload" data-no={{ $item->bNo }}>
                    <div class="fileupload-new img-thumbnail" style="width: 200px; height: 150px;">
                        <img src="https://via.placeholder.com/200x150/EFEFEF/AAAAAA&text=no+image" alt="image">
                    </div>
                    <div id="fileupload-preview-{{ $item->bNo }}" class="fileupload-preview fileupload-exists img-thumbnail" style="max-width: 200px; max-height: 150px; line-height: 10px;">
                        @if ($item->bImage)
                            <img src="{{ $item->getImage() }}" style="max-height: 150px;">
                        @endif
                    </div>
                    <div>
                        <span class="btn btn-default btn-file">
                            <span class="fileupload-new" id="select-image">이미지를 선택</span>
                            <span class="fileupload-exists" id="select-image-change">수정</span>
                        </span>
                    </div>
                    <input type="hidden" class="image_upload_{{ $item->bNo }}" name="data[{{ $index }}][bImage]" value="{{ $item->bImage }}">
                    <input type="hidden" name="data[{{ $index }}][bNo]" value="{{ $item->bNo }}">
                </div>
            </div>
            <label class="control-label w-1-4"></label>
            <div class="controls w-1-4">
                <x-common.toggle_switch_button
                    content="open"
                    isCheck="{{ $item->bStatus }}"
                    name="data[{{ $index }}][bStatus]"
                    id="bStatus"
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
                <input class="form-control" type="text" name="data[{{ $index }}][bLink]" value="{{ $item->bLink }}">
            </div>
        </div>
        <div class="form-group flex-input">
            <label class="control-label w-1-4">
                <font style="vertical-align: inherit;">
                    <font style="vertical-align: inherit;">Target</font>
                </font>
            </label>
            <div class="controls w-3-4">
                <select class="form-control" name="data[{{ $index }}][bTarget]" tabindex="1" required>
                    <option value="_blank" @if ($item->bTarget == '_blank') selected @endif>새창</option>
                    <option value="_self" @if ($item->bTarget == '_self') selected @endif>현재</option>
                </select>
            </div>
        </div>
    </div>
    <div class="btn-toolbar pull-right">
        <div class="btn-group">
            <a href="#" class="btn btn-circle btn-danger show-tooltip btn-xlarge confirm-box" data-route="{{ route('admin.page-setting.manager-banner.delete', ['id' => $item->bNo]) }}"
                data-method="delete">
                <i class="fa fa-minus"></i>
            </a>
        </div>
    </div>
</div>