@extends('Admin.GameProvider.page')
@section('content-game-provider')
    @include('Admin.Common.breadcrumb', ['title' => '게임업체'])
    <!-- BEGIN Main Content -->
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-title">
                    <h3 class="cst_h3"><i class="fa fa-file"></i>게임업체</h3>
                </div>
                <div class="box-content">
                    @if(session('success'))
                        <div class="alert alert-success">
                            <button class="close" data-dismiss="alert">×</button>
                            <strong>{{ session('success') }}</strong>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">
                            <button class="close" data-dismiss="alert">×</button>
                            <strong>{{ session('error') }}</strong>
                        </div>
                    @endif
                    <table class="table table-bordered cst-table-darkbrown">
                        <thead>
                            <tr>
                                <th style="text-align: center; width:56px">NO</th>
                                <th>이름</th>
                                <th>코드</th>
                                <th>카테고리</th>
                                <th style="width: 200px; text-align:center">기능</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $i => $item)
                                <tr>
                                    <td style="text-align: center">{{ $start_no - $i }}</td>
                                    <td>{{ $item->gpName }}</td>
                                    <td>{{ $item->gpCode }}</td>
                                    <td>{{ $item->gpCategory }}</td>
                                    <td style="text-align: right">
                                        <a class="btn btn-sm" href="{{ route('admin.game-provider.edit', ['id' => $item->gpNo]) }}"><i class="fa fa-edit"></i> 수정</a>
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