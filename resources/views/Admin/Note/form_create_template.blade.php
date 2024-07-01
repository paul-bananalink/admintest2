@extends('Admin.Note.page')

@section('content-note-custom')
    @include('Admin.Common.breadcrumb', ['breadcrumbs' => [
        [
            'title' => '템플릿관리',
            'href' => route('admin.note.indexTemplate'),
        ],
        [
            'title' => '템플릿 만들기',
        ],
    ]])
    <!-- BEGIN Main Content -->
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-title">
                    <h3 class="cst_h3"><i class="fa fa-file"></i>템플릿 만들기</h3>
                    <div class="box-tool">
                        <a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
                    </div>
                </div>
                <div class="box-content">
                    @include('Admin.Common.error_message')
                    <form action="{{ route('admin.note.createTemplate') }}" method="post" id="createTemplate">
                        @csrf
                        <div class="form-group">
                            <label class="control-label">제목</label>
                            <div class="controls">
                                <input class="form-control" name="title" type="text" value="{{ old('title') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">내용</label>
                            <div class="controls">
                                <textarea id="js__editor" name="content" rows="5" class="form-control">{{ old('content') }}</textarea>
                            </div>
                        </div>
                    </form>
                    <div class="text-center">
                        <button type="submit" form="createTemplate" class="btn btn-primary">저장</button>
                        <a href="{{ route('admin.note.indexTemplate') }}" class="btn">취소</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Main Content -->
@endsection
