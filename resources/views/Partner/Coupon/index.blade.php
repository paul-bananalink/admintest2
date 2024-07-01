@extends('Partner.page')

@section('content-child')
    <div class="row">
        <div class="col-md-12">
            <div class="box mb-0">
                <div class="box-content pt-0">
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

                    <div>
                        @include('components.common.panel_heading', [
                            'icon' => 'fa fa-arrow-down',
                            'page' => 'COUPON SYSTEM',
                            'title' => '쿠폰 지급/현황/내역',
                            'form' => 'Partner.Coupon.search',
                        ])
                        <div class="p-20">
                            <div class="f-s-16 f-w-700 text-white p-20 el-row">
                                보유 쿠폰금액: 0원
                            </div>
                            <table class="table table-bordered table-td-valign-middle text-center text-white no-bg">
                                <thead>
                                    <tr>
                                        <th>파트너명</th>
                                        <th>레벨</th>
                                        <th>아이디 (닉네임)</th>
                                        <th>입금수</th>
                                        <th>출금수</th>
                                        <th>수익(입금-출금)</th>
                                        <th>보유쿠폰 금액(수량)</th>
                                        <th>사용한 쿠폰 금액(수량)</th>
                                        <th>만료된 쿠폰 금액(수량)</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-css')
    @vite(['resources/vite/css/page-money-info/money_info.css'])
@endsection

@section('custom-js')
    @vite(['resources/vite/js/pusher/money_info/money_info.js', 'resources/vite/js/page-money-info/money_info.js'])
@endsection
