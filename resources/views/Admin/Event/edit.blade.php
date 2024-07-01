@extends('Admin.Event.page')
@section('content-event')
    @include('Admin.Common.breadcrumb', ['breadcrumbs' => [
        [
            'title' => '이벤트',
            'href' => route('admin.event.index'),
        ],
        [
            'title' => '수정',
        ],
    ]])
    <!-- BEGIN Main Content -->
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-title">
                    <h3 class="cst_h3"><i class="fa fa-file"></i> 수정</h3>
                    <div class="box-tool">
                        <a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
                    </div>
                </div>
                <div class="box-content">
                    @include("Admin.Common.error_message")

                    <form action="{{ route('admin.event.update', ['id' => $data->id]) }}" method="post" id="editEvent">
                        @csrf
                        <div class="form-group">
                            <label class="control-label">제목</label>
                            <div class="controls">
                                <input class="form-control" name="title" type="text" value="{{ old("title", $data->title) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">작성일</label>
                            <div class="controls">
                                <input class="form-control js__single-date-event-edit" value="{{ $data->created_date }}" name="created_date" type="text" placeholder="선택">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="control-label">시작일</label>
                                    <div class="controls">
                                        <input class="form-control js__start-date-event" value="{{ formatDate($data->start_date) }}" name="start_date" type="text" placeholder="선택">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label">종료일</label>
                                    <div class="controls">
                                        <input class="form-control js__end-date-event" value="{{ formatDate($data->end_date) }}" name="end_date" type="text" placeholder="선택">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">내용</label>
                            <div class="controls">
                                <textarea id="js__editor" name="content" rows="5" class="form-control">{{ old("content", $data->content) }}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label">이미지 업로드</label>
                            <div class="controls">
                                <div id="banner-upload" class="fileupload fileupload-exists" data-provides="fileupload">
                                    <div id="fileupload-preview" class="fileupload-preview fileupload-exists img-thumbnail" style="width: 600px; height: 200px; overflow: hidden; position: relative;">
                                        <img src="{{ $data->banner ? env('APP_URL').'/'.$data->banner : asset('no_img.jpg') }}" alt="no+image" style="width: 100%; height: 100%; object-fit: contain; position: absolute; top: 0; left: 0;">
                                    </div>
                                    <div>
                                        <span class="btn btn-default btn-file">
                                            <span class="fileupload-new" id="select-banner">이미지를 선택</span>
                                            {{-- <span class="fileupload-exists" id="select-image-change">수정</span> --}}
                                        </span>
                                    </div>
                                    <input type="hidden" name="banner" value="{{ $data->banner }}">
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="text-center">
                        <button type="submit" form="editEvent" class="btn btn-primary">저장</button>
                        <a href="{{ route('admin.event.index') }}" class="btn">취소</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Main Content -->
@endsection