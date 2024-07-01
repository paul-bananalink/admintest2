@extends('Admin.Note.page')


@section('content-note-custom')
<div class="panel-heading-page">
    @include('Admin.Note.form_search')
    <h4 class="panel-title m-5">
        <strong>
            <i class="fa fa-arrow-down"></i> MEMO LIST :: 쪽지 관리
        </strong>
    </h4>
</div>
<div class="box-content-detail bg-black-darker">
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
    
    <form action="{{route('admin.note.addNote')}}" method="post" id="add-note" class="form-horizontal">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="col-xs-3 col-lg-1 control-label">발송구분</label>
                    <div class="col-sm-9 col-lg-11 controls">
                        <select class="form-control" tabindex="1" name="type">
                            <option value="">범주</option>
                            @foreach ($categories_send as $k => $title)
                            @php
                                if($k == 4){ $action = route('admin.note.ajaxGetTextAreaListUser'); }
                                elseif($k == 5){ $action = route('admin.note.ajaxGetSelectLevel'); }
                                elseif($k == 6){ $action = route('admin.note.ajaxGetCheckboxPartner'); }
                                else{ $action = '#'; }
                            @endphp
                                <option value="{{ $k }}" data-action="{{ $action }}">{{ $title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div id="group-return"></div>
                <div class="form-group">
                    <label class="col-xs-3 col-lg-1 control-label">제목</label>
                    <div class="col-sm-9 col-lg-11 controls">
                        <input class="form-control" name="title" type="text" value="{{ old('title') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-3 col-lg-1 control-label control-label">내용</label>
                    <div class="col-sm-9 col-lg-11 controls">
                        <textarea id="js__editor-note" name="content" rows="5" class="form-control">{{ old('content') }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </form>

    @if ($templates)
        <div class="m-t-24 text-center">
            @foreach ($templates as $item)
                <a href="" class="btnstyle1 btnstyle1-success h-31 mr-3 js__apply-templ" 
                    data-action="{{ route('admin.note.ajaxGetContentTemplate', ['id' => $item->id]) }}"> 
                    {{ $item->title }}
                </a>
            @endforeach
        </div>
    @endif

    <div class="text-center" style="margin-top: 24px">
        <button type="submit" form="add-note" class="btnstyle1 btnstyle1-success h-38 button-send">
            <i class="fa fa-envelope" aria-hidden="true"></i> 쪽지발송
        </button>
    </div>
</div>
@endsection