<div class="dashboard-panel">
    <div class="panel panel-primary">
        <div class="panel-heading cst_panel-heading">
            <h4 class="panel-title cst_panel-title">현재접속자수</h4>
        </div>
        <div class="panel-body background-black cst-min-hight105">
            <div class="text-center cst-font-30 leading-65">
                <strong><span class="count_member_login">{{ $count_member_login }}</span>명</strong>
            </div>
        </div>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading cst_panel-heading">
            <h4 class="panel-title cst_panel-title">금일 신규가입 유저수</h4>
        </div>
        <div class="panel-body background-black cst-min-hight105">
            <div class="text-center cst-font-30 leading-65">
                <strong><span
                        class="count_member_register_today">{{ $count_member_register_this_month }}</span>명</strong>
            </div>
            <div class="text-center">
                @if ($count_member_register >= 0)
                    <i class="glyphicon glyphicon-arrow-up blue"></i> 전일대비
                    <span class="blue">+</span>
                    <a class="blue"><span class="count_member_register">{{ $count_member_register }}</span>명</a>
                    <span class="blue">상승</span>
                @else
                    <i class="glyphicon glyphicon-arrow-down red"></i> 전일대비
                    <span class="red">-</span>
                    <a class="red"><span
                            class="count_member_register">{{ formatNumber(abs($count_member_register)) }}</span>명</a>
                    <span class="red">하락</span>
                @endif
            </div>
        </div>
    </div>

    <div class="panel panel-primary">
        <div class="panel-heading cst_panel-heading">
            <h4 class="panel-title cst_panel-title">금일 차단 유저수</h4>
        </div>
        <div class="panel-body background-black cst-min-hight105">
            <div class="text-center cst-font-30 leading-65">
                <strong><span
                        class="count_member_suspended_today">{{ $count_member_suspended_this_month }}</span>명</strong>
            </div>
            <div class="text-center">
                @if ($count_member_suspended >= 0)
                    <i class="glyphicon glyphicon-arrow-up blue"></i> 전일대비
                    <span class="blue">+</span>
                    <a class="blue"><span class="count_member_register">{{ abs($count_member_suspended) }}</span>명</a>
                    <span class="blue">상승</span>
                @else
                    <i class="glyphicon glyphicon-arrow-down red"></i> 전일대비
                    <span class="red">-</span>
                    <a class="red"><span
                            class="count_member_register">{{ formatNumber(abs($count_member_suspended)) }}</span>명</a>
                    <span class="red">하락</span>
                @endif
            </div>
        </div>
    </div>

    <div class="panel panel-primary">
        <div class="panel-heading cst_panel-heading">
            <h4 class="panel-title cst_panel-title">금일 입금액</h4>
        </div>
        <div class="panel-body background-black cst-min-hight105">
            <div class="text-center cst-font-20 h-65">
                <strong>
                    @if ($sum_money_register_recharge_approved_this_month)
                        <span class="sum_money_register_recharge_approved_today">
                            {{ formatNumber($sum_money_register_recharge_approved_this_month) }}
                        </span>원
                    @else
                        0원
                    @endif
                </strong>
                <p class="cst-font-18"><strong>(<span
                            class="count_order_deposite_register_today">{{ $count_order_deposite_register_this_month }}</span>건)</strong>
                </p>
            </div>

            <div class="text-center">
                @if ($sum_money_interest_recharge >= 0)
                    <i class="glyphicon glyphicon-arrow-up blue"></i> 전일대비
                    <span class="blue">+</span>
                    <a class="blue"><span
                            class="sum_money_interest_recharge">{{ formatNumber($sum_money_interest_recharge) }}</span>원</a>
                    <span class="blue">상승</span>
                @else
                    <i class="glyphicon glyphicon-arrow-down red"></i> 전일대비
                    <span class="red">-</span>
                    <a class="red"><span
                            class="sum_money_interest_recharge">{{ formatNumber(abs($sum_money_interest_recharge)) }}<span>원</a>
                    <span class="red">하락</span>
                @endif
            </div>
        </div>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading cst_panel-heading">
            <h4 class="panel-title cst_panel-title">금일 출금액</h4>
        </div>
        <div class="panel-body background-black cst-min-hight105">
            <div class="text-center cst-font-20 h-65">
                <strong>
                    @if ($sum_money_register_withdraw_approved_this_month)
                        <span class="sum_money_register_withdraw_approved_today">
                            {{ formatNumber($sum_money_register_withdraw_approved_this_month) }}
                        </span>원
                    @else
                        0원
                    @endif
                </strong>
                <p class="cst-font-18"><strong>(<span
                            class="count_money_register_withdraw_today">{{ $count_money_register_withdraw_this_month }}</span>건)</strong>
                </p>
            </div>

            <div class="text-center">
                @if ($sum_money_interest_withdraw >= 0)
                    <i class="glyphicon glyphicon-arrow-up blue"></i> 전일대비
                    <span class="blue">+</span>
                    <a class="blue"><span
                            class="sum_money_interest_withdraw">{{ formatNumber($sum_money_interest_withdraw) }}</span>원</a>
                    <span class="blue">상승</span>
                @else
                    <i class="glyphicon glyphicon-arrow-down red"></i> 전일대비
                    <span class="red">-</span>
                    <a class="red"><span
                            class="sum_money_interest_withdraw">{{ formatNumber(abs($sum_money_interest_withdraw)) }}</span>원</a>
                    <span class="red">하락</span>
                @endif
            </div>
        </div>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading cst_panel-heading">
            <h4 class="panel-title cst_panel-title">금일 롤링금액</h4>
        </div>
        <div class="panel-body background-black cst-min-hight105">
            <div class="text-center cst-font-20 h-65">
                <strong>{{ $total_member_bet_this_month }}명</strong>
                <p class="cst-font-18"><strong>({{ $total_bet_this_month }}회)</strong></p>
            </div>

            <div class="text-center">
                @if (isset($sum_bet_compare))
                    @if ($sum_bet_compare >= 0)
                        <i class="glyphicon glyphicon-arrow-up blue"></i> 전일대비
                        <span class="blue">+</span>
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
            <div class="text-center cst-font-30 leading-65">
                <strong><span
                        class="sum_money_interest_today">{{ formatNumber($sum_money_interest_this_month) }}</span>원</strong>
            </div>
            <div class="text-center">
                @if ($sum_money_compare >= 0)
                    <i class="glyphicon glyphicon-arrow-up blue"></i> 전일대비 <span class="blue">
                        <span class="blue">+</span>
                        <a class="blue"><span
                                class="sum_money_compare">{{ formatNumber($sum_money_compare) }}</span>원</a>
                        <span class="blue">상승</span>
                    @else
                        <i class="glyphicon glyphicon-arrow-down red"></i> 전일대비
                        <span class="red">-</span>
                        <a class="red"><span
                                class="sum_money_compare">{{ formatNumber(abs($sum_money_compare)) }}원</span></a>
                        <span class="red">하락</span>
                @endif
            </div>
        </div>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading cst_panel-heading">
            <h4 class="panel-title cst_panel-title">배팅손익</h4>
        </div>
        <div class="panel-body background-black cst-min-hight105">
            <div class="text-center cst-font-30 leading-65">
                <strong><span
                        class="sum_money_interest_today">{{ formatNumber($this_month_bet_profit_loss) }}</span>원</strong>
            </div>
            <div class="text-center">
                @if ($sum_bet_profit_compare_month >= 0)
                    <i class="glyphicon glyphicon-arrow-up blue"></i> 전일대비
                    <span class="blue">+</span>
                    <a class="blue"><span
                            class="sum_bet_profit_compare_month">{{ formatNumber($sum_bet_profit_compare_month) }}</span>원</a>
                    <span class="blue">상승</span>
                @else
                    <i class="glyphicon glyphicon-arrow-down red"></i> 전일대비
                    <span class="red">-</span>
                    <a class="red"><span
                            class="sum_bet_profit_compare_month">{{ formatNumber(abs($sum_bet_profit_compare_month)) }}</span>원</a>
                    <span class="red">하락</span>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- BEGIN Main Content -->
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <x-common.panel_heading title="현황 그래프" />
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
            <x-common.panel_heading title="일일 수익률 현황그래프" />
            <div class="box-content" style="background: rgb(0, 0, 0); padding: 10px;">
                <div class="row" style="display: flex;">
                    <div class="col-md-9" style="align-self: flex-start;">
                        <canvas id="myChart" style="height: 450px;"></canvas>
                    </div>
                    <div class="col-md-3" style="align-self: center;">
                        {{-- Start-day --}}
                        <div class="text-center"
                            style="background: rgb(255, 255, 255); border: 1px solid rgb(0, 34, 68);">
                            <h5
                                style="background: rgb(0, 34, 68); margin-top: 0; margin-bottom: 0; font-weight: 500; padding: 5px 0;">
                                금일 수익금액</h5>
                            <div>
                                <p style="line-height: 80px;">
                                    <strong
                                        style="font-weight: 700; font-size: 20px;">{{ formatNumber(abs($sum_money_interest_today)) }}원</strong>
                                </p>
                                <p style="font-size: 14px;">
                                    <i class=" blue" @class([
                                        'glyphicon glyphicon-arrow-up',
                                        'glyphicon-arrow-up blue' => $sum_money_compare_today >= 0,
                                        'glyphicon-arrow-down red' => $sum_money_compare_today < 0,
                                    ])></i>
                                    <span class="text-gray m-l-20">전일대비</span>
                                    @if ($sum_money_compare_today >= 0)
                                        <span class="blue">+ {{ formatNumber($sum_money_compare_today) }}원 하락</span>
                                    @else
                                        <span class="red">- {{ formatNumber(abs($sum_money_compare_today)) }}원
                                            하락</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        {{-- End-day --}}
                        <div class="text-center"
                            style="background: rgb(255, 255, 255); border: 1px solid rgb(0, 34, 68); margin-top: 20px;">
                            <h5
                                style="background: rgb(0, 34, 68); margin-top: 0; margin-bottom: 0; font-weight: 500; padding: 5px 0;">
                                금일 배팅손익</h5>
                            <div>
                                <p style="line-height: 80px;">
                                    <strong
                                        style="font-weight: 700; font-size: 20px;">{{ formatNumber(abs($total_bet_today)) }}원</strong>
                                </p>
                                <p style="font-size: 14px;">
                                    <i class=" blue" @class([
                                        'glyphicon glyphicon-arrow-up',
                                        'glyphicon-arrow-up blue' => $sum_bet_compare_to_day >= 0,
                                        'glyphicon-arrow-down red' => $sum_bet_compare_to_day < 0,
                                    ])></i>
                                    <span class="text-gray m-l-20">전일대비</span>
                                    @if ($sum_bet_compare_to_day >= 0)
                                        <span class="blue">+ {{ formatNumber($sum_bet_compare_to_day) }}원 하락</span>
                                    @else
                                        <span class="red">- {{ formatNumber(abs($sum_bet_compare_to_day)) }}원
                                            하락</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="text-center"
                            style="background: rgb(255, 255, 255); border: 1px solid rgb(0, 34, 68); margin-top: 20px;">
                            <h5
                                style="background: rgb(0, 34, 68); margin-top: 0; margin-bottom: 0; font-weight: 500; padding: 5px 0;">
                                금일 수익현황</h5>
                            <div>
                                <p style="line-height: 80px;">
                                    <strong
                                        style="font-weight: 700; font-size: 20px;">{{ formatNumber(abs($sum_money_interest_this_month)) }}원</strong>
                                </p>
                                <p style="font-size: 14px;">
                                    <i @class([
                                        'glyphicon',
                                        'glyphicon-arrow-up blue' => $sum_money_compare >= 0,
                                        'glyphicon-arrow-down red' => $sum_money_compare < 0,
                                    ])></i>
                                    <span class="text-gray m-l-20">전일대비</span>
                                    @if ($sum_money_compare >= 0)
                                        <span class="blue">+ {{ formatNumber($sum_money_compare) }}원 하락</span>
                                    @else
                                        <span class="red">- {{ formatNumber(abs($sum_money_compare)) }}원 하락</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="text-center"
                            style="background: rgb(255, 255, 255); border: 1px solid rgb(0, 34, 68); margin-top: 20px;">
                            <h5
                                style="background: rgb(0, 34, 68); margin-top: 0; margin-bottom: 0; font-weight: 500; padding: 5px 0;">
                                당월 배팅손익</h5>
                            <div>
                                <p style="line-height: 80px;">
                                    <strong
                                        style="font-weight: 700; font-size: 20px;">{{ formatNumber(abs($total_bet_month)) }}원</strong>
                                </p>
                                <p style="font-size: 14px;">
                                    <i @class([
                                        'glyphicon',
                                        'glyphicon-arrow-up blue' => $sum_bet_month >= 0,
                                        'glyphicon-arrow-down red' => $sum_bet_month < 0,
                                    ])></i>
                                    <span class="text-gray m-l-20">전일대비</span>
                                    @if ($sum_bet_month >= 0)
                                        <span class="blue">+ {{ formatNumber($sum_bet_month) }}원 하락</span>
                                    @else
                                        <span class="red">- {{ formatNumber(abs($sum_bet_month)) }}원 하락</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END Main Content -->
<!-- BEGIN Main Content -->
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <x-common.panel_heading title="게임별 수익률" />
            <div class="box-content">
                <div class="table-contents-chart">
                    <table class="table table-bordered cst-table-darkbrown">
                        <thead>
                            <tr>
                                <th style="width: 200px"></th>
                                <th @class(['text-center'])>스포츠</th>
                                <th @class(['text-center'])>실시간</th>
                                <th @class(['text-center'])>미니게임</th>
                                <th @class(['text-center'])>가상스포츠</th>
                                <th @class(['text-center'])>카지노</th>
                                <th @class(['text-center'])>슬롯</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th @class(['text-center'])>
                                    롤링금액
                                    (배팅금액)
                                </th>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td @class(['text-center'])>
                                    {{ formatNumber($sum_bet_minus_win_this_month_casino) }}원
                                </td @class(['text-center'])>
                                <td @class(['text-center'])>
                                    {{ formatNumber($sum_bet_minus_win_this_month_slot) }}원
                                </td>
                            </tr>
                            <tr>
                                <th @class(['text-center'])>
                                    수익금
                                </th>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td @class(['text-center'])>
                                    {{ formatNumber($sum_win_this_month_casino) }}원
                                </td>
                                <td @class(['text-center'])>
                                    {{ formatNumber($sum_win_this_month_slot) }}원
                                </td>
                            </tr>
                            <tr>
                                <th @class(['text-center'])>
                                    승률
                                </th>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td @class(['text-center'])>
                                    {{ $rate_win_this_month_casino }}%
                                </td>
                                <td @class(['text-center'])>
                                    {{ $rate_win_this_month_slot }}%
                                </td>
                            </tr>
                            <tr>
                                <th @class(['text-center'])>
                                    배팅회원수
                                </th>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td @class(['text-center'])>
                                    {{ $count_member_batting_this_month_casino }}명
                                </td>
                                <td @class(['text-center'])>
                                    {{ $count_member_batting_this_month_slot }}명
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="title-chart">
                                <p class="cst_panel-title d-inline-block">
                                <h5 class="pull-left text-white" style="background: rgb(0, 34, 68);">
                                    <strong>스포츠 금일 현황차트</strong>
                                </h5>
                                <h5 class="pull-right text-white" style="background: rgb(0, 34, 68);">
                                    <strong>명</strong>
                                </h5>
                                </p>
                                <div>
                                    <canvas id="sportsChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="title-chart">
                                <p class="cst_panel-title d-inline-block">
                                <h5 class="pull-left text-white" style="background: rgb(0, 34, 68);">
                                    <strong>실시간 금일 현황차트</strong>
                                </h5>
                                <h5 class="pull-right text-white" style="background: rgb(0, 34, 68);">
                                    <strong>0명</strong>
                                </h5>
                                </p>
                                <div>
                                    <canvas id="realTimeChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="title-chart">
                                <p class="cst_panel-title d-inline-block">
                                <h5 class="pull-left text-white" style="background: rgb(0, 34, 68);">
                                    <strong>카지노 금일 현황차트</strong>
                                </h5>
                                <h5 class="pull-right text-white" style="background: rgb(0, 34, 68);">
                                    <strong>{{ $count_member_batting_this_month_casino }}명</strong>
                                </h5>
                                </p>
                                <div>
                                    <canvas id="casinoChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-20">
                        <div class="col-md-4">
                            <div class="title-chart">
                                <p class="cst_panel-title d-inline-block">
                                <h5 class="pull-left text-white" style="background: rgb(0, 34, 68);">
                                    <strong>미니게임 금일 현황차트</strong>
                                </h5>
                                <h5 class="pull-right text-white" style="background: rgb(0, 34, 68);">
                                    <strong>0명</strong>
                                </h5>
                                </p>
                                <div>
                                    <canvas id="miniGameChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="title-chart">
                                <p class="cst_panel-title d-inline-block">
                                <h5 class="pull-left text-white" style="background: rgb(0, 34, 68);">
                                    <strong>가상스포츠 금일 현황차트</strong>
                                </h5>
                                <h5 class="pull-right text-white" style="background: rgb(0, 34, 68);">
                                    <strong>0명</strong>
                                </h5>
                                </p>
                                <div>
                                    <canvas id="virtualSportsChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="title-chart">
                                <p class="cst_panel-title d-inline-block">
                                <h5 class="pull-left text-white" style="background: rgb(0, 34, 68);">
                                    <strong>슬롯 금일 현황차트</strong>
                                </h5>
                                <h5 class="pull-right text-white" style="background: rgb(0, 34, 68);">
                                    <strong>{{ $count_member_batting_this_month_slot }}명</strong>
                                </h5>
                                </p>
                                <div>
                                    <canvas id="slotChart"></canvas>
                                </div>
                            </div>
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
