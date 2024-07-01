@extends('Partner.page')

@section('content-child')
    @if ($type == 'recharge')
        @include('components.common.panel_heading', [
            'icon' => 'fa fa-arrow-down',
            'page' => 'CASH DEPOSIT',
            'title' => '입금(충전)관리',
            'form' => 'Partner.MoneyInfo.recharge_search_form',
        ])
    @elseif($type == 'withdraw')
        <x-common.panel_heading icon="fa fa-arrow-down" page="CASH WITHDRAW" title="출금(환전)관리"
            form="Partner.MoneyInfo.withdraw_search_form" />
    @endif
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
                    @includeWhen($type == 'recharge', 'Partner.MoneyInfo.table_recharge', [
                        'type' => $type,
                        'data' => $data,
                    ])
                    @includeWhen($type == 'withdraw', 'Partner.MoneyInfo.table_withdraw', [
                        'type' => $type,
                        'data' => $data,
                    ])
                    <div class="text-center">
                        @if ($data)
                            <div class="text-center">
                                {{ $data->appends(request()->query())->links('Admin.Common.pagination') }}
                            </div>
                        @endif
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
