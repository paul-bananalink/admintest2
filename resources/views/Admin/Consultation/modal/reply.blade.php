@extends('Admin.Consultation.page')

@section('content-consultation')
@include('Admin.Common.breadcrumb', ['breadcrumbs' => [
    [
        'title' => '1대1문의',
        'href' => route('admin.consultation.index'),
    ],
    [
        'title' => '응답',
    ],
]])
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-title">
                <h3 class="cst_h3"><i class="fa fa-file"></i>1대1문의 - 응답</h3>
                <div class="box-tool">
                    <a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
                </div>
            </div>
            <div class="box-content">
                @if(session('success'))
                    <div class="alert alert-success">
                        <button class="close" data-dismiss="alert">×</button>
                        <strong>Success!</strong> {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        <button class="close" data-dismiss="alert">×</button>
                        <strong>Error!</strong> {{ session('error') }}
                    </div>
                @endif
                @include("Admin.Common.error_message")
                
                <form method="post" action="{{ route('admin.consultation.reply', ['id' => $data->id]) }}" class="form-horizontal form-bordered" id="consultation-reply">
                    @csrf
                    <input type="hidden" name="consultation" value="{{ $data->id }}">
                    <div class="form-group">
                        <label for="textfield4" class="col-sm-3 col-lg-2 control-label">제목</label>
                        <div class="col-sm-9 col-lg-10 controls">
                            <p class="form-control-static" id="title">{{ $data->title }}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="textfield4" class="col-sm-3 col-lg-2 control-label">작성자</label>
                        <div class="col-sm-9 col-lg-10 controls">
                            <p class="form-control-static" id="writer">{{ $writer ?? '' }}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="textfield4" class="col-sm-3 col-lg-2 control-label">문의내용</label>
                        <div class="col-sm-9 col-lg-10 controls">
                            <p class="form-control-static" id="">{{ $data->content }}</p>
                        </div>
                    </div>
                    @if ($templates)
                        <div class="form-group">
                            <label for="textfield4" class="col-sm-3 col-lg-2 control-label">응답템플릿</label>
                            <div class="col-sm-9 col-lg-10 controls">
                                <select class="form-control" tabindex="1" name="template">
                                    <option value="">선택하다</option>
                                    @foreach ($templates as $item)
                                        <option value="{{ $item->id }}">{{ $item->title }}</option>
                                    @endforeach
                                </select>
                                <div style="margin-top: 12px">
                                    <a href="#" class="btn" id="js__apply-templ">적용</a>
                                    <a href="{{ route('admin.consultation.index') }}" target="blank" class="btn">템블릿관리 </a>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label">응답내용</label>
                        <div class="col-sm-9 col-lg-10 controls">
                            <textarea id="js__editor-consultation" rows="5" class="form-control" name="content_reply">{{ old("content_reply", $data->content_reply) }}</textarea>
                        </div>
                    </div>
                </form>

                <div class="text-center" style="margin-top: 24px">
                    <button type="submit" form="consultation-reply" class="btn btn-primary">응답</button>
                    <a href="{{ route('admin.consultation.index') }}" class="btn btn-default">취소</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection