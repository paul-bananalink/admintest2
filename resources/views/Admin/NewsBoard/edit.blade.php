@extends('Admin.NewsBoard.page')

@section('content-newsboard')
    @include('Admin.Common.breadcrumb', ['breadcrumbs' => [
        [
            'title' => '게시판',
            'href' => route('admin.news-board.index'),
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
                    <form action="{{ route('admin.news-board.update', ['id' => $data->id]) }}" method="post" id="editNewsBoard">
                        @csrf
                        <div class="form-group">
                            <label class="control-label">범주</label>
                            <div class="controls">
                                <select class="form-control" tabindex="1" name="category">
                                    <option value="">선택하다</option>
                                    @foreach ($categories as $k => $title)
                                        <option value="{{ $k }}" @if(old('category', $data->category) == $k) selected @endif>{{ $title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">제목</label>
                            <div class="controls">
                                <input class="form-control" name="title" type="text" value="{{ old("title", $data->title) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">작성일</label>
                            <div class="controls">
                                <input class="form-control js__single-date-newb" name="created_date" type="text" value="{{ $data->created_date }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">내용</label>
                            <div class="controls">
                                <textarea id="js__editor" name="content" rows="5" class="form-control">{{ old("content", $data->content) }}</textarea>
                            </div>
                        </div>
                    </form>
                    <div class="text-center">
                        <button type="submit" form="editNewsBoard" class="btn btn-primary">저장</button>
                        <a href="{{ route('admin.news-board.index') }}" class="btn">취소</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Main Content -->
@endsection