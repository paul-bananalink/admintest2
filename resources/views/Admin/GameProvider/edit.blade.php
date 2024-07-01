@extends('Admin.GameProvider.page')
@section('content-game-provider')
    @include('Admin.Common.breadcrumb', ['breadcrumbs' => [
        [
            'title' => '게임업체',
            'href' => route('admin.game-provider.index'),
        ],
        [
            'title' => $data->gpName,
        ],
    ]])
    <!-- BEGIN Main Content -->
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-title">
                    <h3 class="cst_h3"><i class="fa fa-file"></i>{{ $data->gpName }}</h3>
                </div>
                <div class="box-content">
                    @include("Admin.Common.error_message")
                    <form action="{{ route('admin.game-provider.update', ['id' => $data->gpNo]) }}" class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-3 col-lg-2 control-label">이름</label>
                            <div class="col-sm-9 col-lg-10 controls">
                                <input type="text" class="form-control" value="{{ $data->gpName }}" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 col-lg-2 control-label">이미지 업로드</label>
                            <div class="col-sm-9 col-lg-10 controls">
                                <div id="avatar-upload" class="fileupload {{ $data->gpAvatar ? 'fileupload-exists' : 'fileupload-new' }}" data-provides="fileupload">
                                    <div class="fileupload-new img-thumbnail" style="width: 200px; height: 150px;">
                                        <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="">
                                    </div>
                                    <div id="fileupload-preview" class="fileupload-preview fileupload-exists img-thumbnail" style="width: 200px; height: 200px; overflow: hidden; position: relative;">
                                        @if ($data->gpAvatar)
                                            <img src="{{ $data->getImage() }}" style="width: 100%; height: 100%; object-fit: contain; position: absolute; top: 0; left: 0;">
                                        @endif
                                    </div>
                                    <div>
                                        <span class="btn btn-default btn-file">
                                            <span class="fileupload-new" id="select-image">이미지를 선택</span>
                                            <span class="fileupload-exists" id="select-image-change">수정</span>
                                        </span>
                                        {{-- <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a> --}}
                                    </div>
                                    <input type="hidden" name="image_upload" value="{{ $data->gpAvatar }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 col-lg-2 control-label"></label>
                            <div class="col-sm-9 col-lg-10 controls">
                                <button type="submit" class="btn btn-primary">저장</button>
                                <a href="{{ route('admin.game-provider.index') }}" class="btn">취소</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END Main Content -->
@endsection

