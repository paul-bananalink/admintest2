@extends('Partner.Casino.page')
@section('content-casino')
    @include('Partner.Common.breadcrumb', ['title' => $title_page])
    <!-- BEGIN Main Content -->
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-title">
                    <h3 class="cst_h3"><i class="fa fa-file"></i>{{ $title_page }}</h3>
                </div>
                <div class="box-content">
                    @include('Partner.Casino.form_search')
                    <table class="table table-bordered cst-table-darkbrown">
                        <thead>
                            <tr>
                                <th style="text-align: center; width:56px">NO</th>
                                <th>회원아이디</th>
                                <th style="width: 30%">Round ID</th>
                                <th>베팅일시</th>
                                <th>Provider</th>
                                <th>Game Name</th>
                                <th class="text-right" style="width: 150px">베팅금액</th>
                                <th class="text-right" style="width: 120px">상태</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $i => $item)
                                <tr>
                                    <td style="text-align: center">{{ $start_no - $i }}</td>
                                    <td>{{ $item->member->mID }}</td>
                                    <td>{{ $item->tRoundId }}</td>
                                    <td>{{ $item->tRegDate }}</td>
                                    <td>{{ $item->pCode }}</td>
                                    <td>{{ $item->gName }}</td>
                                    <td class="text-right">{{ data_get($item->convertResult(), 'tAmount', 0) }}</td>
                                    <td class="text-right">{{ data_get($item->convertResult(), 'tType') }}</td>
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
