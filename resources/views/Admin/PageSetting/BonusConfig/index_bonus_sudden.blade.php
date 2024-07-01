@extends('Admin.PageSetting.index')

@section('content-child-child')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                @include('Admin.PageSetting.BonusConfig.action_box')
                <form action="{{ route('admin.page-setting.bonus-config.updateBonusSudden') }}" method="POST"
                    id="bonus_config_index_bonus_sudden">
                    @csrf
                    <div class="d-flex-space-between p-10">
                        <h3 class="cst_h3"><i class="fa fa-gear"></i> 돌발 입금 보너스 사용 설정</h3>
                        <div class="d-flex gap-10">
                            <div class="flex">
                                <div class="flex mb-6">
                                    <div class="calendar-single radius-4 mr-3">
                                        <i class="fa fa-calendar text-light mr-6" aria-hidden="true"></i>
                                        <input class="js__calendar-single" type="text" name="from_date"
                                            value="{{ data_get($data, 'from_date') }}">
                                    </div>
                                    <div class="calendar-single radius-4 mr-6">
                                        <i class="fa fa-clock-o text-light mr-6" aria-hidden="true"></i>
                                        <input class="js__calendar-minus" type="text" name="from_time"
                                            value="{{ data_get($data, 'from_time') }}">
                                    </div> -
                                </div>
                                <div class="flex">
                                    <div class="calendar-single radius-4 mr-3">
                                        <i class="fa fa-calendar text-light mr-6" aria-hidden="true"></i>
                                        <input class="js__calendar-single" type="text" name="to_date"
                                            value="{{ data_get($data, 'to_date') }}">
                                    </div>
                                    <div class="calendar-single radius-4">
                                        <i class="fa fa-clock-o text-light mr-6" aria-hidden="true"></i>
                                        <input class="js__calendar-minus" type="text" name="to_time"
                                            value="{{ data_get($data, 'to_time') }}">
                                    </div>
                                </div>
                            </div>
                            <x-common.toggle_switch_button content="사용" contentOff="미사용"
                                isCheck="{{ data_get($data, 'is_available') }}" id="sudden_bonus-is_available"
                                name="sudden_bonus-is_available"
                                urlAction="{{ route('admin.page-setting.bonus-config.toggle-json-field-bonus-config', [
                                    'field' => 'sudden_bonus[is_available]',
                                    'bonusType' => \App\Models\BonusConfig::TYPE_SUDDEN_BONUS,
                                ]) }}"
                                width="100px" size="big" />
                            <button type="submit" form="bonus_config_index_bonus_sudden"
                                class="btnstyle1-success btnstyle1 btnstyle1-sm height-30"><i class="fa fa-gear"></i> 설졍값
                                저장</button>
                        </div>
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
                        <div class="col-md-12 m-0 p-0">
                            <div class="col-md-12 p-0">
                                <div class="col-md-3 p-3">
                                    <x-common.setting_item title="최대 지급한도" sub-title="돌발 보너스 최대 지급 금액">
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <input
                                                class="form-control width-full search-input-box height-33 text-white2 p-5"
                                                type="input" name="sudden_bonus[maximum_sudden_amount]"
                                                value="{{ data_get($data, 'maximum_sudden_amount') }}"
                                                placeholder="">
                                        </div>
                                    </x-common.setting_item>
                                </div>
                                <div class="col-md-3 p-3">
                                    <x-common.setting_item title="참여가능 횟수" sub-title="회원별 참여가능한 횟수입니다.">
                                        <div class="bg-black-2 col-md-12 height-full p-t-17 p-b-17">
                                            <input
                                                class="form-control width-full search-input-box height-33 text-white2 p-5"
                                                type="input" name="sudden_bonus[participation_per_member_count]"
                                                value="{{ data_get($data, 'participation_per_member_count') }}"
                                                placeholder="">
                                        </div>
                                    </x-common.setting_item>
                                </div>
                            </div>
                            <div class="col-md-12 p-0">
                                <table class="table table-bordered cst-table-darkbrown table-fixed-columns" border="1">
                                    <tr>
                                        <th class="text-center" rowspan="2" style="width: 120px"></th>
                                        <th colspan="2" class="center-middel">스포츠 첫 중전(%)</th>
                                        <th colspan="2" class="center-middel">스포츠 매 충전(%)</th>
                                        <th colspan="2" class="center-middel">카지노 첫 충전(%)</th>
                                        <th colspan="2" class="center-middel">카지노 매 충전(%)</th>
                                        <th colspan="2" class="center-middel">포커 첫 충전(%)</th>
                                        <th colspan="2" class="center-middel">포커 매 충전(%)</th>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">돌발요율</th>
                                        <th class="text-nowrap">환전시지급여부</th>

                                        <th class="text-nowrap">돌발요율</th>
                                        <th class="text-nowrap">환전시지급여부</th>

                                        <th class="text-nowrap">돌발요율</th>
                                        <th class="text-nowrap">환전시지급여부</th>

                                        <th class="text-nowrap">돌발요율</th>
                                        <th class="text-nowrap">환전시지급여부</th>

                                        <th class="text-nowrap">돌발요율</th>
                                        <th class="text-nowrap">환전시지급여부</th>

                                        <th class="text-nowrap">돌발요율</th>
                                        <th class="text-nowrap">환전시지급여부</th>
                                    </tr>
                                    @foreach (config('site_config.LEVELS') as $level)
                                        <tr>
                                            <td class="text-nowrap">{{ $level }}레벨</td>

                                            @include('Admin.PageSetting.BonusConfig.item_bonus_sudden', [
                                                'level' => $level,
                                                'group' => 'sports_first_time_recharge',
                                            ])

                                            @include('Admin.PageSetting.BonusConfig.item_bonus_sudden', [
                                                'level' => $level,
                                                'group' => 'sports_recharge',
                                            ])

                                            @include('Admin.PageSetting.BonusConfig.item_bonus_sudden', [
                                                'level' => $level,
                                                'group' => 'casino_first_time_recharge',
                                            ])

                                            @include('Admin.PageSetting.BonusConfig.item_bonus_sudden', [
                                                'level' => $level,
                                                'group' => 'casino_recharge',
                                            ])

                                            @include('Admin.PageSetting.BonusConfig.item_bonus_sudden', [
                                                'level' => $level,
                                                'group' => 'poker_first_time_recharge',
                                            ])

                                            @include('Admin.PageSetting.BonusConfig.item_bonus_sudden', [
                                                'level' => $level,
                                                'group' => 'poker_recharge',
                                            ])
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('custom-css')
    @vite(['resources/vite/css/toggle-switch/toggle_style.css'])
@endsection

@section('custom-js')
    @vite(['resources/vite/js/toggle_switch/toggle_switch.js', 'resources/vite/js/page_setting/format_money.js'])
@endsection
