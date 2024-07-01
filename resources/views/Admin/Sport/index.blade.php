@extends('Admin.Sport.page')
@section('content-sport')
    @if($type == 'sport')
        <div class="panel-heading-page">
            @include('Admin.Sport.form_search_sport')
            <h4 class="panel-title m-5">
                <strong>
                    <i class="fa fa-arrow-down"></i> GAME LIST :: 스포츠 게임관리
                </strong>
            </h4>
        </div>
    @elseif($type == 'realtime')
        <div class="panel-heading-page">
            @include('Admin.Sport.form_search_realtime')
            <h4 class="panel-title m-5">
                <strong>
                    <i class="fa fa-arrow-down"></i> GAME LIST :: 스포츠 게임관리
                </strong>
            </h4>
        </div>
    @elseif($type == 'team')
        <div class="panel-heading-page">
            @include('Admin.Sport.form_search_team')
            <h4 class="panel-title m-5">
                <strong>
                    <i class="fa fa-arrow-down"></i> TEAM LIST :: 팀관리
                </strong>
            </h4>
        </div>
    @elseif($type == 'league')
        <div class="panel-heading-page">
            @include('Admin.Sport.form_search_league')
            <h4 class="panel-title m-5">
                <strong>
                    <i class="fa fa-arrow-down"></i> BETTING LIST :: 리그관리
                </strong>
            </h4>
        </div>
    @endif

    @if($type == 'realtime')
        <div class="mt-20">
            <a class="btnstyle1 btnstyle1-success h-31">전체게임</a>
        </div>
    @endif
    <div class="overunderline m-b-4"></div>

    <div class="">
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
        <form action="{{ route('admin.sport.update-table', ['type' => $type]) }}" method="post" id="league_sport">
            @csrf
            @if($type != 'sport' && $type != 'realtime' && $type != 'team')
                <button type="submit" class="pull-right h-28 btnstyle1 mb-8 btnstyle1-info">저장</button>
            @endif
            
            @if($type == 'league')
                @include('Admin.Sport.table_league')
            @elseif($type == 'team')
                @include('Admin.Sport.table_team')
            @elseif($type == 'sport')
                @include('Admin.Sport.table_sport')
            @elseif($type == 'realtime')
                @include('Admin.Sport.table_realtime')
            @endif
        </form>

        <div class="text-center">
            @if ($data)
                {{ $data->appends(request()->query())->links('Admin.Common.pagination') }}
            @endif
        </div>
    </div>
@endsection
