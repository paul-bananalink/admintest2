@extends('Admin.Note.page')


@section('content-note-custom')
@include('Admin.Common.breadcrumb', ['breadcrumbs' => [
    [
        'title' => '쪽지',
        'href' => route('admin.note.index'),
    ],
    [
        'title' => '수정',
    ],
]])
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-title">
                <h3 class="cst_h3"><i class="fa fa-file"></i>수정</h3>
                <div class="box-tool">
                    <a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
                </div>
            </div>
            <div class="box-content">
                @include("Admin.Common.error_message")
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
                
                <form action="{{route('admin.note.update', ['id' => $data->id])}}" method="post" id="add-note">
                    @csrf
                    <div class="form-group">
                        <label class="control-label">제목</label>
                        <div class="controls">
                            <input class="form-control" name="title" type="text" value="{{ old('title', $data->title) }}">
                        </div>
                    </div>
                    @if ($templates)
                        <div class="form-group">
                            <label class="control-label">응답템플릿</label>
                            <div class="controls">
                                <select class="form-control" tabindex="1" name="template">
                                    <option value="">범주</option>
                                    @foreach ($templates as $item)
                                        <option value="{{ $item->id }}" data-action="{{ route('admin.note.ajaxGetContentTemplate', ['id' => $item->id]) }}">{{ $item->title }}</option>
                                    @endforeach
                                </select>
                                <div style="margin-top: 12px">
                                    <a href="#" class="btn" id="js__apply-templ">적용</a>
                                    <a href="{{ route('admin.note.indexTemplate') }}" target="blank" class="btn">템블릿관리 </a>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="form-group">
                        <label class="control-label">내용</label>
                        <div class="controls">
                            <textarea id="js__editor-note" name="content" rows="5" class="form-control">{{ old('title', $data->content) }}</textarea>
                        </div>
                    </div>
                </form>

                <div class="text-center" style="margin-top: 24px">
                    <button type="submit" form="add-note" class="btn btn-primary">저장</button>
                    <a class="btn btn-default" href="{{ route('admin.note.index') }}">취소</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection