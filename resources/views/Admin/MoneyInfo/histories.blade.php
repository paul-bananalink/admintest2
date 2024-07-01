@extends('Admin.page')
@section('content-child')
    @include('Admin.Common.breadcrumb', ['title' => '역사'])
    <!-- BEGIN Main Content -->
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-title">
                    <h3 class="cst_h3"><i class="fa fa-file"></i></h3>
                    <div class="box-tool">
                        <a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
                    </div>
                </div>
                <div class="btn-toolbar pull-right d-flex">

                </div>
                <div class="box-content">
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
                                <th>회원</th>
                                <th>닉이름</th>
                                <th>예금주</th>
                                <th>분류</th>
                                <th>요청금액</th>
                                <th>요청일자</th>
                                <th>처리일자</th>
                                <th>관리자</th>
                                <th>상태</th>
                                <th>메모</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data->money_info_histories as $item)
                                <tr>
                                    <td>{{ $item->member->mID }}</td>
                                    <td>{{ $item->mNick }}</td>
                                    <td>{{ $item->miBankOwner }}</td>
                                    <td>{{ $item->mi_admin_type }}</td>
                                    <td>{{ formatNumber($item->miBankMoney) }}</td>
                                    <td>{{ $item->mihRegDate }}</td>
                                    <td>{{ $item->mihProcessDate }}</td>
                                    <td>{{ $item->process_member->mID ?? '' }}</td>
                                    <td>{{ $item->mihStatus }}</td>
                                    <td>{{ $item->note ?? '' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="text-center">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Main Content -->
@endsection
@section('custom-js')
@endsection
