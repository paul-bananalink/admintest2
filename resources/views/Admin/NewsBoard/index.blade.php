@extends('Admin.NewsBoard.page')
@section('content-newsboard')
    @include('Admin.Common.breadcrumb', ['title' => '게시판'])
    <!-- BEGIN Main Content -->
    <div class="row">
        <div class="col-md-12">
            <div class="box">

                <div class="box-content">
                    <div class="btn-toolbar pull-left">
                        <div class="btn-group">
                            <a class="btnstyle1 height-30 {{ request('category') === null ? 'btnstyle1-success' : 'btnstyle1-inverse2' }}" href="{{ route('admin.news-board.index') }}">
                                전체 ({{$count_items['all']}})
                            </a>
                            @foreach ($categories as $k => $val)
                                <a class="btnstyle1 height-30 {{ request('category') == $k ? 'btnstyle1-success' : 'btnstyle1-inverse2' }}" href="{{ route('admin.news-board.index', ['category' => $k]) }}">
                                    {{ $val }} ({{$count_items[$k]}})
                                </a>
                            @endforeach
                        </div>
                    </div>
                    <div class="btn-toolbar pull-right">
                        <div class="btn-group">
                            <a class="btn btn-sm btn-inverse show-tooltip" href="{{ route('admin.news-board.viewCreate') }}"
                                data-original-title="신규등록">
                                <i class="glyphicon glyphicon-plus"></i> 
                                신규등록
                            </a>
                        </div>
                    </div>
                    <br>
                    <br>
                    <br>

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
                    <table class="table table-bordered cst-table-darkbrown">
                        <thead>
                            <tr>
                                <th>제목</th>
                                <th>카테고리</th>
                                <th>작성자</th>
                                <th>작성일</th>
                                <th>조회수</th>
                                <th style="width: 5%; text-align: center">보이기</th>
                                <th style="width: 14%; text-align: center">기능</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $item->title }}</td>
                                    <td>{{ $item->label_category_newsboard() }}</td>
                                    <td>{{ $item->member->mID }}</td>
                                    <td>{{ $item->created_date }}</td>
                                    <td>{{ $item->views }}</td>
                                    <td>
                                        <x-common.toggle_switch_button 
                                        name="show_ui"
                                        isCheck="{{ $item->show_ui }}"
                                        url_action="{{ route('admin.news-board.toggleField', ['id' => $item->id]) }}"
                                        />
                                    </td>
                                    <td style="text-align: right">
                                        <a class="btn btn-sm mr-4" href="{{ route('admin.news-board.edit', $item->id) }}">
                                            <i class="fa fa-edit"></i>
                                             수정
                                        </a>
                                        <a class="btn btn-sm btn-danger confirm-box" data-route="{{ route('admin.news-board.delete', ['id' => $item->id]) }}"
                                            data-method="delete">
                                            <i class="fa fa-trash-o"></i>
                                             삭제
                                        </a>
                                    </td>
                                <tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="text-center">
                        @if ($data)
                            {{ $data->appends(request()->query())->links('Admin.Common.pagination') }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Main Content -->
@endsection
