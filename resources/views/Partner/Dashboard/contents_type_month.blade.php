<div class="dashboard-panel">
    <div class="panel panel-primary">
        <div class="panel-heading cst_panel-heading">
            <h4 class="panel-title cst_panel-title">현재접속자수</h4>
        </div>
        <div class="panel-body background-black cst-min-hight105">
            <div class="text-center cst-font-20"><span class="count_member_login">{{ $count_member_login }}</span>명</div>
        </div>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading cst_panel-heading">
            <h4 class="panel-title cst_panel-title">금일 신규가입 유저수</h4>
        </div>
        <div class="panel-body background-black cst-min-hight105">
            <div class="text-center cst-font-20"><span
                    class="count_member_register_today">{{ $count_member_register_this_month }}</span>명</div>
            <div class="text-center">
                @if ($count_member_register >= 0)
                    <i class="glyphicon glyphicon-arrow-up blue"></i> 전일대비
                    <span class="blue">+</span>
                    <span class="count_member_register blue">{{ $count_member_register }}</span>
                    <span class="blue">명 상승</span>
                @else
                    <i class="glyphicon glyphicon-arrow-down red"></i> 전일대비
                    <span class="red">-</span>
                    <span class="count_member_register red">{{ formatNumber(abs($count_member_register)) }}</span>
                    <span class="red">명 하락</span>
                @endif
            </div>
        </div>
    </div>

    <div class="panel panel-primary">
        <div class="panel-heading cst_panel-heading">
            <h4 class="panel-title cst_panel-title">금일 차단 유저수</h4>
        </div>
        <div class="panel-body background-black cst-min-hight105">
            <div class="text-center cst-font-20"><span
                    class="count_member_suspended_today">{{ $count_member_suspended_this_month }}</span>명</div>
            <div class="text-center">
                @if ($count_member_suspended >= 0)
                    <i class="glyphicon glyphicon-arrow-up blue"></i> 전일대비
                    <span class="blue">+</span>
                    <span class="count_member_register blue">{{ abs($count_member_suspended) }}</span>
                    <span class="blue">명 상승</span>
                @else
                    <i class="glyphicon glyphicon-arrow-down red"></i> 전일대비
                    <span class="red">-</span>
                    <span class="count_member_register red">{{ formatNumber(abs($count_member_suspended)) }}</span>
                    <span class="red">명 하락</span>
                @endif
            </div>
        </div>
    </div>

    <div class="panel panel-primary">
        <div class="panel-heading cst_panel-heading">
            <h4 class="panel-title cst_panel-title">금일 입금액</h4>
        </div>
        <div class="panel-body background-black cst-min-hight105">
            <div class="text-center cst-font-20">
                @if ($sum_money_register_recharge_approved_this_month)
                    <span
                        class="sum_money_register_recharge_approved_today">{{ formatNumber($sum_money_register_recharge_approved_this_month) }}</span>원
                @else
                    0원
                @endif
            </div>
            <div class="text-center">(<span
                    class="count_order_deposite_register_today">{{ $count_order_deposite_register_this_month }}</span>건)
            </div>
            <div class="text-center">
                @if ($sum_money_interest_recharge >= 0)
                    <i class="glyphicon glyphicon-arrow-up blue"></i> 전일대비
                    <span class="blue">+</span>
                    <span
                        class="blue sum_money_interest_recharge">{{ formatNumber($sum_money_interest_recharge) }}</span>
                    <span>원 상승</span>
                @else
                    <i class="glyphicon glyphicon-arrow-down red"></i> 전일대비
                    <span class="red">-</span>
                    <span
                        class="red sum_money_interest_recharge">{{ formatNumber(abs($sum_money_interest_recharge)) }}<span>
                        </span>원 하락</span>
                @endif
            </div>
        </div>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading cst_panel-heading">
            <h4 class="panel-title cst_panel-title">금일 출금액</h4>
        </div>
        <div class="panel-body background-black cst-min-hight105">
            <div class="text-center cst-font-20">
                @if ($sum_money_register_withdraw_approved_this_month)
                    <span class="sum_money_register_withdraw_approved_today">
                        {{ formatNumber($sum_money_register_withdraw_approved_this_month) }}
                    </span>원
                @else
                    0원
                @endif
            </div>
            <div class="text-center">(<span
                    class="count_money_register_withdraw_today">{{ $count_money_register_withdraw_this_month }}</span>건)
            </div>
            <div class="text-center">
                @if ($sum_money_interest_withdraw >= 0)
                    <i class="glyphicon glyphicon-arrow-up blue"></i> 전일대비
                    <span class="blue">+</span>
                    <span
                        class="blue sum_money_interest_withdraw">{{ formatNumber($sum_money_interest_withdraw) }}</span>
                    <span class="blue">원 상승</span>
                @else
                    <i class="glyphicon glyphicon-arrow-down red"></i> 전일대비
                    <span class="red">-</span>
                    <span
                        class="red sum_money_interest_withdraw">{{ formatNumber(abs($sum_money_interest_withdraw)) }}</span>
                    <span class="red">원 하락</span>
                @endif
            </div>
        </div>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading cst_panel-heading">
            <h4 class="panel-title cst_panel-title">금일 배팅금액</h4>
        </div>
        <div class="panel-body background-black cst-min-hight105">
            <div class="text-center cst-font-20">{{ $total_member_bet_this_month }} 명</div>
            <div class="text-center">({{ $total_bet_this_month }}회)</div>
            <div class="text-center">
                @if (isset($sum_bet_compare))
                    @if ($sum_bet_compare >= 0)
                        <i class="glyphicon glyphicon-arrow-up blue"></i> 전일대비
                        <span class="blue"></span>
                        <span class="blue">{{ $sum_bet_compare }}명 하락</span>
                    @else
                        <i class="glyphicon glyphicon-arrow-down red"></i> 전일대비
                        <span class="red">{{ $sum_bet_compare }}명 회</span>
                    @endif
                @endif
            </div>
        </div>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading cst_panel-heading">
            <h4 class="panel-title cst_panel-title">금일 수익금액</h4>
        </div>
        <div class="panel-body background-black cst-min-hight105">
            <div class="text-center cst-font-20"><span
                    class="sum_money_interest_today">{{ formatNumber($sum_money_interest_this_month) }}</span>원</div>
            <div class="text-center">
                @if ($sum_money_compare >= 0)
                    <i class="glyphicon glyphicon-arrow-up blue"></i> 전일대비 <span class="blue">
                        <span class="blue">+</span>
                        <span class="blue sum_money_compare">{{ formatNumber($sum_money_compare) }}</span>
                        <span class="blue">원 상승</span>
                    @else
                        <i class="glyphicon glyphicon-arrow-down red"></i> 전일대비
                        <span class="red">-</span>
                        <span class="red sum_money_compare">{{ formatNumber(abs($sum_money_compare)) }}원 하락</span>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- BEGIN Main Content -->
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-title">
                <h3 class="cst_h3"><i class="fa fa-file"></i> 일일 통계</h3>
                <div class="box-tool">
                    <a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
                </div>
            </div>
            <div class="box-content">
                <table class="table table-bordered cst-table-darkbrown">
                    <thead>
                        <tr>
                            <th>날자</th>
                            <th>신규가입</th>
                            <th>입금유저</th>
                            <th>입금액/입금수</th>
                            <th>출금액/출금수</th>
                            <th>롤링금액/당첨금액</th>
                            <th>수익금액</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data_12_months_ago as $data)
                            <tr>
                                <td>{{ $data['date'] }}</td>
                                <td>{{ $data['new_member'] }} 명</td>
                                <td>{{ $data['user_recharge'] }} 명</td>
                                <td>{{ formatNumber($data['money_recharge']['total']) }}원 /
                                    {{ $data['money_recharge']['count'] }}회</td>
                                <td>{{ formatNumber($data['money_withdraw']['total']) }}원 /
                                    {{ $data['money_withdraw']['count'] }}회</td>
                                <td>{{ formatNumber($data['total_bet']) }}원 / {{ formatNumber($data['total_win']) }}원
                                </td>
                                <td>{{ formatNumber($data['money_profit']) }}원</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- END Main Content -->
<!-- BEGIN Main Content -->
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-title">
                <h3 class="cst_h3"><i class="fa fa-file"></i> 일일 통계</h3>
                <div class="box-tool">
                    <a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
                </div>
            </div>
            <div class="box-content">
                <canvas id="myChart" style="background-color: black; padding: 20px"></canvas>
            </div>
        </div>
    </div>
</div>
<!-- END Main Content -->
<!-- BEGIN Main Content -->
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-title">
                <h3 class="cst_h3"><i class="fa fa-file"></i>게임별 금일 통계</h3>
                <div class="box-tool">
                    <a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
                </div>
            </div>
            <div class="box-content">
                <div>
                    <div class="row">
                        <div class="col-md-6">
                            {{-- <div class="title-chart">
                                <p class="cst_panel-title">
                                    <button class="btn btn-info">
                                        카지노
                                    </button>
                                    <button class="btn btn-info" id="member_batting">
                                        {{$count_member_batting_this_month_slot}}명
                                    </button>
                                </p>
                            </div> --}}
                            <canvas id="chartCasino" class="bg-dark"></canvas>
                        </div>
                        <div class="col-md-6">
                            {{-- <div class="title-chart">
                                <p class="cst_panel-title">
                                    <button class="btn btn-info">
                                        슬롯
                                    </button>
                                    <button class="btn btn-info" id="member_batting">
                                        {{$count_member_batting_this_month_slot}}명
                                    </button>
                                </p>
                            </div> --}}
                            <canvas id="chartSlot" class="bg-dark"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END Main Content -->
@section('js_type')
    <script>
        let data12MonthsAgo = Object.values(@json($data_12_months_ago));
        //casino
        let sum_bet_minus_win_this_month_casino = {{ $sum_bet_minus_win_this_month_casino }};
        let sum_win_this_month_casino = {{ $sum_win_this_month_casino }}
        let rate_convert_to_money_win_this_month_casino = {{ $rate_convert_to_money_win_this_month_casino }}

        //slot
        let sum_bet_minus_win_this_month_slot = {{ $sum_bet_minus_win_this_month_slot }};
        let sum_win_this_month_slot = {{ $sum_win_this_month_slot }}
        let rate_convert_to_money_win_this_month_slot = {{ $rate_convert_to_money_win_this_month_slot }}
    </script>
    @vite(['resources/vite/js/dashboard/chart_month.js'])
@endsection
