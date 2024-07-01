@extends('Admin.Consultation.page')

@section('content-consultation')

@include('Admin.Common.breadcrumb', ['title' => '1대1문의'])
<!-- BEGIN Main Content -->
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-title">
                <h3 class="cst_h3"><i class="fa fa-file"></i>1대1문의 - 주형</h3>
                <div class="box-tool">
                    @php
                        $routeName = request()->route()->getName();
                    @endphp
                    <a href="{{ route('admin.consultation.index') }}" class="btn btn-gray{{ $routeName == 'admin.consultation.index' ? ' active-btn' : ''}}">1대1문의 관리</a>
                    <a href="{{ route('admin.template-message.index') }}" class="btn btn-gray{{ $routeName == 'admin.template-message.index' ? ' active-btn' : ''}}">템플릿관리</a>
                    <a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
                </div>
            </div>

            <div class="box-content">
                <div class="btn-toolbar pull-right">
                    <div class="btn-group">
                        <a href="{{ route('admin.template-message.viewCreate') }}" class="btn btn-sm btn-inverse">
                            <i class="glyphicon glyphicon-plus"></i>
                            템플릿 추가
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
                            <th>작성일</th>
                            <th style="width: 13%; text-align: center">기능</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td style="text-align: right">
                                    <a class="btn btn-sm mr-4" href="{{ route('admin.template-message.edit', $item->id) }}">
                                        <i class="fa fa-edit"></i>
                                         수정
                                    </a>
                                    <a href="#" class="btn btn-sm btn-danger confirm-box" data-route="{{ route('admin.template-message.delete', ['id' => $item->id]) }}"
                                        data-method="delete">
                                        <i class="fa fa-trash-o"></i>
                                         삭제
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if ($data)
                    <div class="text-center">
                        {{ $data->appends(request()->query())->links('Admin.Common.pagination') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- END Main Content -->
@endsection
