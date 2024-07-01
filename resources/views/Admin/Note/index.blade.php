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
                    <a href="" class="btnstyle1 btnstyle1-success h-31 mr-3 js__apply-templ mb-3" 
                        data-action="{{ route('admin.note.ajaxGetContentTemplate', ['id' => $item->id]) }}"> 
                        {{ $item->title }}
                    </a>
                @endforeach
            </div>
        @endif
    
        <div class="text-center" style="margin-top: 24px">
            <button type="submit" form="add-note" id="btn-add-note" class="btnstyle1 btnstyle1-success btnstyle1-sm h-38 button-send">
                <i class="fa fa-envelope" aria-hidden="true"></i> 쪽지발송
            </button>
        </div>
    </div>

    <div class="box">
        <div class="box-content pb-0">
            <table class="table table-bordered cst-table-darkbrown">
                <thead>
                    <tr>
                        <th style="width: 250px">전송코드</th>
                        <th style="width: 25%">아이디</th>
                        <th style="width: 180px">전달시간</th>
                        <th>전달내용</th>
                        <th style="width: 120px">상태</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($notes as $item)
                        <tr>
                            <td>{{ $item->uuid }}</td>  {{-- uuid --}}
                            <td>{{ $item->labelMemberID() }}</td>  {{-- list member id --}}
                            <td>{{ $item->created_at }}</td>
                            <td style="text-align: inherit">
                                <div class="title-td">{{ $item->title }}</div>
                                <div class="content-td">{!! $item->content !!}</div>
                            </td>
                            <td>
                                {!! $item->isRead() ? 
                                    '<div class="f-s-12 p-5 label-primary label">읽음</div>' : 
                                    '<div class="f-s-12 p-5 label-danger label">안 읽음</div>' 
                                !!}    
                            </td> {{-- Status --}}
                        </tr>
                    @endforeach
                    @if(count($notes) == 0)
                        <tr>
                            <td colspan="5">데이터가 없음.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <div class="text-center">
                @if ($notes)
                    {{ $notes->appends(request()->query())->links('Admin.Common.pagination') }}
                @endif
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            <button class="close" data-dismiss="alert">×</button>
            <strong>Success!</strong> {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            <button class="close" data-dismiss="alert">×</button>
            <strong>Error!</strong> {{ session('error') }}
        </div>
    @endif

    <div class="box-content-detail bg-black-darker">
        <div class="bg-black-2 flex flex-end items-center p-12 gap-100">
            <div class="text-light">전체 발송이나 개인에게 잘못 보낸 쪽지를 회수할 수 있습니다. 회수할 쪽지의 전송코드를 입력하세요.</div>
            <div class="flex">
                <form action="{{ route('admin.note.recall') }}" method="POST" class="flex" id="recall">
                    @csrf
                    <input placeholder="전송코드 입력" type="text" class="form-control input-sm w-400 search-input-box h-33 p-l-5 text-white m-r-15" name="uuid" value="">
                    <button type="submit" for="recall" class="btnstyle1 btnstyle1-danger h-33 w-144 recall"><i class="fa fa-envelope text-dark" aria-hidden="true"></i> 쪽지회수</button>
                </form>
            </div>
        </div>
    </div>
@endsection
