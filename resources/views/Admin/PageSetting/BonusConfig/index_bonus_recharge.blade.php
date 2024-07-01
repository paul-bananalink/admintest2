@extends('Admin.PageSetting.index')

@section('content-child-child')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                @include('Admin.PageSetting.BonusConfig.action_box')
                <div class="d-flex-space-between p-10">
                    <h3 class="cst_h3"><i class="fa fa-gear"></i> 지급 포인트설정</h3>
                </div>
                <div class="box-content">
                    <form action="{{route('admin.page-setting.bonus-config.updateBonusRecharge')}}" method="POST" id="bonus_config_index_bonus_recharge">
                        @csrf
                        <table class="table table-bordered cst-table-darkbrown" border="1">
                            <tr>
                                <th rowspan="2" class="text-center">
                                    <button type="submit" class="btnstyle1-success btnstyle1 btnstyle1-sm height-30 text-nowrap"><i class="fa fa-gear"></i> 설정값 저장</button>
                                </th>

                                <th colspan="3" class="center-middel">스포츠 첫중전(%)</th>

                                <th colspan="3" class="center-middel">스포츠 매충전(%)</th>

                                <th colspan="3" class="center-middel">카지노 첫 충전(%)</th>

                                <th colspan="3" class="center-middel">카지노 매 충전(%)</th>

                                <th colspan="3" class="center-middel">포커 첫 충전(%)</th>

                                <th colspan="3" class="center-middel">포커 매 충전(%)</th>
                            </tr>
                            <tr>

                                <th>평일요율</th>
                                <th>주말요율</th>
                                <th>환전시지급여부</th>

                                <th>평일요율</th>
                                <th>주말요율</th>
                                <th>환전시지급여부</th>

                                <th>평일요율</th>
                                <th>주말요율</th>
                                <th>환전시지급여부</th>

                                <th>평일요율</th>
                                <th>주말요율</th>
                                <th>환전시지급여부</th>

                                <th>평일요율</th>
                                <th>주말요율</th>
                                <th>환전시지급여부</th>
                                
                                <th>평일요율</th>
                                <th>주말요율</th>
                                <th>환전시지급여부</th>
                            </tr>

                            @foreach (config("site_config.LEVELS") as $level)
                                <tr>
                                    <td>{{$level}}레벨</td>

                                    @include('Admin.PageSetting.BonusConfig.item_bonus_recharge', [
                                        'level' => $level, 
                                        'group' => 'sports_first_time_recharge',
                                    ])

                                    @include('Admin.PageSetting.BonusConfig.item_bonus_recharge', [
                                        'level' => $level, 
                                        'group' => 'sports_recharge'
                                    ])

                                    @include('Admin.PageSetting.BonusConfig.item_bonus_recharge', [
                                        'level' => $level,
                                        'group' => 'casino_first_time_recharge'
                                    ])

                                    @include('Admin.PageSetting.BonusConfig.item_bonus_recharge', [
                                        'level' => $level, 
                                        'group' => 'casino_recharge'
                                    ])

                                    @include('Admin.PageSetting.BonusConfig.item_bonus_recharge', [
                                        'level' => $level, 
                                        'group' => 'poker_first_time_recharge'
                                    ])

                                    @include('Admin.PageSetting.BonusConfig.item_bonus_recharge', [
                                        'level' => $level, 
                                        'group' => 'poker_recharge'
                                    ])
                                </tr>
                            @endforeach
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-css')
    <style>
        .table .switch{
            margin-bottom: 0
        }
        .table input[type="number"]{
            border: none;
            padding: 5px;
        }
        .table .center-middel{
            text-align: center;
            vertical-align:middle;
        }
        .table th {
            text-align: center;
        }
    </style>
    @vite(['resources/vite/css/toggle-switch/toggle_style.css'])
@endsection

@section('custom-js')
    @vite([
        'resources/vite/js/toggle_switch/toggle_switch.js', 
        'resources/vite/js/page_setting/format_money.js'
    ])
@endsection
