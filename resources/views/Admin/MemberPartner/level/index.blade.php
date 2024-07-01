@extends('Admin.MemberPartner.page')

@section('content-partner')
    @include('Admin.MemberPartner.breadcrumb', ['title' => config('constant_view.PAGE_PARTNER.all.title')])
    <div class="row">
        <div class="col-md-12">
            <div class="box">
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
                    <table id="{{ $type . 'Table' }}" data-name="{{ $type }}"
                        class="table table-bordered cst-table-darkbrown">
                        <thead>
                            <tr>
                                <th>상태</th>
                                <th>구분</th>
                                <th>등록일</th>
                                <th>아이디</th>
                                <th>파트너명</th>
                                <th>회원수</th>
                                <th>회원머니</th>
                                <th>가입인증코드</th>
                                <th>커미션</th>
                                <th>가입머니자동지급여부</th>
                                <th>입금총액 (수)</th>
                                <th>출금총액(수)</th>
                                <th>수익</th>
                                <th>배팅총액(수)</th>
                                <th>수익금</th>
                                <th>보유쿠폰</th>
                                <th>파트너정보</th>
                                {{-- <th class="text-center">수정</th> --}}
                                <th>상세</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($partners as $partner)
                                <tr>
                                    <td>{{$partner->member->status_text ?? ''}}</td>
                                    <td>{{app('site_info')->siPartners[$partner->pType] ?? ''}}</td>
                                    <td>{{$partner->pRegDate}}</td>
                                    <td>
                                        <x-common.row_info_money :member="$partner->member" />
                                    </td>
                                    <td>
                                        {{$partner->pName}}
                                    </td>
                                    <td>
                                        {{$partner->total_children()}}
                                    </td>
                                    <td>
                                        {{formatNumber($partner->total_money())}}
                                    </td>
                                    <td></td>
                                    <td>
                                        {{$partner->pCommissions}}
                                    </td>
                                    <td></td>
                                    <td>
                                        {{formatNumber($partner->sum_recharge()) . ' (' . $partner->count_recharge() . ')'}}
                                    </td>
                                    <td>
                                        {{formatNumber($partner->sum_withdraw()) . ' (' . $partner->count_withdraw() . ')'}}
                                    </td>
                                    <td>
                                        {{formatNumber($partner->sum_revenue())}}
                                    </td>
                                    <td>
                                        {{formatNumber($partner->sum_bet()) . ' (' . $partner->count_bet() . ')'}}
                                    </td>
                                    <td>
                                        {{formatNumber($partner->total_commissions())}}
                                    </td>
                                    <td></td>
                                    <td>
                                        {{$partner->pNote}}
                                    </td>
                                    {{-- <td class="text-center">
                                        <a class="btn-xlarge btn-config get-item-partner" data-action="{{ route('admin.partner.ajax-get-form-update', ['pNo' => $partner->pNo]) }}"
                                        data-modal="#modalUpdatePartner">
                                            <i class="fa fa-cog pointer-events-none"></i>
                                        </a>
                                    </td> --}}
                                    <td>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="text-center">
                        @if ($partners)
                            <div class="text-center">
                                {{ $partners->appends(request()->query())->links('Admin.Common.pagination') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
    