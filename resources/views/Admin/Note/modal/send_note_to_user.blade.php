@extends('Admin.page')


@section('content-child')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-title">
                <h3 class="cst_h3"><i class="fa fa-file"></i> 쪽지 - {{ $member->mID }}</h3>
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
                
                <form action="{{route('admin.note.sendNoteToUser')}}" method="post" id="sendNoteToUser">
                    @csrf
                    <div class="form-group">
                        <label class="control-label">제목</label>
                        <div class="controls">
                            <input class="form-control" name="title" type="text">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">내용</label>
                        <div class="controls">
                            <textarea id="js__editor" name="content" rows="5" class="form-control"></textarea>
                        </div>
                    </div>
                    <input type="hidden" name="mNo_receive" value="{{ $member->mNo }}">
                </form>

                <div class="text-center" style="margin-top: 24px">
                    <button type="submit" form="sendNoteToUser" class="btn btn-primary">응답</button>
                    <button class="btn btn-default" onclick="window.close()">취소</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom-js')

@endsection
