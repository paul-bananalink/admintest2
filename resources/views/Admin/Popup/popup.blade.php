<div class="col-md-4">
    <div class="box-content box-popup pop-{{$item->poNo}}">
        <form action="#" method="post" id="createPopup{{ $item->poNo }}">
            @csrf
            <div class="form-group flex-input">
                <x-common.toggle_switch_button
                        content="팝업창 / 사용여부: "
                        isCheck="{{ $item->poUsed }}"
                        left="true"
                        urlAction="{{route('admin.popup.enable-disable', ['poNo' => $item->poNo, 'field' => 'poUsed'])}}"
                    />
                <x-common.toggle_switch_button
                    content="로그인전사용: "
                    isCheck="{{ $item->poLoggined }}"
                    left="true"
                    urlAction="{{route('admin.popup.enable-disable', ['poNo' => $item->poNo, 'field' => 'poLoggined'])}}"
                />
                <div class="text-right">
                    <button class="btnstyle1 btnstyle1-success h-31 mr-4 update" data-action="{{route('admin.popup.update', ['id' => $item->poNo])}}" data-item="{{$item->poNo}}">내용저장</button>
                    <button class="btnstyle1 btnstyle1-inverse4 h-33 cancel-btn" data-action="{{route('admin.popup.delete', ['poNo' => $item->poNo])}}"><i class="fa fa-close"></i></button>
                </div>
            </div>

            <div class="group-item d-flex">
                <div class="mr-32"><span class="mr-12">상단여백 :</span><input type="text" class="h-33"></div>
                <div><span class="mr-12">좌촉여백 :</span><input type="text" class="h-33"></div>
            </div>

            <div class="form-group flex-input gap-30">
                <div class="d-flex items-center flex-1">
                    <label class="control-label w-1-4">링크주소 :</label>
                    <div class="controls w-3-4">
                        <input class="form-control" name="poLink" type="text" value="{{ old('poLink', $item->poLink) }}">
                    </div>
                </div>
                <div class="d-flex items-center">
                    <x-common.toggle_switch_button
                        content="새탭여부 :"
                        isCheck="{{ $item->poOpenNewWindow }}"
                        urlAction=""
                        left="true"
                    />
                </div>
            </div>

            <div class="form-group">
                <x-common.toggle_switch_button
                    content="새창여부 :"
                    isCheck="{{ $item->poOpenNewWindow }}"
                    urlAction="{{route('admin.popup.enable-disable', ['poNo' => $item->poNo, 'field' => 'poOpenNewWindow'])}}"
                    left="true"
                />
            </div>
            
            <div class="form-group">
                <div class="controls">
                    <textarea id="js__editor-{{ $item->poNo }}" name="poContent" rows="10" class="form-control">
                        {{ old('poContent', $item->poContent) }}
                    </textarea>
                </div>
            </div>

            <div class="form-group">
                <div class="d-flex items-center">
                    <div class="text-light mr-32">이미지 : </div>
                    <div id="image-{{$item->poNo}}" class="fileupload"
                        data-provides="fileupload" data-no="{{$item->poNo}}">
                        <div id="fileupload-preview-{{$item->poNo}}"
                            class="fileupload-preview fileupload-exists input-file">
                            @if (!empty($item->poImage))
                                <img src="{{ formatImageUrlApi($item->poImage) }}" class="input-file"
                                    alt="">
                            @endif
                        </div>
                        <input type="hidden" class="image-upload-{{$item->poNo}}"
                            name="poImage"
                            value="{{ $data['mobile_icons']->dpData[$i]['image'] ?? 'x' }}">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>