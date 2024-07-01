@extends('Admin.Event.page')
@section('content-event')
    @include('Admin.Common.breadcrumb', ['title' => '이벤트'])
    <!-- BEGIN Main Content -->
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-title">
                    <h3 class="cst_h3"><i class="fa fa-file"></i>이벤트</h3>
                    <div class="box-tool">
                        @php
                            $routeName = request()->route()->getName();
                        @endphp
                        <a href="{{ route('admin.news-board.index') }}" class="btn btn-gray{{ $routeName == 'admin.news-board.index' ? ' active-btn' : ''}}">게시판</a>
                        <a href="{{ route('admin.event.index') }}" class="btn btn-gray{{ $routeName == 'admin.event.index' ? ' active-btn' : ''}}">이벤트</a>
                        <a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
                    </div>
                </div>
                <div class="box-content">
                    <div class="btn-toolbar pull-right">
                        <div class="btn-group">
                            <a class="btn btn-sm btn-inverse show-tooltip" href="{{ route('admin.event.viewCreate') }}"
                                data-original-title="신규등록">
                                <i class="glyphicon glyphicon-plus"></i> 
                                신규등록
                            </a>
                        </div>
                    </div>
                    <br>
                    <br>
                    
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
                    <table class="table table-bordered cst-table-darkbrown">
                        <thead>
                            <tr>
                                <th>제목</th>
                                <th>작성자</th>

                                <th style="width: 12%;">작성일</th>
                                <th style="width: 12%;">시작일</th>
                                <th style="width: 12%;">종료일</th>

                                <th style="width: 5%;">조회수</th>
                                <th style="width: 5%; text-align: center">보이기</th>
                                <th style="width: 15%; text-align: center">기능</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $item->title }}</td>
                                    <td>{{ $item->member->mID }}</td>

                                    <td>{{ $item->created_date }}</td>
                                    <td>{{ formatDate($item->start_date) }}</td>
                                    <td>{{ formatDate($item->end_date) }}</td>

                                    <td>{{ $item->views }}</td>
                                    <td>
                                        <x-common.toggle_switch_button 
                                        name="show_ui"
                                        isCheck="{{ $item->show_ui }}"
                                        url_action="{{ route('admin.news-board.toggleField', ['id' => $item->id]) }}"
                                        />
                                    </td>
                                    <td style="text-align: right">
                                        <a class="btn btn-sm mr-4" href="{{ route('admin.event.edit', $item->id) }}">
                                            <i class="fa fa-edit"></i>
                                             수정
                                        </a>
                                        <a class="btn btn-danger btn-sm confirm-box" data-route="{{ route('admin.event.delete', ['id' => $item->id]) }}"
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
