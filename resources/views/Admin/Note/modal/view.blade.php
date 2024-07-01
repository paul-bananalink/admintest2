@extends('Admin.page')


@section('content-child')
@include('Admin.Common.breadcrumb', ['breadcrumbs' => [
    [
        'title' => '접속',
        'href' => route('admin.note.index'),
    ],
    [
        'title' => '보기'
    ],
]])
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-title">
                <h3 class="cst_h3"><i class="fa fa-file"></i> 보기</h3>
                <div class="box-tool">
                    <a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
                </div>
            </div>
            <div class="box-content">
                <form action="#">
                    <div class="form-group">
                        <label class="control-label">받는사람</label>
                        <div class="controls">
                            <input class="form-control" name="title" type="text" value="{{ $note->get_name_receive() }}" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">제목</label>
                        <div class="controls">
                            <input class="form-control" name="title" type="text" value="{{ $note->title }}" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">내용</label>
                        <div class="controls">
                            <hr>
                            <div style="clear: both; overflow-x: hidden;">{!! $note->content !!}</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="text-center">
                            <a href="{{ route('admin.note.index') }}" class="btn">돌아오다</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection